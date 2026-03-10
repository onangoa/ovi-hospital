<?php

namespace App\Exports;

use App\Models\DoctorDetail;
use Illuminate\Http\Request;

class DoctorDetailsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = DoctorDetail::with(['hospitalDepartment', 'user'])
            ->whereHas('user', function($q) use ($request) {
                $q->where('company_id', session('company_id'));

                if ($request->name)
                    $q->where('name', 'like', $request->name . '%');

                if ($request->email)
                    $q->where('email', 'like', $request->email . '%');

                if ($request->phone)
                    $q->where('phone', 'like', $request->phone . '%');
            });

        $doctorDetails = $query->get();

        parent::__construct(
            ['doctorDetails' => $doctorDetails],
            'DoctorDetails',
            'exports.doctor-details-pdf'
        );
    }
}