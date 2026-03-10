<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shaykhnazar\HikvisionIsapi\DTOs\Person;
use Shaykhnazar\HikvisionIsapi\Enums\UserType;
use Shaykhnazar\HikvisionIsapi\Services\DeviceService;
use Shaykhnazar\HikvisionIsapi\Services\FingerprintService;
use Shaykhnazar\HikvisionIsapi\Services\PersonService;
use Shaykhnazar\HikvisionIsapi\Services\AccessControlService;
use Shaykhnazar\HikvisionIsapi\Services\EventNotificationService;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class HikvisionController extends Controller
{
    /**
     * Constructor
     */
    function __construct(
        private readonly DeviceService $deviceService,
        private readonly FingerprintService $fingerprintService,
        private readonly PersonService $personService,
        private readonly AccessControlService $accessControlService,
        private readonly EventNotificationService $eventNotificationService
    ) {
        $this->middleware('permission:company-read|company-update', ['only' => ['index']]);
        $this->middleware('permission:company-update', ['only' => ['updateDevice', 'addUser', 'deleteUser', 'openDoor', 'closeDoor', 'configureNotification']]);
    }

    /**
     * Display Hikvision settings page
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        if (empty(Session::get('company_id'))) {
            return redirect()->route('company.index')->withError('Create Company First');
        }

        try {
            // Get device info
            $deviceInfo = $this->deviceService->getInfo();
            $deviceStatus = $this->deviceService->getStatus();
            $deviceCapabilities = $this->deviceService->getCapabilities();
            $isOnline = $this->deviceService->isOnline();

            // Get fingerprint capabilities
            $fingerprintCapabilities = $this->fingerprintService->getCapabilities();

            // Get person count
            $personCount = $this->personService->count();

            // Get notification capabilities
            $notificationCapabilities = $this->eventNotificationService->getCapabilities();

            // Get notification hosts
            $notificationHosts = $this->eventNotificationService->getAllHttpHosts();

            // Get system users for adding to device
            $users = User::where('company_id', Session::get('company_id'))
                ->where('status', 'active')
                ->get();

            return view('settings.hikvision.index', compact(
                'deviceInfo',
                'deviceStatus',
                'deviceCapabilities',
                'isOnline',
                'fingerprintCapabilities',
                'personCount',
                'notificationCapabilities',
                'notificationHosts',
                'users'
            ));
        } catch (\Exception $e) {
            Log::error('Hikvision connection error: ' . $e->getMessage());
            return view('settings.hikvision.index', [
                'error' => 'Failed to connect to Hikvision device: ' . $e->getMessage(),
                'deviceInfo' => null,
                'deviceStatus' => null,
                'deviceCapabilities' => null,
                'isOnline' => false,
                'fingerprintCapabilities' => null,
                'personCount' => 0,
                'notificationCapabilities' => null,
                'notificationHosts' => [],
                'users' => User::where('company_id', Session::get('company_id'))->where('status', 'active')->get()
            ]);
        }
    }

    /**
     * Get device info (AJAX)
     */
    public function getDeviceInfo()
    {
        try {
            $info = $this->deviceService->getInfo();
            $status = $this->deviceService->getStatus();
            $isOnline = $this->deviceService->isOnline();

            return response()->json([
                'success' => true,
                'data' => [
                    'info' => $info,
                    'status' => $status,
                    'isOnline' => $isOnline
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get fingerprints (AJAX)
     */
    public function getFingerprints(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $maxResults = $request->get('maxResults', 30);
            $employeeNo = $request->get('employeeNo');

            $fingerprints = $this->fingerprintService->search($page, $maxResults, $employeeNo);

            return response()->json([
                'success' => true,
                'data' => $fingerprints
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get users from device (AJAX)
     */
    public function getDeviceUsers(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $maxResults = $request->get('maxResults', 30);

            $persons = $this->personService->search($page, $maxResults);

            return response()->json([
                'success' => true,
                'data' => $persons
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Add user to device
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $user = User::findOrFail($request->user_id);

            // Create person for Hikvision device
            $person = new Person(
                employeeNo: $user->id,
                name: $user->name,
                userType: UserType::NORMAL,
                validEnabled: true,
                email: $user->email,
                phoneNumber: $user->phone,
                beginTime: date('Y-m-d H:i:s'),
                endTime: '2037-12-31 23:59:59'
            );

            // Add person to device
            $response = $this->personService->add($person);

            // Apply the person
            $this->personService->apply($person);

            return response()->json([
                'success' => true,
                'message' => 'User added to device successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding user to device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete fingerprint from device
     */
    public function deleteFingerprint(Request $request)
    {
        $request->validate([
            'employee_no' => 'required',
        ]);

        try {
            $response = $this->fingerprintService->delete([$request->employee_no]);

            return response()->json([
                'success' => true,
                'message' => 'Fingerprint removed from device successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting fingerprint from device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete user from device
     */
    public function deleteUser(Request $request)
    {
        $request->validate([
            'employee_no' => 'required',
        ]);

        try {
            $response = $this->personService->delete([$request->employee_no]);

            return response()->json([
                'success' => true,
                'message' => 'User removed from device successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting user from device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get door status (AJAX)
     */
    public function getDoorStatus(Request $request)
    {
        $request->validate([
            'door_no' => 'required|integer|min:1',
        ]);

        try {
            $status = $this->accessControlService->getDoorStatus($request->door_no);

            return response()->json([
                'success' => true,
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Open door
     */
    public function openDoor(Request $request)
    {
        $request->validate([
            'door_no' => 'required|integer|min:1',
        ]);

        try {
            $response = $this->accessControlService->openDoor($request->door_no);

            return response()->json([
                'success' => true,
                'message' => 'Door opened successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error opening door: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Close door
     */
    public function closeDoor(Request $request)
    {
        $request->validate([
            'door_no' => 'required|integer|min:1',
        ]);

        try {
            $response = $this->accessControlService->closeDoor($request->door_no);

            return response()->json([
                'success' => true,
                'message' => 'Door closed successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error closing door: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Configure notification
     */
    public function configureNotification(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'host_id' => 'required|integer|min:1|max:8',
            'protocol' => 'required|in:HTTP,HTTPS',
            'port' => 'required|integer|min:1|max:65535',
        ]);

        try {
            $response = $this->eventNotificationService->configureHttpHost(
                url: $request->url,
                id: $request->host_id,
                protocol: $request->protocol,
                port: $request->port,
                httpAuthType: $request->http_auth_type ?? 'none',
                username: $request->username ?? null,
                password: $request->password ?? null,
                eventTypes: $request->event_types ?? []
            );

            return response()->json([
                'success' => true,
                'message' => 'Notification configured successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error configuring notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get notification hosts (AJAX)
     */
    public function getNotificationHosts()
    {
        try {
            $hosts = $this->eventNotificationService->getAllHttpHosts();

            return response()->json([
                'success' => true,
                'data' => $hosts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete notification host
     */
    public function deleteNotificationHost(Request $request)
    {
        $request->validate([
            'host_id' => 'required|integer|min:1|max:8',
        ]);

        try {
            $response = $this->eventNotificationService->removeHttpHost($request->host_id);

            return response()->json([
                'success' => true,
                'message' => 'Notification host removed successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting notification host: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Test notification
     */
    public function testNotification(Request $request)
    {
        $request->validate([
            'host_id' => 'required|integer|min:1|max:8',
        ]);

        try {
            $response = $this->eventNotificationService->testHttpNotification($request->host_id);

            return response()->json([
                'success' => true,
                'message' => 'Notification test sent successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Error testing notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get alert stream from Hikvision device
     */
    public function getAlertStream()
    {
        try {
            $deviceConfig = config('hikvision.devices.' . config('hikvision.default'));
            
            $ip = $deviceConfig['ip'];
            $port = $deviceConfig['port'];
            $username = $deviceConfig['username'];
            $password = $deviceConfig['password'];
            $protocol = $deviceConfig['protocol'];
            $timeout = $deviceConfig['timeout'];

            $url = "{$protocol}://{$ip}:{$port}/ISAPI/Event/notification/alertStream";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $deviceConfig['verify_ssl']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $deviceConfig['verify_ssl']);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                Log::error('CURL error getting alert stream: ' . $error);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to connect to Hikvision device: ' . $error
                ]);
            }

            if ($httpCode !== 200) {
                Log::error('HTTP error getting alert stream: ' . $httpCode);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get alert stream. HTTP code: ' . $httpCode
                ]);
            }

            // Parse the multipart response
            $alerts = $this->parseAlertStream($response);

            return response()->json([
                'success' => true,
                'data' => $alerts
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting alert stream: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
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
     * Start alert listener (long polling)
     */
    public function startAlertListener()
    {
        try {
            $deviceConfig = config('hikvision.devices.' . config('hikvision.default'));
            
            $ip = $deviceConfig['ip'];
            $port = $deviceConfig['port'];
            $username = $deviceConfig['username'];
            $password = $deviceConfig['password'];
            $protocol = $deviceConfig['protocol'];
            $timeout = $deviceConfig['timeout'];

            $url = "{$protocol}://{$ip}:{$port}/ISAPI/Event/notification/alertStream";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");
            curl_setopt($ch, CURLOPT_TIMEOUT, 0); // No timeout for long polling
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
                echo $data;
                ob_flush();
                flush();
                return strlen($data);
            });
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $deviceConfig['verify_ssl']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $deviceConfig['verify_ssl']);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                Log::error('CURL error in alert listener: ' . $error);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to connect to Hikvision device: ' . $error
                ]);
            }

            return response($response);
        } catch (\Exception $e) {
            Log::error('Error in alert listener: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get recent alerts (cached)
     */
    public function getRecentAlerts()
    {
        try {
            $alerts = cache()->get('hikvision_alerts', []);
            
            return response()->json([
                'success' => true,
                'data' => $alerts
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting recent alerts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store alert from webhook
     */
    public function storeAlert(Request $request)
    {
        try {
            $alert = $request->all();
            
            // Get existing alerts
            $alerts = cache()->get('hikvision_alerts', []);
            
            // Add new alert at the beginning
            array_unshift($alerts, $alert);
            
            // Keep only last 100 alerts
            $alerts = array_slice($alerts, 0, 100);
            
            // Store in cache for 24 hours
            cache()->put('hikvision_alerts', $alerts, now()->addHours(24));
            
            // Log the alert
            Log::info('Hikvision alert received', $alert);
            
            return response()->json([
                'success' => true,
                'message' => 'Alert stored successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing alert: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Clear all alerts
     */
    public function clearAlerts()
    {
        try {
            cache()->forget('hikvision_alerts');
            
            Log::info('Hikvision alerts cleared');
            
            return response()->json([
                'success' => true,
                'message' => 'Alerts cleared successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error clearing alerts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
