<?php

namespace App\Console\Commands;

use App\Models\HkAttendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ListenToHikvisionAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hikvision:listen-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to Hikvision device for access control alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Hikvision alert listener...');
        $this->info('Press Ctrl+C to stop.');

        $deviceConfig = config('hikvision.devices.' . config('hikvision.default'));
        
        $ip = $deviceConfig['ip'];
        $port = $deviceConfig['port'];
        $username = $deviceConfig['username'];
        $password = $deviceConfig['password'];
        $protocol = $deviceConfig['protocol'];

        $url = "{$protocol}://{$ip}:{$port}/ISAPI/Event/notification/alertStream";

        $this->info("Connecting to: {$url}");

        while (true) {
            try {
                $this->info('Fetching alerts...');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
                curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $deviceConfig['verify_ssl']);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $deviceConfig['verify_ssl']);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);

                if ($error) {
                    $this->error("CURL error: {$error}");
                    Log::error('Hikvision alert listener CURL error: ' . $error);
                    sleep(10);
                    continue;
                }

                if ($httpCode !== 200) {
                    $this->error("HTTP error: {$httpCode}");
                    Log::error('Hikvision alert listener HTTP error: ' . $httpCode);
                    sleep(10);
                    continue;
                }

                // Parse the response
                $alerts = $this->parseAlertStream($response);

                if (!empty($alerts)) {
                    $this->info("Received " . count($alerts) . " alert(s)");
                    
                    // Get existing alerts
                    $existingAlerts = Cache::get('hikvision_alerts', []);
                    
                    // Add new alerts at the beginning
                    foreach (array_reverse($alerts) as $alert) {
                        // Check if this alert already exists (by serialNo)
                        $exists = false;
                        $serialNo = $alert['AccessControllerEvent']['serialNo'] ?? null;
                        
                        if ($serialNo) {
                            foreach ($existingAlerts as $existing) {
                                if (isset($existing['AccessControllerEvent']['serialNo']) && 
                                    $existing['AccessControllerEvent']['serialNo'] === $serialNo) {
                                    $exists = true;
                                    break;
                                }
                            }
                        }
                        
                        if (!$exists) {
                            array_unshift($existingAlerts, $alert);
                            
                            // Log the alert
                            $employeeNo = $alert['AccessControllerEvent']['employeeNoString'] ?? 'unknown';
                            $eventDescription = $this->getEventDescription($alert['AccessControllerEvent']['subEventType'] ?? 0);
                            Log::info("Hikvision alert - Employee: {$employeeNo}, Event: {$eventDescription}");
                            
                            // Save to hk_attendance table
                            $this->saveAlertToAttendance($alert);
                        }
                    }
                    
                    // Keep only last 100 alerts
                    $existingAlerts = array_slice($existingAlerts, 0, 100);
                    
                    // Store in cache for 24 hours
                    Cache::put('hikvision_alerts', $existingAlerts, now()->addHours(24));
                }

                // Wait before next poll
                sleep(5);

            } catch (\Exception $e) {
                $this->error("Error: {$e->getMessage()}");
                Log::error('Hikvision alert listener error: ' . $e->getMessage());
                sleep(10);
            }
        }
    }

    /**
     * Parse alert stream response
     */
    private function parseAlertStream($response)
    {
        $alerts = [];
        
        // Split by boundary
        $parts = explode('--boundary', $response);
        
        foreach ($parts as $part) {
            // Skip empty parts
            if (empty(trim($part))) {
                continue;
            }
            
            // Find JSON content
            if (preg_match('/\{[\s\S]*\}/', $part, $matches)) {
                $json = $matches[0];
                $alert = json_decode($json, true);
                
                if ($alert && isset($alert['eventType']) && $alert['eventType'] === 'AccessControllerEvent') {
                    $alerts[] = $alert;
                }
            }
        }
        
        return $alerts;
    }

    /**
     * Get event description based on sub event type
     */
    private function getEventDescription($subEventType)
    {
        $eventTypes = [
            22 => 'Door Opened',
            38 => 'Card Authentication',
            39 => 'Fingerprint Authentication',
            40 => 'Face Authentication',
            41 => 'Password Authentication',
        ];

        return $eventTypes[$subEventType] ?? 'Unknown Event';
    }

    /**
     * Save alert to hk_attendance table
     */
    private function saveAlertToAttendance($alert)
    {
        try {
            $accessEvent = $alert['AccessControllerEvent'] ?? [];
            $serialNo = $accessEvent['serialNo'] ?? null;

            // Check if this alert already exists in the database
            if ($serialNo && HkAttendance::where('serial_no', $serialNo)->exists()) {
                $this->info("Alert with serial no {$serialNo} already exists in database, skipping...");
                return;
            }

            // Parse the date time
            $dateTime = null;
            if (isset($alert['dateTime'])) {
                try {
                    $dateTime = \Carbon\Carbon::parse($alert['dateTime']);
                } catch (\Exception $e) {
                    Log::error('Error parsing alert date time: ' . $e->getMessage());
                }
            }

            // Create attendance record
            HkAttendance::create([
                'ip_address' => $alert['ipAddress'] ?? null,
                'port_no' => $alert['portNo'] ?? null,
                'protocol' => $alert['protocol'] ?? null,
                'date_time' => $dateTime,
                'event_type' => $alert['eventType'] ?? null,
                'event_state' => $alert['eventState'] ?? null,
                'event_description' => $alert['eventDescription'] ?? null,
                'device_name' => $accessEvent['deviceName'] ?? null,
                'major_event_type' => $accessEvent['majorEventType'] ?? null,
                'sub_event_type' => $accessEvent['subEventType'] ?? null,
                'card_type' => $accessEvent['cardType'] ?? null,
                'card_reader_no' => $accessEvent['cardReaderNo'] ?? null,
                'door_no' => $accessEvent['doorNo'] ?? null,
                'employee_no_string' => $accessEvent['employeeNoString'] ?? null,
                'serial_no' => $serialNo,
                'user_type' => $accessEvent['userType'] ?? null,
                'attendance_status' => $accessEvent['attendanceStatus'] ?? null,
                'status_value' => $accessEvent['statusValue'] ?? null,
                'pictures_number' => $accessEvent['picturesNumber'] ?? null,
                'pure_pwd_verify_enable' => $accessEvent['purePwdVerifyEnable'] ?? null,
                'raw_data' => $alert,
            ]);

            $this->info("Alert saved to hk_attendance table (serial no: {$serialNo})");
        } catch (\Exception $e) {
            Log::error('Error saving alert to hk_attendance: ' . $e->getMessage());
            $this->error("Error saving alert to database: {$e->getMessage()}");
        }
    }
}
