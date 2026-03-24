<?php

namespace App\Console\Commands;

use App\Models\TherapyReport;
use Illuminate\Console\Command;

class UpdateTherapyReportTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'therapy:update-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update therapy_type field for existing therapy reports based on patient_id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating therapy report types...');

        $updatedCount = 0;

        // Update individual therapy reports (have patient_id)
        TherapyReport::whereNotNull('patient_id')
            ->whereNull('therapy_type')
            ->update(['therapy_type' => 'individual']);
        
        $individualCount = TherapyReport::where('therapy_type', 'individual')->count();
        $updatedCount += $individualCount;
        $this->info("Updated {$individualCount} individual therapy reports");

        // Update group therapy reports (have participant_ids or ward_id)
        TherapyReport::whereNull('patient_id')
            ->whereNull('therapy_type')
            ->update(['therapy_type' => 'group']);
        
        $groupCount = TherapyReport::where('therapy_type', 'group')->count();
        $updatedCount += $groupCount;
        $this->info("Updated {$groupCount} group therapy reports");

        $this->info("Total therapy reports updated: {$updatedCount}");
        $this->info('Therapy report types update completed successfully!');

        return 0;
    }
}
