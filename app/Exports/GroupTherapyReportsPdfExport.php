<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Illuminate\Http\Request;

class GroupTherapyReportsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = TherapyReport::with(['physiotherapist', 'ward'])
            ->whereNull('patient_id');

        // Apply filters based on user role
        if (auth()->user()->hasRole('Doctor')) {
            $query->where('physiotherapist_id', auth()->id());
        } elseif ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('ward_id'))
            $query->where('ward_id', $request->ward_id);

        $therapyReports = $query->get();

        parent::__construct(
            ['therapyReports' => $therapyReports],
            'GroupTherapyReports',
            'exports.group-therapy-reports-pdf'
        );
    }
}