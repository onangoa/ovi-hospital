<?php

namespace App\Exports;

use App\Models\CaregiverDailyReport;

class CaregiverDailyReportSinglePdfExport extends BasePdfExport
{
    public function __construct(CaregiverDailyReport $caregiverDailyReport)
    {
        // Load the patient and caregiver relationships
        $caregiverDailyReport->load(['patient', 'caregiver']);
        
        parent::__construct(
            ['caregiverDailyReport' => $caregiverDailyReport],
            'CaregiverDailyReport-' . $caregiverDailyReport->id,
            'exports.caregiver-daily-report-single-pdf',
            'portrait'
        );
    }
}