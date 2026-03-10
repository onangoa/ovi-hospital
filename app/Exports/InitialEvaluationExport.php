<?php

namespace App\Exports;

use App\Models\InitialEvaluation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class InitialEvaluationExport implements FromView
{
    protected $initialEvaluations;

    public function __construct(Request $request)
    {
        $query = InitialEvaluation::with(['patient', 'provider'])
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

        if ($request->filled('primary_diagnosis')) {
            $query->where('primary_diagnosis', 'like', $request->primary_diagnosis.'%');
        }

        $this->initialEvaluations = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.initial-evaluations', [
            'initialEvaluations' => $this->initialEvaluations
        ]);
    }
}