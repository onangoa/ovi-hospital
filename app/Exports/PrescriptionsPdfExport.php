<?php

namespace App\Exports;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = Prescription::with(['user', 'doctor'])
            ->whereHas('user', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('doctor_id', auth()->id());
        elseif ($request->filled('doctor_id'))
            $query->where('doctor_id', $request->doctor_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('user_id', auth()->id());
        elseif ($request->filled('user_id'))
            $query->where('user_id', $request->user_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('medication')) {
            $query->where('medication', 'like', $request->medication.'%');
        }

        $prescriptions = $query->get();

        parent::__construct(
            ['prescriptions' => $prescriptions],
            'Prescriptions',
            'exports.prescriptions-pdf'
        );
    }
}