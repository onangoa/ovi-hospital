<?php

namespace App\Exports;

use App\Models\NursingCardex;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class NursingCardexExport implements FromView
{
    protected $nursingCardexes;

    public function __construct(Request $request)
    {
        $query = NursingCardex::with(['patient', 'nurseOnDuty'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Nurse'))
            $query->where('nurse_on_duty_id', auth()->id());
        elseif ($request->filled('nurse_on_duty_id'))
            $query->where('nurse_on_duty_id', $request->nurse_on_duty_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        $this->nursingCardexes = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.nursing-cardexes', [
            'nursingCardexes' => $this->nursingCardexes
        ]);
    }
}