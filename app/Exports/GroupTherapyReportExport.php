<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class GroupTherapyReportExport implements FromView
{
    protected $therapyReports;

    public function __construct(Request $request)
    {
        $query = TherapyReport::with(['physiotherapist', 'ward'])
            ->whereNull('patient_id');

        // Apply filters based on user role
        if (auth()->user()->hasRole('Physiotherapist')) {
            $query->where('physiotherapist_id', auth()->id());
        } elseif ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('ward_id'))
            $query->where('ward_id', $request->ward_id);

        $this->therapyReports = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.group-therapy-reports', [
            'therapyReports' => $this->therapyReports
        ]);
    }
}