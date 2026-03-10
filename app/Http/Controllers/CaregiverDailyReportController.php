<?php

namespace App\Http\Controllers;

use App\Models\CaregiverDailyReport;
use App\Exports\CaregiverDailyReportExport;
use App\Exports\CaregiverDailyReportPdfExport;
use App\Exports\CaregiverDailyReportSinglePdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CaregiverDailyReportController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:caregiver-daily-reports-read|caregiver-daily-reports-create|caregiver-daily-reports-update|caregiver-daily-reports-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:caregiver-daily-reports-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:caregiver-daily-reports-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:caregiver-daily-reports-delete', ['only' => ['destroy']]);
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

        $query = CaregiverDailyReport::with('patient', 'caregiver');


        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $reports = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('caregiver-daily-reports._index', compact('reports'));
        }

        return view('caregiver-daily-reports.index', compact('reports'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new CaregiverDailyReportExport($request), 'CaregiverDailyReports.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new CaregiverDailyReportPdfExport($request);
        return $pdfExport->download();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        return view('caregiver-daily-reports.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        CaregiverDailyReport::create($request->all());
        return redirect()->route('caregiver-daily-reports.index')->with('success', 'Caregiver Daily Report created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaregiverDailyReport  $caregiverDailyReport
     * @return \Illuminate\Http\Response
     */
    public function show(CaregiverDailyReport $caregiverDailyReport)
    {
        // Check if this is a PDF export request
        if (request()->export_pdf) {
            return $this->exportCaregiverDailyReportPdf($caregiverDailyReport);
        }
        
        $caregiverDailyReport->load(['patient', 'caregiver']);
        return view('caregiver-daily-reports.show', compact('caregiverDailyReport'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaregiverDailyReport  $caregiverDailyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CaregiverDailyReport $caregiverDailyReport)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        return view('caregiver-daily-reports.edit', compact('caregiverDailyReport', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaregiverDailyReport  $caregiverDailyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaregiverDailyReport $caregiverDailyReport)
    {
        $this->validation($request, $caregiverDailyReport->id);
        $caregiverDailyReport->update($request->all());
        return redirect()->route('caregiver-daily-reports.index')->with('success', 'Caregiver Daily Report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaregiverDailyReport  $caregiverDailyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaregiverDailyReport $caregiverDailyReport)
    {
        $caregiverDailyReport->delete();
        return redirect()->route('caregiver-daily-reports.index')->with('success', 'Caregiver Daily Report deleted successfully.');
    }

    /**
     * Export Caregiver Daily Report to PDF
     *
     * @param  \App\Models\CaregiverDailyReport  $caregiverDailyReport
     * @return \Illuminate\Http\Response
     */
    private function exportCaregiverDailyReportPdf(CaregiverDailyReport $caregiverDailyReport)
    {
        $pdfExport = new CaregiverDailyReportSinglePdfExport($caregiverDailyReport);
        return $pdfExport->download();
    }

    /**
     * Validation function
     *
     * @param Request $request
     * @return void
     */
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'provider_id' => ['required', 'exists:users,id'],
            // Add other validation rules as needed
        ]);
    }

}
