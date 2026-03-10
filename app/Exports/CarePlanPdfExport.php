<?php

namespace App\Exports;

use App\Models\CarePlan;
use Illuminate\Http\Request;

class CarePlanPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = CarePlan::with(['patient', 'provider'])
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

        if ($request->filled('admission_decision')) {
            $query->where('admission_decision', $request->admission_decision);
        }

        $carePlans = $query->get();

        parent::__construct(
            ['carePlans' => $carePlans],
            'CarePlans',
            'exports.care-plans-pdf'
        );
    }
}