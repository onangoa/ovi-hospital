<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use App\Models\User;
use App\Exports\LabRequestExport;
use App\Exports\LabRequestPdfExport;
use App\Exports\LabRequestSinglePdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LabRequestController extends Controller
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

        $labRequests = LabRequest::with(['patient', 'clinician'])->latest()->paginate(10);
        return view('lab-requests.index', compact('labRequests'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new LabRequestExport($request), 'LabRequests.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new LabRequestPdfExport($request);
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
        return view('lab-requests.create', compact('patients'));
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
            'age' => 'nullable|string|max:255',
            'sex' => 'nullable|string|max:255',
            'resident' => 'nullable|string|max:255',
            'report_to' => 'nullable|string|max:255',
            'specimen_type' => 'nullable|string|max:255',
            'collection_datetime' => 'nullable|date',
            'specimen_no' => 'nullable|string|max:255',
            'blood_bank' => 'nullable|boolean',
            'histology' => 'nullable|boolean',
            'serology' => 'nullable|boolean',
            'haematology' => 'nullable|boolean',
            'bacteriology' => 'nullable|boolean',
            'parasitology' => 'nullable|boolean',
            'biochemistry' => 'nullable|boolean',
            'other_destination' => 'nullable|string|max:255',
            'investigation_requested' => 'nullable|string',
            'differential_diagnosis' => 'nullable|string',
            'clinician_name' => 'nullable|string|max:255',
            'clinician_id' => 'required|exists:users,id',
            'request_date' => 'nullable|date',
            'vital_signs' => 'nullable|array',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        LabRequest::create($data);

        return redirect()->route('lab-requests.index')
            ->with('success', 'Lab request created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LabRequest  $labRequest
     * @return \Illuminate\Http\Response
     */
    public function show(LabRequest $labRequest)
    {
        // Check if this is a PDF export request
        if (request()->export_pdf) {
            return $this->exportLabRequestPdf($labRequest);
        }
        
        // Manually decode the vital_signs JSON string to an array
        if ($labRequest->vital_signs) {
            $labRequest->vital_signs = json_decode($labRequest->vital_signs, true);
        }
        
        return view('lab-requests.show', compact('labRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LabRequest  $labRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(LabRequest $labRequest)
    {
        $patients = User::role('Patient')->get();
        
        // Manually decode the vital_signs JSON string to an array
        if ($labRequest->vital_signs) {
            $labRequest->vital_signs = json_decode($labRequest->vital_signs, true);
        }
        
        return view('lab-requests.edit', compact('labRequest', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LabRequest  $labRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabRequest $labRequest)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'age' => 'nullable|string|max:255',
            'sex' => 'nullable|string|max:255',
            'resident' => 'nullable|string|max:255',
            'report_to' => 'nullable|string|max:255',
            'specimen_type' => 'nullable|string|max:255',
            'collection_datetime' => 'nullable|date',
            'specimen_no' => 'nullable|string|max:255',
            'blood_bank' => 'nullable|boolean',
            'histology' => 'nullable|boolean',
            'serology' => 'nullable|boolean',
            'haematology' => 'nullable|boolean',
            'bacteriology' => 'nullable|boolean',
            'parasitology' => 'nullable|boolean',
            'biochemistry' => 'nullable|boolean',
            'other_destination' => 'nullable|string|max:255',
            'investigation_requested' => 'nullable|string',
            'differential_diagnosis' => 'nullable|string',
            'clinician_name' => 'nullable|string|max:255',
            'clinician_id' => 'required|exists:users,id',
            'request_date' => 'nullable|date',
            'vital_signs' => 'nullable|array',
        ]);

        $data = $request->all();
        $data['vital_signs'] = json_encode($request->vital_signs);
        $labRequest->update($data);

        return redirect()->route('lab-requests.index')
            ->with('success', 'Lab request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LabRequest  $labRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabRequest $labRequest)
    {
        $labRequest->delete();

        return redirect()->route('lab-requests.index')
            ->with('success', 'Lab request deleted successfully.');
    }

    public function getPatientDetails($id)
    {
        $patient = User::find($id);
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $age = null;
        if (isset($patient->dob)) {
            $age = \Carbon\Carbon::parse($patient->dob)->age;
        }

        $sex = $patient->gender ?? null;

        return response()->json([
            'age' => $age,
            'sex' => $sex
        ]);
    }

    /**
     * Export Lab Request to PDF
     *
     * @param  \App\Models\LabRequest  $labRequest
     * @return \Illuminate\Http\Response
     */
    private function exportLabRequestPdf(LabRequest $labRequest)
    {
        $pdfExport = new LabRequestSinglePdfExport($labRequest);
        return $pdfExport->download();
    }
}
