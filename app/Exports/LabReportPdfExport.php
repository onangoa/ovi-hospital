<?php

namespace App\Exports;

use App\Models\LabReport;
use Illuminate\Http\Request;

class LabReportPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = LabReport::with(['user'])
            ->whereHas('user', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->name) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', $request->name.'%');
            });
        }

        if ($request->email) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('email', 'like', $request->email.'%');
            });
        }

        if ($request->gender) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->address) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('address', 'like', $request->address.'%');
            });
        }

        $labReports = $query->get();

        parent::__construct(
            ['labReports' => $labReports],
            'LabReports',
            'exports.lab-reports-pdf'
        );
    }
}