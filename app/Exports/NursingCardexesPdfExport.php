<?php

namespace App\Exports;

use App\Models\NursingCardex;
use Illuminate\Http\Request;

class NursingCardexesPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = NursingCardex::with(['patient', 'nurseOnDuty'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Nurse'))
            $query->where('nurse_id', auth()->id());
        elseif ($request->filled('nurse_id'))
            $query->where('nurse_id', $request->nurse_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $nursingCardexes = $query->get();

        parent::__construct(
            ['nursingCardexes' => $nursingCardexes],
            'NursingCardexes',
            'exports.nursing-cardexes-pdf'
        );
    }
}