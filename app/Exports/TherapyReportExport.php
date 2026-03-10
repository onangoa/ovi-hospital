<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class TherapyReportExport implements FromView
{
    protected $therapyReports;

    public function __construct(Request $request)
    {
        $query = TherapyReport::with(['patient', 'physiotherapist', 'ward'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Physiotherapist'))
            $query->where('physiotherapist_id', auth()->id());
        elseif ($request->filled('physiotherapist_id'))
            $query->where('physiotherapist_id', $request->physiotherapist_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('ward_id'))
            $query->where('ward_id', $request->ward_id);

        if ($request->filled('session_time')) {
            $query->where('session_time', 'like', $request->session_time.'%');
        }

        $this->therapyReports = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.therapy-reports', [
            'therapyReports' => $this->therapyReports
        ]);
    }
}