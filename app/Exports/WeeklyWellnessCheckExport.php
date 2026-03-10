<?php

namespace App\Exports;

use App\Models\WeeklyWellnessCheck;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class WeeklyWellnessCheckExport implements FromView
{
    protected $weeklyWellnessChecks;

    public function __construct(Request $request)
    {
        $query = WeeklyWellnessCheck::with(['patient', 'conductedBy'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor') || auth()->user()->hasRole('Nurse'))
            $query->where('conducted_by', auth()->id());
        elseif ($request->filled('conducted_by'))
            $query->where('conducted_by', $request->conducted_by);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('mood')) {
            $query->where('mood', 'like', $request->mood.'%');
        }

        if ($request->filled('engagement')) {
            $query->where('engagement', 'like', $request->engagement.'%');
        }

        $this->weeklyWellnessChecks = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.weekly-wellness-checks', [
            'weeklyWellnessChecks' => $this->weeklyWellnessChecks
        ]);
    }
}