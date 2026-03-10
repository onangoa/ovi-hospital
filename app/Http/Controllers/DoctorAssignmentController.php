<?php

namespace App\Http\Controllers;

use App\Models\DoctorAssignment;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;

class DoctorAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DoctorAssignment::with(['doctor', 'patient', 'ward']);
        
        // Filter by date if provided
        if ($request->has('date') && $request->date) {
            $query->forDate($request->date);
        }
        
        // Filter by doctor if provided
        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->forDoctor($request->doctor_id);
        }
        
        // Filter by ward if provided
        if ($request->has('ward_id') && $request->ward_id) {
            $query->forWard($request->ward_id);
        }
        
        // Filter by type (appointments or ward assignments)
        if ($request->has('type')) {
            if ($request->type === 'appointments') {
                $query->appointments();
            } elseif ($request->type === 'ward_assignments') {
                $query->wardAssignments();
            }
        }
        
        $assignments = $query->orderBy('appointment_date', 'desc')
                            ->orderBy('start_time', 'asc')
                            ->paginate(15);
        
        $doctors = User::has('doctorAppointments')->get();
        $patients = User::doesntHave('doctorAppointments')->get();
        $wards = Ward::all();
        
        return view('doctor-assignments.index', compact('assignments', 'doctors', 'patients', 'wards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = User::whereHas('doctorDetails')->get();
        $patients = User::whereDoesntHave('doctorDetails')->get();
        $wards = Ward::all();
        
        return view('doctor-assignments.create', compact('doctors', 'patients', 'wards'));
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
            'doctor_id' => 'required|exists:users,id',
            'ward_id' => 'required_if:type,ward_assignment|nullable|exists:wards,id',
            'schedule_type' => 'required|in:specific_date,recurring',
            'weekday' => 'required_if:schedule_type,recurring|nullable|string',
            'start_time' => 'required',
            'type' => 'required|in:appointment,ward_assignment',
            'patient_id' => 'required_if:type,appointment|nullable|exists:users,id',
            'end_time' => 'nullable',
            'problem' => 'nullable|string',
        ]);

        // Check for overlapping assignments
        $date = $request->schedule_type === 'specific_date' ? $request->appointment_date : null;
        $weekday = $request->schedule_type === 'recurring' ? $request->weekday : null;
        
        if (DoctorAssignment::hasOverlappingAssignment(
            $request->doctor_id,
            $request->start_time,
            $request->end_time,
            $date,
            $weekday
        )) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['time_conflict' => 'The doctor already has an assignment during this time period.']);
        }

        $assignment = new DoctorAssignment();
        $assignment->doctor_id = $request->doctor_id;
        $assignment->ward_id = $request->ward_id;
        $assignment->start_time = $request->start_time;
        $assignment->end_time = $request->end_time;

        // Handle schedule type
        if ($request->schedule_type === 'specific_date') {
            $assignment->appointment_date = $request->appointment_date;
            $assignment->weekday = null;
        } else {
            $assignment->weekday = $request->weekday;
        }

        if ($request->type === 'appointment') {
            $assignment->patient_id = $request->patient_id;
            $assignment->problem = $request->problem;
            $assignment->status = 'scheduled';
        } else {
            $assignment->patient_id = null;
            $assignment->status = 'scheduled';
        }

        $assignment->save();

        return redirect()->route('doctor-assignments.index')
            ->with('success', 'Doctor assignment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorAssignment  $doctorAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorAssignment $doctorAssignment)
    {
        $doctorAssignment->load(['doctor', 'patient', 'ward']);
        
        return view('doctor-assignments.show', compact('doctorAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorAssignment  $doctorAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorAssignment $doctorAssignment)
    {
        $doctors = User::whereHas('doctorDetails')->get();
        $patients = User::whereDoesntHave('doctorDetails')->get();
        $wards = Ward::all();
        
        return view('doctor-assignments.edit', compact('doctorAssignment', 'doctors', 'patients', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorAssignment  $doctorAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorAssignment $doctorAssignment)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'ward_id' => 'required_if:type,ward_assignment|nullable|exists:wards,id',
            'schedule_type' => 'required|in:specific_date,recurring',
            'weekday' => 'required_if:schedule_type,recurring|nullable|string',
            'start_time' => 'required',
            'type' => 'required|in:appointment,ward_assignment',
            'patient_id' => 'required_if:type,appointment|nullable|exists:users,id',
            'end_time' => 'nullable',
            'problem' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        // Check for overlapping assignments
        $date = $request->schedule_type === 'specific_date' ? $request->appointment_date : null;
        $weekday = $request->schedule_type === 'recurring' ? $request->weekday : null;
        
        if (DoctorAssignment::hasOverlappingAssignment(
            $request->doctor_id,
            $request->start_time,
            $request->end_time,
            $date,
            $weekday,
            $doctorAssignment->id
        )) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['time_conflict' => 'The doctor already has an assignment during this time period.']);
        }

        $doctorAssignment->doctor_id = $request->doctor_id;
        $doctorAssignment->ward_id = $request->ward_id;
        $doctorAssignment->start_time = $request->start_time;
        $doctorAssignment->end_time = $request->end_time;
        $doctorAssignment->status = $request->status;

        // Handle schedule type
        if ($request->schedule_type === 'specific_date') {
            $doctorAssignment->appointment_date = $request->appointment_date;
            $doctorAssignment->weekday = null;
        } else {
            $doctorAssignment->weekday = $request->weekday;
        }

        if ($request->type === 'appointment') {
            $doctorAssignment->patient_id = $request->patient_id;
            $doctorAssignment->problem = $request->problem;
        } else {
            $doctorAssignment->patient_id = null;
            $doctorAssignment->problem = null;
        }

        $doctorAssignment->save();

        return redirect()->route('doctor-assignments.index')
            ->with('success', 'Doctor assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorAssignment  $doctorAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorAssignment $doctorAssignment)
    {
        $doctorAssignment->delete();

        return redirect()->route('doctor-assignments.index')
            ->with('success', 'Doctor assignment deleted successfully.');
    }

    /**
     * Get doctor schedule for calendar view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getScheduleDoctorWise(Request $request)
    {
        $doctorId = $request->get('doctor_id');
        $date = $request->get('date');
        
        $assignments = DoctorAssignment::with(['patient', 'ward'])
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->orderBy('start_time')
            ->get();
        
        return response()->json($assignments);
    }
}