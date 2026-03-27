<?php

namespace App\Console\Commands;

use App\Models\DoctorAssignment;
use App\Models\TherapyReport;
use Illuminate\Console\Command;

class UpdateTherapyReportPatientIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'therapy:update-patient-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add patient_id to individual therapy reports that dont have patient_id based on doctor schedule and time from doctor-assignments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating therapy reports with missing patient IDs...');

        $updatedCount = 0;
        $notFoundCount = 0;

        // Get individual therapy reports without patient_id (exclude group therapy reports)
        $therapyReports = TherapyReport::whereNull('patient_id')
            ->whereNull('participant_ids')
            ->whereNull('ward_id')
            ->get();

        $this->info("Found {$therapyReports->count()} individual therapy reports without patient_id");

        foreach ($therapyReports as $report) {
            // Parse session_time from format "8:00 AM - 9:00 AM" to get start time
            $sessionStartTime = $this->parseSessionTime($report->session_time);
            
            if (!$sessionStartTime) {
                $this->warn("Could not parse session_time for therapy report ID {$report->id}: {$report->session_time}");
                $notFoundCount++;
                continue;
            }

            // Find matching doctor assignment based on:
            // 1. physiotherapist_id matches doctor_id
            // 2. session start time matches assignment start time
            // 3. assignment has a patient_id (not null - exclude ward assignments)
            // Note: We're not matching on date due to inconsistent data in the database
            
            $assignment = DoctorAssignment::where('doctor_id', $report->physiotherapist_id)
                ->where('status', '!=', 'cancelled')
                ->whereNotNull('patient_id')
                ->where(function ($query) use ($sessionStartTime) {
                    // Match the time part of start_time (format: HH:mm:ss)
                    $query->whereRaw('TIME(start_time) = ?', [$sessionStartTime]);
                })
                ->first();

            if ($assignment && $assignment->patient_id) {
                // Update the therapy report with the patient_id
                $report->patient_id = $assignment->patient_id;
                $report->save();
                
                $updatedCount++;
                $this->info("Updated therapy report ID {$report->id} with patient_id {$assignment->patient_id}");
            } else {
                $notFoundCount++;
                $this->warn("No matching doctor assignment found for therapy report ID {$report->id}");
            }
        }

        $this->info("\nSummary:");
        $this->info("Total individual therapy reports processed: {$therapyReports->count()}");
        $this->info("Successfully updated: {$updatedCount}");
        $this->info("No matching assignment found: {$notFoundCount}");
        $this->info('Individual therapy report patient IDs update completed successfully!');

        return 0;
    }

    /**
     * Parse session_time from format "8:00 AM - 9:00 AM" to get start time in HH:mm:ss format
     *
     * @param string $sessionTime
     * @return string|null
     */
    private function parseSessionTime($sessionTime)
    {
        // Split by " - " to get start and end times
        $parts = explode(' - ', $sessionTime);
        
        if (count($parts) < 2) {
            return null;
        }

        $startTimeStr = trim($parts[0]); // e.g., "8:00 AM"
        
        // Parse the time using Carbon
        try {
            $time = \Carbon\Carbon::parse($startTimeStr);
            return $time->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
