<?php

namespace App\Exports;

use App\Models\Prescription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class PrescriptionExport implements FromView
{
    protected $prescriptions;

    public function __construct(Request $request)
    {
        $query = Prescription::with(['user', 'doctor'])
            ->whereHas('user', function($q) {
                $q->where('company_id', session('company_id'));
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('doctor_id', auth()->id());
        elseif ($request->doctor_id)
            $query->where('doctor_id', $request->doctor_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('user_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('user_id', $request->patient_id);
        elseif ($request->user_id)
            $query->where('user_id', $request->user_id);

        if ($request->prescription_date)
            $query->where('prescription_date', $request->prescription_date);

        $this->prescriptions = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.prescriptions', [
            'prescriptions' => $this->prescriptions
        ]);
    }
}