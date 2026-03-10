<?php

namespace App\Exports;

use App\Models\RadiologyRequest;
use Illuminate\Http\Request;

class RadiologyRequestsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = RadiologyRequest::with(['patient', 'provider'])
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

        if ($request->filled('examination_type')) {
            $query->where('examination_type', 'like', $request->examination_type.'%');
        }

        if ($request->filled('reason_for_investigation')) {
            $query->where('reason_for_investigation', 'like', $request->reason_for_investigation.'%');
        }

        $radiologyRequests = $query->get();

        parent::__construct(
            ['radiologyRequests' => $radiologyRequests],
            'RadiologyRequests',
            'exports.radiology-requests-pdf'
        );
    }
}