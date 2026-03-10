<?php

namespace App\Exports;

use App\Models\InitialEvaluation;
use Illuminate\Http\Request;

class InitialEvaluationPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = InitialEvaluation::with(['patient', 'provider']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $evaluations = $query->latest()->get();

        parent::__construct(
            ['evaluations' => $evaluations],
            'InitialEvaluations',
            'exports.initial-evaluations-pdf'
        );
    }
}