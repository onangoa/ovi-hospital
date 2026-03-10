<?php

namespace App\Http\Controllers;

use App\Models\NursingCardex;
use App\Models\User;
use App\Exports\NursingCardexExport;
use App\Exports\NursingCardexPdfExport;
use App\Exports\NursingCardexesPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NursingCardexController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:nursing-cardexes-read|nursing-cardexes-create|nursing-cardexes-update|nursing-cardexes-delete', ['only' => ['index','show']]);
         $this->middleware('permission:nursing-cardexes-create', ['only' => ['create','store']]);
         $this->middleware('permission:nursing-cardexes-update', ['only' => ['edit','update']]);
         $this->middleware('permission:nursing-cardexes-delete', ['only' => ['destroy']]);
    }
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

        $nursingCardexes = NursingCardex::with('patient')->latest()->paginate(20);
        return view('nursing-cardexes._index', compact('nursingCardexes'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new NursingCardexExport($request), 'NursingCardexes.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new NursingCardexesPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = User::role('Patient')->get();
        $currentUser = auth()->user();
        return view('nursing-cardexes.create', compact('patients', 'currentUser'));
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
            'date' => 'required|date',
            'vital_signs' => 'nullable|array',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        $data['nurse_on_duty_id'] = auth()->id();
        $data['nurse_on_duty_name'] = auth()->user()->name;

        NursingCardex::create($data);

        return redirect()->route('nursing-cardexes.index')
            ->with('success', 'Nursing Cardex created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NursingCardex  $nursingCardex
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, NursingCardex $nursingCardex)
    {
        // Check if this is a PDF export request
        if ($request->get('export_pdf')) {
            return $this->exportNursingCardexPdf($nursingCardex);
        }
        
        // Manually decode the vital_signs JSON string to an array
        if ($nursingCardex->vital_signs) {
            $nursingCardex->vital_signs = json_decode($nursingCardex->vital_signs, true);
        }
        
        return view('nursing-cardexes.show', compact('nursingCardex'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NursingCardex  $nursingCardex
     * @return \Illuminate\Http\Response
     */
    public function edit(NursingCardex $nursingCardex)
    {
        $patients = User::role('Patient')->get();
        $currentUser = auth()->user();
        
        // Manually decode the vital_signs JSON string to an array
        if ($nursingCardex->vital_signs) {
            $nursingCardex->vital_signs = json_decode($nursingCardex->vital_signs, true);
        }
        
        return view('nursing-cardexes.edit', compact('nursingCardex', 'patients', 'currentUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NursingCardex  $nursingCardex
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NursingCardex $nursingCardex)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'vital_signs' => 'nullable|array',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        $data['nurse_on_duty_id'] = auth()->id();
        $data['nurse_on_duty_name'] = auth()->user()->name;

        $nursingCardex->update($data);

        return redirect()->route('nursing-cardexes.index')
            ->with('success', 'Nursing Cardex updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NursingCardex  $nursingCardex
     * @return \Illuminate\Http\Response
     */
    public function destroy(NursingCardex $nursingCardex)
    {
        $nursingCardex->delete();

        return redirect()->route('nursing-cardexes.index')
            ->with('success', 'Nursing Cardex deleted successfully');
    }

    /**
     * Export individual nursing cardex to PDF
     *
     * @param NursingCardex $nursingCardex
     * @return \Illuminate\Http\Response
     */
    private function exportNursingCardexPdf(NursingCardex $nursingCardex)
    {
        // Load necessary relationships for PDF export
        $nursingCardex->load(['patient']);
        
        // Manually decode vital_signs JSON string to an array
        if ($nursingCardex->vital_signs) {
            $nursingCardex->vital_signs = json_decode($nursingCardex->vital_signs, true);
        }
        
        $pdfExport = new NursingCardexPdfExport($nursingCardex);
        return $pdfExport->download();
    }
}
