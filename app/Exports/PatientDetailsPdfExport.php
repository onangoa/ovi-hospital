<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;

class PatientDetailsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        if (auth()->user()->hasRole('Patient')) {
            $query = User::role('Patient')->where('company_id', session('company_id'))->where('id', auth()->id());
        } else {
            $query = User::role('Patient')->where('company_id', session('company_id'));
        }

        $query->with(['cviScores', 'wards' => function ($q) {
            $q->whereNull('patient_ward.discharged_at');
        }])->latest();

        if ($request->name)
            $query->where('name', 'like', $request->name.'%');

        if ($request->phone)
            $query->where('phone', 'like', $request->phone.'%');

        if ($request->email)
            $query->where('email', 'like', $request->email.'%');

        $patientDetails = $query->get();

        parent::__construct(
            ['patientDetails' => $patientDetails],
            'PatientDetails',
            'exports.patient-details-pdf'
        );
    }
}