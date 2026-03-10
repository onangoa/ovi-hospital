<?php

namespace App\Http\Controllers;

use App\Models\DoctorAssignment;
use App\Models\Ward;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WardController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:ward-read|ward-create|ward-update|ward-delete', ['only' => ['index','show']]);
        $this->middleware('permission:ward-create', ['only' => ['create','store']]);
        $this->middleware('permission:ward-update', ['only' => ['edit','update']]);
        $this->middleware('permission:ward-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->filled('patient_id')) {
            $patient = User::find($request->patient_id);
            $wards = collect();
            if ($patient) {
                // Get wards where patient is currently assigned (not discharged)
                $wards = $patient->wards()->wherePivotNull('discharged_at')->get();
            }
            return view('wards._index', compact('wards'));
        }

        $wards = Ward::where('company_id', session('company_id'))->paginate(10);
        return view('wards.index', compact('wards'));
    }

    /**
     * Show form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wards.create');
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

        $data = $request->only(['name', 'description', 'capacity', 'status']);
        // Set capacity to 0 if it's null
        if ($data['capacity'] === null) {
            $data['capacity'] = 0;
        }
        $data['company_id'] = session('company_id');
        Ward::create($data);

        return redirect()->route('wards.index')->with('success', trans('Ward Created Successfully'));
    }

    /**
     * Display specified resource.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function show(Ward $ward, Request $request)
    {
        // Check if assign_patient parameter is set
        $assignPatient = $request->get('assign_patient', 0);
        
        // Load assigned patients and doctors with their assignments
        $ward->load(['patients', 'doctors', 'doctorAssignments.doctor']);
        
        // Get all patients and doctors for assignment
        $patients = User::where('company_id', session('company_id'))
                      ->whereHas('roles', function($query) {
                          $query->where('name', 'Patient');
                      })->get();
                      
        $doctors = User::where('company_id', session('company_id'))
                      ->whereHas('roles', function($query) {
                          $query->where('name', 'Doctor');
                      })
                      ->get();
                      
        // Get doctor assignments for this ward (assignments with ward_id and null patient_id)
        // Using same query structure as DoctorAssignmentController
        $wardAppointments = DoctorAssignment::with(['doctor', 'patient', 'ward'])
            ->forWard($ward->id)
            ->wardAssignments() // Only get ward assignments, not patient appointments
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
                      
        return view('wards.show', compact('ward', 'patients', 'doctors', 'wardAppointments', 'assignPatient'));
    }

    /**
     * Show form for editing specified resource.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function edit(Ward $ward)
    {
        $doctors = User::role('Doctor')->where('company_id', session('company_id'))->get();
        return view('wards.edit', compact('ward', 'doctors'));
    }

    /**
     * Update specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ward $ward)
    {
        $this->validation($request, $ward->id);

        $data = $request->only(['name', 'description', 'capacity', 'status']);
        // Set capacity to 0 if it's null
        if ($data['capacity'] === null) {
            $data['capacity'] = 0;
        }
        $ward->update($data);

        return redirect()->route('wards.index')->with('success', trans('Ward Updated Successfully'));
    }

    /**
     * Remove specified resource from storage.
     *
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ward $ward)
    {
        // Check if ward has assigned patients or doctors
        if ($ward->patients()->count() > 0 || $ward->doctors()->count() > 0) {
            return redirect()->route('wards.index')->with('error', trans('Ward cannot be deleted as it has assigned patients or doctors'));
        }

        $ward->delete();
        return redirect()->route('wards.index')->with('success', trans('Ward Deleted Successfully'));
    }

    /**
     * Assign patients to ward
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function assignPatients(Request $request, Ward $ward)
    {
        $request->validate([
            'patient_ids' => 'required|array',
            'patient_ids.*' => 'exists:users,id',
        ]);

        $alreadyAssigned = [];
        $newlyAssignedIds = [];

        foreach ($request->patient_ids as $patientId) {
            $patient = User::find($patientId);
            if ($patient->wards()->wherePivotNull('discharged_at')->exists()) {
                $alreadyAssigned[] = $patient->name;
            } else {
                $newlyAssignedIds[] = $patientId;
            }
        }

        if (!empty($newlyAssignedIds)) {
            $ward->patients()->attach($newlyAssignedIds, ['created_at' => now()]);
        }

        if (!empty($alreadyAssigned)) {
            $message = trans('The following patients were already assigned to a ward and were not assigned again: ') . implode(', ', $alreadyAssigned);
            if (!empty($newlyAssignedIds)) {
                $message = trans('Some patients were assigned successfully. ') . $message;
                return redirect()->route('wards.show', $ward)->with('warning', $message);
            }
            return redirect()->route('wards.show', $ward)->with('error', $message);
        }

        return redirect()->route('wards.show', $ward)->with('success', trans('Patients assigned to ward successfully'));
    }

    /**
     * Assign doctors to ward
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function assignDoctors(Request $request, Ward $ward)
    {
        return redirect()->route('wards.show', $ward)->with('error', trans('Doctor assignment functionality has been disabled as doctor schedules module has been removed.'));
    }

    /**
     * Discharge patient from ward
     *
     * @param  \App\Models\Ward  $ward
     * @param  \App\Models\User  $patient
     * @return \Illuminate\Http\Response
     */
    public function dischargePatient(Ward $ward, User $patient)
    {
        $ward->patients()->updateExistingPivot($patient->id, ['discharged_at' => now()]);

        return redirect()->route('wards.show', $ward)->with('success', trans('Patient discharged from ward successfully'));
    }

    /**
     * Remove doctor from ward
     *
     * @param  \App\Models\Ward  $ward
     * @param  \App\Models\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function removeDoctor(Ward $ward, User $doctor)
    {
        $ward->doctors()->detach($doctor->id);
        
        // Also remove any patient appointments associated with this doctor-ward assignment
        DoctorAssignment::where('doctor_id', $doctor->id)
            ->where('ward_id', $ward->id)
            ->whereNull('patient_id') // Only remove ward appointments (not patient appointments)
            ->delete();

        return redirect()->route('wards.show', $ward)->with('success', trans('Doctor removed from ward successfully'));
    }

    /**
     * Remove specific doctor assignment from ward
     *
     * @param  \App\Models\Ward  $ward
     * @param  \App\Models\DoctorAssignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function removeDoctorAssignment(Ward $ward, DoctorAssignment $assignment)
    {
        // Verify assignment belongs to this ward
        if ($assignment->ward_id !== $ward->id) {
            return redirect()->route('wards.show', $ward)->with('error', trans('Invalid assignment'));
        }

        // Remove specific assignment
        $assignment->delete();
        
        // Also remove any patient appointments associated with this specific assignment
        DoctorAssignment::where('doctor_id', $assignment->doctor_id)
            ->where('ward_id', $ward->id)
            ->whereNull('patient_id') // Only remove ward appointments (not patient appointments)
            ->where('start_time', $assignment->slot_time)
            ->delete();

        return redirect()->route('wards.show', $ward)->with('success', trans('Doctor assignment removed from ward successfully'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'unique:wards,name,'.$id, 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive']
        ]);
    }
}
