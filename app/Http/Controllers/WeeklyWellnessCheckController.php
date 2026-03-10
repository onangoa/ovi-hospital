<?php

namespace App\Http\Controllers;

use App\Models\WeeklyWellnessCheck;
use App\Exports\WeeklyWellnessCheckExport;
use App\Exports\WeeklyWellnessCheckPdfExport;
use App\Exports\WeeklyWellnessChecksPdfExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class WeeklyWellnessCheckController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('permission:weekly-wellness-checks-read|weekly-wellness-checks-create|weekly-wellness-checks-update|weekly-wellness-checks-delete', ['only' => ['index', 'show', 'report']]);
        $this->middleware('permission:weekly-wellness-checks-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:weekly-wellness-checks-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:weekly-wellness-checks-delete', ['only' => ['destroy']]);
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

        $query = WeeklyWellnessCheck::with('patient', 'conductedBy');

        // Apply filters if present
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->conducted_by) {
            $query->where('conducted_by', 'like', '%' . $request->conducted_by . '%');
        }

        $weeklyWellnessChecks = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('weekly-wellness-checks._index', compact('weeklyWellnessChecks'));
        }

        return view('weekly-wellness-checks.index', compact('weeklyWellnessChecks'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new WeeklyWellnessCheckExport($request), 'WeeklyWellnessChecks.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new WeeklyWellnessChecksPdfExport($request);
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
        return view('weekly-wellness-checks.create', compact('patients'));
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
        
        // Handle boolean values
        $data = $request->all();
        $data['full_meals'] = $request->has('full_meals');
        $data['partial_meals'] = $request->has('partial_meals');
        $data['minimal_meals'] = $request->has('minimal_meals');
        
        WeeklyWellnessCheck::create($data);
        return redirect()->route('weekly-wellness-checks.index')->with('success', 'Weekly Wellness Check created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeeklyWellnessCheck  $weeklyWellnessCheck
     * @return \Illuminate\Http\Response
     */
    public function show(WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        if (request()->export_pdf) {
            return $this->exportWeeklyWellnessCheckPdf($weeklyWellnessCheck);
        }
        
        return view('weekly-wellness-checks.show', compact('weeklyWellnessCheck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeeklyWellnessCheck  $weeklyWellnessCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        return view('weekly-wellness-checks.edit', compact('weeklyWellnessCheck', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeeklyWellnessCheck  $weeklyWellnessCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        $this->validation($request, $weeklyWellnessCheck->id);
        
        // Handle boolean values
        $data = $request->all();
        $data['full_meals'] = $request->has('full_meals');
        $data['partial_meals'] = $request->has('partial_meals');
        $data['minimal_meals'] = $request->has('minimal_meals');
        
        $weeklyWellnessCheck->update($data);
        return redirect()->route('weekly-wellness-checks.index')->with('success', 'Weekly Wellness Check updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeeklyWellnessCheck  $weeklyWellnessCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        $weeklyWellnessCheck->delete();
        return redirect()->route('weekly-wellness-checks.index')->with('success', 'Weekly Wellness Check deleted successfully.');
    }

    /**
     * Validation function
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    private function validation(Request $request, $id = 0)
    {
        $rules = [
            'patient_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'conducted_by' => ['required', 'exists:users,id'],
            'vital_signs' => ['nullable', 'array'],
            'skin_wounds' => ['nullable', 'string'],
            'mobility' => ['nullable', 'string'],
            'mobility_notes' => ['nullable', 'string'],
            'sleep' => ['nullable', 'string'],
            'mood' => ['nullable', 'string'],
            'engagement' => ['nullable', 'string'],
            'behavior_changes' => ['nullable', 'string'],
            'with_caregivers' => ['nullable', 'string'],
            'with_peers' => ['nullable', 'string'],
            'communication' => ['nullable', 'string'],
            'pain_indicators' => ['nullable', 'string'],
            'comfort' => ['nullable', 'string'],
            'medication' => ['nullable', 'string'],
            'signs_of_illness' => ['nullable', 'string'],
            'hydration' => ['nullable', 'string'],
            'environment' => ['nullable', 'string'],
            'progress' => ['nullable', 'string'],
            'next_steps' => ['nullable', 'string'],
        ];

        $request->validate($rules);
    }

    public function report(Request $request)
    {
        $selectedDate = $request->has('date') ? Carbon::parse($request->input('date')) : today();
        $startOfWeek = $selectedDate->copy()->startOfWeek();
        $endOfWeek = $selectedDate->copy()->endOfWeek();

        $allPatients = \App\Models\User::role('Patient')
            ->where('company_id', session('company_id'))
            ->where('status', '1')
            ->get();

        $patientIds = $allPatients->pluck('id');

        $wellnessChecksThisWeek = WeeklyWellnessCheck::whereIn('patient_id', $patientIds)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();

        $totalConducted = $wellnessChecksThisWeek->count();

        $checkedPatientIds = $wellnessChecksThisWeek->pluck('patient_id')->unique()->toArray();

        $patientsWithoutCheck = $allPatients->whereNotIn('id', $checkedPatientIds);

        return view('weekly-wellness-checks.report', compact(
            'totalConducted',
            'patientsWithoutCheck',
            'startOfWeek',
            'endOfWeek',
            'selectedDate'
        ));
    }

    /**
     * Export individual weekly wellness check to PDF
     *
     * @param WeeklyWellnessCheck $weeklyWellnessCheck
     * @return \Illuminate\Http\Response
     */
    private function exportWeeklyWellnessCheckPdf(WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        // Load necessary relationships for PDF export
        $weeklyWellnessCheck->load(['patient', 'conductedBy']);
        
        $pdfExport = new WeeklyWellnessCheckPdfExport($weeklyWellnessCheck);
        return $pdfExport->download();
    }
}
