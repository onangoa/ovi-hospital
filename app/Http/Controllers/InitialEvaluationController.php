<?php

namespace App\Http\Controllers;

use App\Models\InitialEvaluation;
use App\Exports\InitialEvaluationExport;
use App\Exports\InitialEvaluationPdfExport;
use App\Exports\InitialEvaluationSinglePdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InitialEvaluationController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:initial-evaluations-read|initial-evaluations-create|initial-evaluations-update|initial-evaluations-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:initial-evaluations-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:initial-evaluations-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:initial-evaluations-delete', ['only' => ['destroy']]);
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

        $query = InitialEvaluation::with(['patient', 'provider']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $evaluations = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('initial-evaluations._index', compact('evaluations'));
        }

        return view('initial-evaluations.index', compact('evaluations'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new InitialEvaluationExport($request), 'InitialEvaluations.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new InitialEvaluationPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Export Initial Evaluation to PDF
     *
     * @param  \App\Models\InitialEvaluation  $initialEvaluation
     * @return \Illuminate\Http\Response
     */
    private function exportInitialEvaluationPdf(InitialEvaluation $initialEvaluation)
    {
        $pdfExport = new InitialEvaluationSinglePdfExport($initialEvaluation);
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
        $currentUser = auth()->user();
        $currentDate = now()->format('Y-m-d');
        return view('initial-evaluations.create', compact('patients', 'currentUser', 'currentDate'));
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
        
        $data = $request->all();
        $data['provider_id'] = auth()->id();
        $data['provider_name'] = auth()->user()->name;
        $data['date'] = now()->format('Y-m-d');
        $data['vital_signs'] = json_encode($request->vital_signs);
        
        InitialEvaluation::create($data);
        return redirect()->route('initial-evaluations.index')->with('success', 'Initial Evaluation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InitialEvaluation  $initialEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(InitialEvaluation $initialEvaluation)
    {
        // Check if this is a PDF export request
        if (request()->export_pdf) {
            return $this->exportInitialEvaluationPdf($initialEvaluation);
        }
        
        // Manually decode the vital_signs JSON string to an array
        if ($initialEvaluation->vital_signs) {
            $initialEvaluation->vital_signs = json_decode($initialEvaluation->vital_signs, true);
        }
        
        return view('initial-evaluations.show', compact('initialEvaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InitialEvaluation  $initialEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(InitialEvaluation $initialEvaluation)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        $currentUser = auth()->user();
        
        // Manually decode the vital_signs JSON string to an array
        if ($initialEvaluation->vital_signs) {
            $initialEvaluation->vital_signs = json_decode($initialEvaluation->vital_signs, true);
        }
        
        return view('initial-evaluations.edit', compact('initialEvaluation', 'patients', 'currentUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InitialEvaluation  $initialEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InitialEvaluation $initialEvaluation)
    {
        $this->validation($request, $initialEvaluation->id);
        
        $data = $request->all();
        $data['provider_id'] = auth()->id();
        $data['provider_name'] = auth()->user()->name;
        $data['vital_signs'] = json_encode($request->vital_signs);
        
        $initialEvaluation->update($data);
        return redirect()->route('initial-evaluations.index')->with('success', 'Initial Evaluation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InitialEvaluation  $initialEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(InitialEvaluation $initialEvaluation)
    {
        $initialEvaluation->delete();
        return redirect()->route('initial-evaluations.index')->with('success', 'Initial Evaluation deleted successfully.');
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
            'vital_signs' => ['nullable', 'array'],
            // Add other validation rules as needed
        ]);
    }
}
