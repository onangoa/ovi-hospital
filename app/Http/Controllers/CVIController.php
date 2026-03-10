<?php

namespace App\Http\Controllers;

use App\Models\ChildVitalityIndexScore;
use App\Exports\CviExport;
use App\Exports\CviPdfExport;
use App\Exports\CviSinglePdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CVIController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:cvi-read|cvi-create|cvi-update|cvi-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:cvi-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cvi-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cvi-delete', ['only' => ['destroy']]);
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

        $query = \App\Models\ChildVitalityIndexScore::with('patient');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $cvis = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('cvi._index', compact('cvis'));
        }

        return view('cvi.index', compact('cvis'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new CviExport($request), 'CVI.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new CviPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Export CVI to PDF
     *
     * @param  \App\Models\ChildVitalityIndexScore  $cvi
     * @return \Illuminate\Http\Response
     */
    private function exportCviPdf(\App\Models\ChildVitalityIndexScore $cvi)
    {
        $pdfExport = new CviSinglePdfExport($cvi);
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
        return view('cvi.create', compact('patients'));
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
        \App\Models\ChildVitalityIndexScore::create($request->all());
        return redirect()->route('cvi.index')->with('success', 'CV created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChildVitalityIndexScore  $cv
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\ChildVitalityIndexScore $cvi)
    {
        if (request()->export_pdf) {
            return $this->exportCviPdf($cvi);
        }
        
        return view('cvi.show', compact('cvi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChildVitalityIndexScore  $cv
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\ChildVitalityIndexScore $cvi)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        return view('cvi.edit', compact('cvi', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChildVitalityIndexScore  $cv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Models\ChildVitalityIndexScore $cvi)
    {
        $this->validation($request, $cvi->id);
        $cvi->update($request->all());
        return redirect()->route('cvi.index')->with('success', 'CV updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChildVitalityIndexScore  $cv
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Models\ChildVitalityIndexScore $cvi)
    {
        $cvi->delete();
        return redirect()->route('cvi.index')->with('success', 'CV deleted successfully.');
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
            'patient_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($id) {
                    // Check if patient already has a CVI record (excluding current record when editing)
                    $exists = \App\Models\ChildVitalityIndexScore::where('patient_id', $value)
                        ->when($id > 0, function ($query) use ($id) {
                            return $query->where('id', '!=', $id);
                        })
                        ->exists();
                    
                    if ($exists) {
                        $fail('A Child Vitality Index already exists for this patient.');
                    }
                }
            ],
            'date' => ['required', 'date'],
            'nutritionalStatus' => ['required'],
            'developmentallyDelayed' => ['required'],
            'chronicConditions' => ['required'],
            'mentalHealth' => ['required'],
            'physicalDisabilities' => ['required'],
            'communicationAbilities' => ['required'],
            'vaccineStatus' => ['required'],
            'familialInstability' => ['required'],
            'poverty' => ['required'],
            'institutionalized' => ['required'],
            'insecureShelter' => ['required'],
            'psychologicalTrauma' => ['required'],
            'socialIsolation' => ['required'],
            'discrimination' => ['required'],
            'conflictArea' => ['required'],
            'healthcareAccess' => ['required'],
            'waterSource' => ['required'],
            'sanitation' => ['required'],
            'schoolStatus' => ['required'],
            'diseaseOutbreaks' => ['required'],
            'score' => ['required', 'integer'],
            'notes' => ['nullable'],
        ]);


    }
}
