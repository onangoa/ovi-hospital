<?php

namespace App\Http\Controllers;

use App\Models\MedicalReferral;
use App\Models\User;
use App\Exports\MedicalReferralExport;
use App\Exports\MedicalReferralPdfExport;
use App\Exports\MedicalReferralsPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicalReferralController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:medical-referrals-read|medical-referrals-create|medical-referrals-update|medical-referrals-delete', ['only' => ['index','show']]);
         $this->middleware('permission:medical-referrals-create', ['only' => ['create','store']]);
         $this->middleware('permission:medical-referrals-update', ['only' => ['edit','update']]);
         $this->middleware('permission:medical-referrals-delete', ['only' => ['destroy']]);
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

        $medicalReferrals = MedicalReferral::with('patient', 'referringDoctor')->latest()->paginate(20);
        return view('medical-referrals._index', compact('medicalReferrals'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new MedicalReferralExport($request), 'MedicalReferrals.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new MedicalReferralsPdfExport($request);
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
        $doctors = User::role('Doctor')->get();
        return view('medical-referrals.create', compact('patients', 'doctors'));
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
            'referring_doctor_name' => 'required|exists:users,id',
            'reason_for_referral' => 'nullable|string',
            'chief_complaint' => 'nullable|string',
            'patient_brief_history' => 'nullable|string',
            'vital_signs' => 'nullable|array',
            'lab_investigation_done' => 'nullable|string',
            'treatment_done' => 'nullable|string',
        ]);

        $validatedData['vital_signs'] = json_encode($request->vital_signs);
        $medicalReferral = new MedicalReferral($validatedData);
        $medicalReferral->referring_doctor_name = $validatedData['referring_doctor_name'];
        $medicalReferral->save();


        return redirect()->route('medical-referrals.index')
            ->with('success', 'Medical Referral created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalReferral  $medicalReferral
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MedicalReferral $medicalReferral)
    {
        // Check if this is a PDF export request
        if ($request->get('export_pdf')) {
            return $this->exportMedicalReferralPdf($medicalReferral);
        }
        
        // Manually decode the vital_signs JSON string to an array
        if ($medicalReferral->vital_signs) {
            $medicalReferral->vital_signs = json_decode($medicalReferral->vital_signs, true);
        }
        
        return view('medical-referrals.show', compact('medicalReferral'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalReferral  $medicalReferral
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalReferral $medicalReferral)
    {
        $patients = User::role('Patient')->get();
        $doctors = User::role('Doctor')->get();
        
        // Manually decode the vital_signs JSON string to an array
        if ($medicalReferral->vital_signs) {
            $medicalReferral->vital_signs = json_decode($medicalReferral->vital_signs, true);
        }
        
        return view('medical-referrals.edit', compact('medicalReferral', 'patients', 'doctors'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalReferral  $medicalReferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalReferral $medicalReferral)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'referring_doctor_name' => 'required|exists:users,id',
            'reason_for_referral' => 'nullable|string',
            'chief_complaint' => 'nullable|string',
            'patient_brief_history' => 'nullable|string',
            'vital_signs' => 'nullable|array',
            'lab_investigation_done' => 'nullable|string',
            'treatment_done' => 'nullable|string',
        ]);

        $validatedData['vital_signs'] = json_encode($request->vital_signs);
        $medicalReferral->update($validatedData);
        $medicalReferral->referring_doctor_name = $validatedData['referring_doctor_name'];
        $medicalReferral->save();


        return redirect()->route('medical-referrals.index')
            ->with('success', 'Medical Referral updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalReferral  $medicalReferral
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalReferral $medicalReferral)
    {
        $medicalReferral->delete();

        return redirect()->route('medical-referrals.index')
            ->with('success', 'Medical Referral deleted successfully');
    }

    /**
     * Export individual medical referral to PDF
     *
     * @param MedicalReferral $medicalReferral
     * @return \Illuminate\Http\Response
     */
    private function exportMedicalReferralPdf(MedicalReferral $medicalReferral)
    {
        // Load necessary relationships for PDF export
        $medicalReferral->load(['patient', 'referringDoctor']);
        
        // Manually decode vital_signs JSON string to an array
        if ($medicalReferral->vital_signs) {
            $medicalReferral->vital_signs = json_decode($medicalReferral->vital_signs, true);
        }
        
        $pdfExport = new MedicalReferralPdfExport($medicalReferral);
        return $pdfExport->download();
    }
}
