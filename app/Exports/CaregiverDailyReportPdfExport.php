<?php

namespace App\Exports;

use App\Models\CaregiverDailyReport;
use Illuminate\Http\Request;

class CaregiverDailyReportPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = CaregiverDailyReport::with(['patient', 'caregiver'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Caregiver'))
            $query->where('provider_id', auth()->id());
        elseif ($request->filled('provider_id'))
            $query->where('provider_id', $request->provider_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('mood')) {
            $query->where('mood', 'like', $request->mood.'%');
        }

        $caregiverDailyReports = $query->get();

        parent::__construct(
            ['caregiverDailyReports' => $caregiverDailyReports],
            'CaregiverDailyReports',
            'exports.caregiver-daily-reports-pdf'
        );
    }
}