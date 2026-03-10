<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Illuminate\Http\Request;

class TherapyReportsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = TherapyReport::with(['patient', 'physiotherapist', 'ward']);

        // Apply filters based on user role
        if (auth()->user()->hasRole('Doctor')) {
            $query->where('physiotherapist_id', auth()->id());
        } elseif ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        // For individual therapy reports, apply patient filters
        if (auth()->user()->hasRole('Patient')) {
            $query->where('patient_id', auth()->id());
        } elseif ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // For individual therapy reports with patient relationship, filter by company
        if (!auth()->user()->hasRole('Patient')) {
            $query->where(function($q) use ($request) {
                $q->whereNull('patient_id')
                  ->orWhereHas('patient', function($subQ) use ($request) {
                      $subQ->where('company_id', session('company_id'));
                  });
            });
        }

        if ($request->date)
            $query->where('date', $request->date);

        // Filter by individual vs group therapy
        if ($request->filled('type')) {
            if ($request->type === 'individual') {
                $query->whereNotNull('patient_id');
            } elseif ($request->type === 'group') {
                $query->whereNull('patient_id');
            }
        }

        $therapyReports = $query->get();

        parent::__construct(
            ['therapyReports' => $therapyReports],
            'TherapyReports',
            'exports.therapy-reports-pdf'
        );
    }
}