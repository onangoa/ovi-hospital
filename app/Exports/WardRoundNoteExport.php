<?php

namespace App\Exports;

use App\Models\WardRoundNote;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class WardRoundNoteExport implements FromView
{
    protected $wardRoundNotes;

    public function __construct(Request $request)
    {
        $query = WardRoundNote::with(['patient', 'attendingClinician'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('attending_clinician', auth()->id());
        elseif ($request->filled('clinician_id'))
            $query->where('attending_clinician', $request->clinician_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('bed_number')) {
            $query->where('bed_number', 'like', $request->bed_number.'%');
        }

        if ($request->filled('condition')) {
            $query->where('condition', 'like', $request->condition.'%');
        }

        $this->wardRoundNotes = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.ward-round-notes', [
            'wardRoundNotes' => $this->wardRoundNotes
        ]);
    }
}