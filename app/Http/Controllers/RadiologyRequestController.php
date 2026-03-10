<?php

namespace App\Http\Controllers;

use App\Models\RadiologyRequest;
use App\Models\User;
use App\Exports\RadiologyRequestExport;
use App\Exports\RadiologyRequestPdfExport;
use App\Exports\RadiologyRequestsPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RadiologyRequestController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:radiology-requests-read|radiology-requests-create|radiology-requests-update|radiology-requests-delete', ['only' => ['index','show']]);
         $this->middleware('permission:radiology-requests-create', ['only' => ['create','store']]);
         $this->middleware('permission:radiology-requests-update', ['only' => ['edit','update']]);
         $this->middleware('permission:radiology-requests-delete', ['only' => ['destroy']]);
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

        $query = RadiologyRequest::with(['patient']);
        
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        
        $radiologyRequests = $query->latest()->paginate(20);
        return view('radiology-requests._index', compact('radiologyRequests'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new RadiologyRequestExport($request), 'RadiologyRequests.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new RadiologyRequestsPdfExport($request);
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
        return view('radiology-requests.create', compact('patients', 'currentUser'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'examination_type' => 'nullable|array',
            'examination_details' => 'nullable|string',
            'relevant_clinical_information' => 'nullable|string',
            'reason_for_investigation' => 'nullable|string',
        ]);

        // Set provider_id to the currently logged-in user
        $validatedData['provider_id'] = auth()->id();

        $radiologyRequest = new RadiologyRequest($validatedData);
        $radiologyRequest->save();



        return redirect()->route('radiology-requests.index')
            ->with('success', 'Radiology Request created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RadiologyRequest  $radiologyRequest
     * @return \Illuminate\Http\Response
     */
    public function show(RadiologyRequest $radiologyRequest)
    {
        if (request()->export_pdf) {
            return $this->exportRadiologyRequestPdf($radiologyRequest);
        }
        
        $radiologyRequest->load(['patient']);
        return view('radiology-requests.show', compact('radiologyRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RadiologyRequest  $radiologyRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(RadiologyRequest $radiologyRequest)
    {
        $radiologyRequest->load(['patient']);
        $patients = User::role('Patient')->get();
        $currentUser = auth()->user();
        return view('radiology-requests.edit', compact('radiologyRequest', 'patients', 'currentUser'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RadiologyRequest  $radiologyRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RadiologyRequest $radiologyRequest)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'examination_type' => 'nullable|array',
            'examination_details' => 'nullable|string',
            'relevant_clinical_information' => 'nullable|string',
            'reason_for_investigation' => 'nullable|string',
        ]);

        // Keep the original provider_id, don't allow it to be changed
        $validatedData['provider_id'] = $radiologyRequest->provider_id;

        $radiologyRequest->update($validatedData);



        return redirect()->route('radiology-requests.index')
            ->with('success', 'Radiology Request updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RadiologyRequest  $radiologyRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(RadiologyRequest $radiologyRequest)
    {
        $radiologyRequest->delete();

        return redirect()->route('radiology-requests.index')
            ->with('success', 'Radiology Request deleted successfully');
    }

    /**
     * Export individual radiology request to PDF
     *
     * @param RadiologyRequest $radiologyRequest
     * @return \Illuminate\Http\Response
     */
    private function exportRadiologyRequestPdf(RadiologyRequest $radiologyRequest)
    {
        // Load necessary relationships for PDF export
        $radiologyRequest->load(['patient']);
        
        $pdfExport = new RadiologyRequestPdfExport($radiologyRequest);
        return $pdfExport->download();
    }
}
