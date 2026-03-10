<?php

namespace App\Exports;

use App\Models\LabRequest;
use Illuminate\Http\Request;

class LabRequestPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = LabRequest::with(['patient', 'clinician'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('clinician_id', auth()->id());
        elseif ($request->filled('clinician_id'))
            $query->where('clinician_id', $request->clinician_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->request_date)
            $query->where('request_date', $request->request_date);

        if ($request->filled('specimen')) {
            $query->where('specimen', 'like', $request->specimen.'%');
        }

        if ($request->filled('investigation_requested')) {
            $query->where('investigation_requested', 'like', $request->investigation_requested.'%');
        }

        $labRequests = $query->get();

        parent::__construct(
            ['labRequests' => $labRequests],
            'LabRequests',
            'exports.lab-requests-pdf'
        );
    }
}