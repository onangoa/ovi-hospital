<?php

namespace App\Http\Controllers;

use App\Models\CarePlan;
use App\Exports\CarePlanExport;
use App\Exports\CarePlanPdfExport;
use App\Exports\CarePlanSinglePdfExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CarePlanController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:care-plans-read|care-plans-create|care-plans-update|care-plans-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:care-plans-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:care-plans-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:care-plans-delete', ['only' => ['destroy']]);
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

        $query = CarePlan::with(['patient', 'provider']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $carePlans = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return datatables()->of($carePlans)
                ->editColumn('date', function ($carePlan) {
                    return Carbon::parse($carePlan->date)->format('d M, Y');
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('care-plans.show', $row->id).'" class="btn btn-sm btn-info">View</a>';
                    $btn .= ' <a href="'.route('care-plans.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>';
                    $btn .= ' <form action="'.route('care-plans.destroy', $row->id).'" method="POST" style="display:inline-block;">
                                '.csrf_field().'
                                '.method_field("DELETE").'
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('care-plans.index', compact('carePlans'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new CarePlanExport($request), 'CarePlans.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new CarePlanPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Export Care Plan to PDF
     *
     * @param  \App\Models\CarePlan  $carePlan
     * @return \Illuminate\Http\Response
     */
    private function exportCarePlanPdf(CarePlan $carePlan)
    {
        $pdfExport = new CarePlanSinglePdfExport($carePlan);
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
        return view('care-plans.create', compact('patients', 'currentUser', 'currentDate'));
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
        $data['provider_signature'] = auth()->user()->name;
        $data['date'] = now()->format('Y-m-d');
        
        // Handle multiple medications
        if ($request->has('medications')) {
            $medications = [];
            foreach ($request->medications as $medication) {
                if (!empty($medication['name'])) {
                    $medications[] = [
                        'name' => $medication['name'],
                        'dosage' => $medication['dosage'] ?? '',
                        'frequency' => $medication['frequency'] ?? '',
                        'duration' => $medication['duration'] ?? '',
                        'special_instructions' => $medication['special_instructions'] ?? '',
                    ];
                }
            }
            $data['medications'] = $medications;
        }
        
        CarePlan::create($data);
        return redirect()->route('care-plans.index')->with('success', 'Care Plan created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarePlan  $carePlan
     * @return \Illuminate\Http\Response
     */
    public function show(CarePlan $carePlan)
    {
        // Check if this is a PDF export request
        if (request()->export_pdf) {
            return $this->exportCarePlanPdf($carePlan);
        }
        
        return view('care-plans.show', compact('carePlan'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarePlan  $carePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(CarePlan $carePlan)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        $currentUser = auth()->user();
        return view('care-plans.edit', compact('carePlan', 'patients', 'currentUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarePlan  $carePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarePlan $carePlan)
    {
        $this->validation($request, $carePlan->id);
        
        $data = $request->all();
        $data['provider_id'] = auth()->id();
        $data['provider_signature'] = auth()->user()->name;
        
        // Handle multiple medications
        if ($request->has('medications')) {
            $medications = [];
            foreach ($request->medications as $medication) {
                if (!empty($medication['name'])) {
                    $medications[] = [
                        'name' => $medication['name'],
                        'dosage' => $medication['dosage'] ?? '',
                        'frequency' => $medication['frequency'] ?? '',
                        'duration' => $medication['duration'] ?? '',
                        'special_instructions' => $medication['special_instructions'] ?? '',
                    ];
                }
            }
            $data['medications'] = $medications;
        }
        
        $carePlan->update($data);
        return redirect()->route('care-plans.index')->with('success', 'Care Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarePlan  $carePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarePlan $carePlan)
    {
        $carePlan->delete();
        return redirect()->route('care-plans.index')->with('success', 'Care Plan deleted successfully.');
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
            'medications' => ['nullable', 'array'],
            'medications.*.name' => ['required_with:medications.*', 'string', 'max:255'],
            'medications.*.dosage' => ['nullable', 'string', 'max:255'],
            'medications.*.frequency' => ['nullable', 'string', 'max:255'],
            'medications.*.duration' => ['nullable', 'string', 'max:255'],
            'medications.*.special_instructions' => ['nullable', 'string', 'max:500'],
            // Add other validation rules as needed
        ]);
    }
}
