<?php

namespace App\Http\Controllers;

use App\Models\WardRoundNote;
use App\Models\User;
use App\Exports\WardRoundNoteExport;
use App\Exports\WardRoundNotePdfExport;
use App\Exports\WardRoundNotesPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WardRoundNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->export)
            return $this->doExport($request);
        
        if ($request->export_pdf)
            return $this->doPdfExport($request);

        $query = WardRoundNote::with(['patient', 'attendingClinician']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $wardRoundNotes = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('ward-round-notes._index', compact('wardRoundNotes'));
        }

        return view('ward-round-notes.index', compact('wardRoundNotes'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new WardRoundNoteExport($request), 'WardRoundNotes.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new WardRoundNotesPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = User::role('Patient')->where('status', '1')->get();
        return view('ward-round-notes.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date' => 'nullable|date',
            'mrn' => 'nullable|string|max:255',
            'attending_clinician' => 'nullable|exists:users,id',
            'vital_signs' => 'nullable|array',
            'main_complaints' => 'nullable|string',
            'examination_findings' => 'nullable|string',
            'respiratory_status' => 'nullable|string|in:normal,abnormal',
            'respiratory_comments' => 'nullable|string',
            'cardiovascular_status' => 'nullable|string|in:normal,abnormal',
            'cardiovascular_comments' => 'nullable|string',
            'neurological_status' => 'nullable|string|in:normal,abnormal',
            'neurological_comments' => 'nullable|string',
            'gastrointestinal_status' => 'nullable|string|in:normal,abnormal',
            'gastrointestinal_comments' => 'nullable|string',
            'skin_status' => 'nullable|string|in:normal,abnormal',
            'skin_comments' => 'nullable|string',
            'medications_changes' => 'nullable|string',
            'procedures_interventions' => 'nullable|string',
            'pending_tests' => 'nullable|string',
            'condition' => 'nullable|string|in:stable,improving,deteriorating',
            'next_steps' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        WardRoundNote::create($data);

        return redirect()->route('ward-round-notes.index')
            ->with('success', 'Ward round note created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WardRoundNote  $wardRoundNote
     * @return \Illuminate\Http\Response
     */
    public function show(WardRoundNote $wardRoundNote)
    {
        if (request()->export_pdf) {
            return $this->exportWardRoundNotePdf($wardRoundNote);
        }
        
        // Manually decode the vital_signs JSON string to an array
        if ($wardRoundNote->vital_signs) {
            $wardRoundNote->vital_signs = json_decode($wardRoundNote->vital_signs, true);
        }
        
        return view('ward-round-notes.show', compact('wardRoundNote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WardRoundNote  $wardRoundNote
     * @return \Illuminate\Http\Response
     */
    public function edit(WardRoundNote $wardRoundNote)
    {
        $patients = User::role('Patient')->where('status', '1')->get();
        
        // Manually decode the vital_signs JSON string to an array
        if ($wardRoundNote->vital_signs) {
            $wardRoundNote->vital_signs = json_decode($wardRoundNote->vital_signs, true);
        }
        
        return view('ward-round-notes.edit', compact('wardRoundNote', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WardRoundNote  $wardRoundNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WardRoundNote $wardRoundNote)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date' => 'nullable|date',
            'mrn' => 'nullable|string|max:255',
            'attending_clinician' => 'nullable|exists:users,id',
            'vital_signs' => 'nullable|array',
            'main_complaints' => 'nullable|string',
            'examination_findings' => 'nullable|string',
            'respiratory_status' => 'nullable|string|in:normal,abnormal',
            'respiratory_comments' => 'nullable|string',
            'cardiovascular_status' => 'nullable|string|in:normal,abnormal',
            'cardiovascular_comments' => 'nullable|string',
            'neurological_status' => 'nullable|string|in:normal,abnormal',
            'neurological_comments' => 'nullable|string',
            'gastrointestinal_status' => 'nullable|string|in:normal,abnormal',
            'gastrointestinal_comments' => 'nullable|string',
            'skin_status' => 'nullable|string|in:normal,abnormal',
            'skin_comments' => 'nullable|string',
            'medications_changes' => 'nullable|string',
            'procedures_interventions' => 'nullable|string',
            'pending_tests' => 'nullable|string',
            'condition' => 'nullable|string|in:stable,improving,deteriorating',
            'next_steps' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        $wardRoundNote->update($data);

        return redirect()->route('ward-round-notes.index')
            ->with('success', 'Ward round note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WardRoundNote  $wardRoundNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(WardRoundNote $wardRoundNote)
    {
        $wardRoundNote->delete();

        return redirect()->route('ward-round-notes.index')
            ->with('success', 'Ward round note deleted successfully.');
    }

    /**
     * Export individual ward round note to PDF
     *
     * @param WardRoundNote $wardRoundNote
     * @return \Illuminate\Http\Response
     */
    private function exportWardRoundNotePdf(WardRoundNote $wardRoundNote)
    {
        // Load necessary relationships for PDF export
        $wardRoundNote->load(['patient', 'attendingClinician']);
        
        // Manually decode the vital_signs JSON string to an array
        if ($wardRoundNote->vital_signs) {
            $wardRoundNote->vital_signs = json_decode($wardRoundNote->vital_signs, true);
        }
        
        $pdfExport = new WardRoundNotePdfExport($wardRoundNote);
        return $pdfExport->download();
    }
}
