<?php

namespace App\Exports;

use App\Models\WardRoundNote;
use Illuminate\Http\Request;

class WardRoundNotesPdfExport extends BasePdfExport
{
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
        elseif ($request->filled('attending_clinician'))
            $query->where('attending_clinician', $request->attending_clinician);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $wardRoundNotes = $query->get();

        // Decode vital_signs JSON for each record
        foreach ($wardRoundNotes as $note) {
            if ($note->vital_signs) {
                $note->vital_signs = json_decode($note->vital_signs, true);
            }
        }

        parent::__construct(
            ['wardRoundNotes' => $wardRoundNotes],
            'WardRoundNotes',
            'exports.ward-round-notes-pdf'
        );
    }
}