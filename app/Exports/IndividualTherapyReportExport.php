<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class IndividualTherapyReportExport implements FromView
{
    protected $therapyReports;

    public function __construct(Request $request)
    {
        $query = TherapyReport::with(['patient', 'physiotherapist'])
            ->whereNotNull('patient_id');

        // Apply filters based on user role
        if (auth()->user()->hasRole('Physiotherapist')) {
            $query->where('physiotherapist_id', auth()->id());
        } elseif ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        if (auth()->user()->hasRole('Patient')) {
            $query->where('patient_id', auth()->id());
        } elseif ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by company for non-patients
        if (!auth()->user()->hasRole('Patient')) {
            $query->whereHas('patient', function($q) {
                $q->where('company_id', session('company_id'));
            });
        }

        if ($request->date)
            $query->where('date', $request->date);

        $this->therapyReports = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.individual-therapy-reports', [
            'therapyReports' => $this->therapyReports
        ]);
    }
}