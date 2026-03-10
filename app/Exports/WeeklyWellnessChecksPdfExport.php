<?php

namespace App\Exports;

use App\Models\WeeklyWellnessCheck;
use Illuminate\Http\Request;

class WeeklyWellnessChecksPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = WeeklyWellnessCheck::with(['patient', 'provider'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('provider_id', auth()->id());
        elseif ($request->filled('provider_id'))
            $query->where('provider_id', $request->provider_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('week_number')) {
            $query->where('week_number', $request->week_number);
        }

        $weeklyWellnessChecks = $query->get();

        parent::__construct(
            ['weeklyWellnessChecks' => $weeklyWellnessChecks],
            'WeeklyWellnessChecks',
            'exports.weekly-wellness-checks-pdf'
        );
    }
}