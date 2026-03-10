<?php

namespace App\Exports;

use App\Models\ChildVitalityIndexScore;
use Illuminate\Http\Request;

class CviPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = ChildVitalityIndexScore::with(['patient'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('score')) {
            $query->where('score', $request->score);
        }

        $cviScores = $query->get();

        parent::__construct(
            ['cviScores' => $cviScores],
            'CVI',
            'exports.cvi-pdf'
        );
    }
}