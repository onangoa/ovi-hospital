<?php

namespace App\Http\Controllers;

use App\Models\TherapyReport;
use App\Exports\TherapyReportExport;
use App\Exports\TherapyReportPdfExport;
use App\Exports\TherapyReportsPdfExport;
use App\Exports\IndividualTherapyReportExport;
use App\Exports\GroupTherapyReportExport;
use App\Exports\IndividualTherapyReportsPdfExport;
use App\Exports\GroupTherapyReportsPdfExport;
use App\Exports\IndividualTherapyReportPdfExport;
use App\Exports\GroupTherapyReportPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TherapyReportController extends Controller
{
    /**
     * Display a listing of therapy reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Redirect to individual therapy reports by default
        return redirect()->route('therapy-reports.individual');
    }

    /**
     * Display a listing of individual therapy reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexIndividual(Request $request)
    {
        if ($request->export)
            return $this->doIndividualExport($request);
        
        if ($request->export_pdf)
            return $this->doIndividualPdfExport($request);

        $query = TherapyReport::whereNotNull('patient_id');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        
        if ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        $therapyReports = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('therapy-reports._index-individual', compact('therapyReports'));
        }

        return view('therapy-reports.index-individual', compact('therapyReports'));
    }

    /**
     * Display a listing of group therapy reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGroup(Request $request)
    {
        if ($request->export)
            return $this->doGroupExport($request);
        
        if ($request->export_pdf)
            return $this->doGroupPdfExport($request);

        $query = TherapyReport::whereNull('patient_id');

        if ($request->filled('participant_ids')) {
            $query->whereJsonContains('participant_ids', $request->participant_ids);
        }
        
        if ($request->filled('physiotherapist_id')) {
            $query->where('physiotherapist_id', $request->physiotherapist_id);
        }

        $therapyReports = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('therapy-reports._index-group', compact('therapyReports'));
        }

        return view('therapy-reports.index-group', compact('therapyReports'));
    }

    /**
     * Performs individual therapy exporting
     *
     * @param Request $request
     * @return void
     */
    private function doIndividualExport(Request $request)
    {
        return Excel::download(new IndividualTherapyReportExport($request), 'IndividualTherapyReports.xlsx');
    }
    
    /**
     * Performs group therapy exporting
     *
     * @param Request $request
     * @return void
     */
    private function doGroupExport(Request $request)
    {
        return Excel::download(new GroupTherapyReportExport($request), 'GroupTherapyReports.xlsx');
    }
    
    /**
     * Performs individual therapy PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doIndividualPdfExport(Request $request)
    {
        $pdfExport = new IndividualTherapyReportsPdfExport($request);
        return $pdfExport->download();
    }
    
    /**
     * Performs group therapy PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doGroupPdfExport(Request $request)
    {
        $pdfExport = new GroupTherapyReportsPdfExport($request);
        return $pdfExport->download();
    }


    /**
     * Show the form for creating a new individual therapy session.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIndividual()
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        $currentUser = auth()->user();
        $todayDate = now()->format('Y-m-d');
        $currentWeekday = now()->format('l'); // Get current weekday name (e.g., "Wednesday")

        // Get doctor assignments for today that have patients assigned (individual therapy sessions)
        $individualAssignments = \App\Models\DoctorAssignment::where('doctor_id', $currentUser->id)
            ->where(function($query) use ($todayDate, $currentWeekday) {
                // Get assignments for today's date OR assignments for today's weekday
                $query->where('appointment_date', $todayDate)
                      ->orWhere('weekday', $currentWeekday);
            })
            ->whereNotNull('patient_id') // Only get individual patient assignments
            ->where('status', '!=', 'cancelled') // Exclude cancelled assignments
            ->with(['patient'])
            ->orderBy('start_time')
            ->get();

        $timeSlots = [];
        foreach ($individualAssignments as $assignment) {
            if ($assignment->patient && $assignment->start_time && $assignment->end_time) {
                $startTime = \Carbon\Carbon::parse($assignment->start_time);
                $endTime = \Carbon\Carbon::parse($assignment->end_time);
                
                $slotString = $startTime->format('g:i A') . ' - ' . $endTime->format('g:i A');
                $timeSlots[] = $slotString;
            }
        }

        return view('therapy-reports.create-individual', compact('patients', 'currentUser', 'timeSlots', 'individualAssignments'));
    }

    /**
     * Show the form for creating a new group therapy session.
     *
     * @return \Illuminate\Http\Response
     */
    public function createGroup()
    {
        $wards = \App\Models\Ward::where('status', '1')
            ->where('company_id', session('company_id'))
            ->get();
        $currentUser = auth()->user();
        $todayDate = now()->format('Y-m-d');
        $currentWeekday = now()->format('l'); // Get current weekday name (e.g., "Wednesday")

        // Get doctor ward assignments for today (group therapy sessions)
        $wardAssignments = \App\Models\DoctorAssignment::where('doctor_id', $currentUser->id)
            ->where(function($query) use ($todayDate, $currentWeekday) {
                // Get assignments for today's date OR assignments for today's weekday
                $query->where('appointment_date', $todayDate)
                      ->orWhere('weekday', $currentWeekday);
            })
            ->whereNull('patient_id') // Only get ward assignments, not patient appointments
            ->where('status', '!=', 'cancelled') // Exclude cancelled assignments
            ->with(['ward'])
            ->orderBy('start_time')
            ->get();

        $timeSlots = [];
        foreach ($wardAssignments as $assignment) {
            if ($assignment->ward && $assignment->start_time && $assignment->end_time) {
                $startTime = \Carbon\Carbon::parse($assignment->start_time);
                $endTime = \Carbon\Carbon::parse($assignment->end_time);
                
                $slotString = $startTime->format('g:i A') . ' - ' . $endTime->format('g:i A');
                $timeSlots[] = $slotString;
            }
        }

        return view('therapy-reports.create-group', compact('wards', 'currentUser', 'timeSlots', 'wardAssignments'));
    }


    /**
     * Store a newly created individual therapy session in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIndividual(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'session_time' => 'nullable|string|max:255',
            'patient_id' => 'nullable|exists:users,id',
            'session_summary' => 'nullable|string',
            'overall_observations' => 'nullable|string',
            'equipment_clean_up' => 'nullable|string',
            'additional_comments' => 'nullable|string',
        ]);

        $data = $request->all();

        $data['physiotherapist_id'] = auth()->id();

        TherapyReport::create($data);

        return redirect()->route('therapy-reports.individual')
            ->with('success', 'Individual therapy report created successfully.');
    }

    /**
     * Update the specified individual therapy session in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function updateIndividual(Request $request, TherapyReport $therapyReport)
    {
        $request->validate([
            'date' => 'nullable|date',
            'session_time' => 'nullable|string|max:255',
            'patient_id' => 'nullable|exists:users,id',
            'session_summary' => 'nullable|string',
            'overall_observations' => 'nullable|string',
            'equipment_clean_up' => 'nullable|string',
            'additional_comments' => 'nullable|string',
        ]);

        $data = $request->all();

        $data['physiotherapist_id'] = auth()->id();

        $therapyReport->update($data);

        return redirect()->route('therapy-reports.individual')
            ->with('success', 'Individual therapy report updated successfully.');
    }

    /**
     * Update the specified group therapy session in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function updateGroup(Request $request, TherapyReport $therapyReport)
    {
        $request->validate([
            'date' => 'nullable|date',
            'participant_ids' => 'nullable|array',
            'participant_ids.*' => 'exists:users,id',
            'group_session_summary' => 'nullable|string',
            'overall_observations' => 'nullable|string',
            'equipment_clean_up' => 'nullable|string',
            'additional_comments' => 'nullable|string',
        ]);

        $data = $request->all();
        if ($request->participant_ids) {
            $data['participant_ids'] = $request->participant_ids;
        } else {
            $data['participant_ids'] = null;
        }

        $data['physiotherapist_id'] = auth()->id();

        $therapyReport->update($data);

        return redirect()->route('therapy-reports.group')
            ->with('success', 'Group therapy report updated successfully.');
    }

    /**
     * Show the form for editing the specified individual therapy session.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function editIndividual(TherapyReport $therapyReport)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        $currentUser = auth()->user();
        return view('therapy-reports.edit-individual', compact('therapyReport', 'patients', 'currentUser'));
    }

    /**
     * Show the form for editing the specified group therapy session.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function editGroup(TherapyReport $therapyReport)
    {
        $patients = \App\Models\User::role('Patient')->where('company_id', session('company_id'))->where('status', '1')->get();
        $selectedParticipants = $therapyReport->participant_ids ?? [];
        $currentUser = auth()->user();
        return view('therapy-reports.edit-group', compact('therapyReport', 'patients', 'selectedParticipants', 'currentUser'));
    }

    /**
     * Store a newly created group therapy session in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGroup(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'session_time' => 'nullable|string|max:255',
            'ward_id' => 'required|exists:wards,id',
            'group_session_summary' => 'nullable|string',
            'overall_observations' => 'nullable|string',
            'equipment_clean_up' => 'nullable|string',
            'additional_comments' => 'nullable|string',
        ]);

        $data = $request->except('ward_id');
        $ward = \App\Models\Ward::with('patients')->find($request->ward_id);

        if ($ward && $ward->patients->isNotEmpty()) {
            // Get all current patients assigned to the ward
            $participantIds = $ward->patients->pluck('id')->toArray();
            $data['participant_ids'] = $participantIds;
            $data['ward_id'] = $request->ward_id;
        } else {
            $data['participant_ids'] = null;
            $data['ward_id'] = null;
        }

        $data['physiotherapist_id'] = auth()->id();

        TherapyReport::create($data);

        return redirect()->route('therapy-reports.group')
            ->with('success', 'Group therapy report created successfully.');
    }

    /**
     * Display the specified individual therapy report.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function showIndividual(TherapyReport $therapyReport)
    {
        if (request()->export_pdf) {
            return $this->exportIndividualTherapyReportPdf($therapyReport);
        }
        
        return view('therapy-reports.show-individual', compact('therapyReport'));
    }

    /**
     * Display the specified group therapy report.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function showGroup(TherapyReport $therapyReport)
    {
        if (request()->export_pdf) {
            return $this->exportGroupTherapyReportPdf($therapyReport);
        }
        
        return view('therapy-reports.show-group', compact('therapyReport'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function show(TherapyReport $therapyReport)
    {
        // Check if it's an individual therapy report (has patient_id)
        if (!empty($therapyReport->patient_id)) {
            return redirect()->route('individual-therapy.show', $therapyReport->id);
        } else {
            // It's a group therapy report
            return redirect()->route('group-therapy.show', $therapyReport->id);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TherapyReport  $therapyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(TherapyReport $therapyReport)
    {
        $therapyReport->delete();

        return redirect()->back()
            ->with('success', 'Therapy report deleted successfully.');
    }

    /**
     * Get patient information based on selected time slot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatientByTimeSlot(Request $request)
    {
        $timeSlot = $request->get('time_slot');
        $todayDate = now()->format('Y-m-d');
        $currentWeekday = now()->format('l'); // Get current weekday name (e.g., "Wednesday")
        $currentUser = auth()->user();

        // Validate input
        if (empty($timeSlot)) {
            return response()->json(['error' => 'Time slot is required'], 400);
        }

        // Parse the time slot to get start and end times
        $times = explode(' - ', $timeSlot);
        if (count($times) != 2) {
            return response()->json(['error' => 'Invalid time slot format'], 400);
        }

        try {
            $startTime = \Carbon\Carbon::parse($times[0])->format('H:i:s');
            $endTime = \Carbon\Carbon::parse($times[1])->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid time format'], 400);
        }

        // Find the appointment for this time slot (check both date and weekday assignments)
        $appointment = \App\Models\DoctorAssignment::where('doctor_id', $currentUser->id)
            ->where(function($query) use ($todayDate, $currentWeekday) {
                // Get assignments for today's date OR assignments for today's weekday
                $query->where('appointment_date', $todayDate)
                      ->orWhere('weekday', $currentWeekday);
            })
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->whereNotNull('patient_id')
            ->where('status', '!=', 'cancelled') // Exclude cancelled assignments
            ->with('patient')
            ->first();

        if ($appointment && $appointment->patient) {
            return response()->json([
                'patient_id' => $appointment->patient->id,
                'patient_name' => $appointment->patient->name,
                'assignment_id' => $appointment->id,
                'status' => $appointment->status
            ]);
        }

        return response()->json(['error' => 'No patient assignment found for this time slot'], 404);
    }

    /**
     * Get ward information based on selected time slot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWardByTimeSlot(Request $request)
    {
        $timeSlot = $request->get('time_slot');
        $todayDate = now()->format('Y-m-d');
        $currentWeekday = now()->format('l'); // Get current weekday name (e.g., "Wednesday")
        $currentUser = auth()->user();

        // Validate input
        if (empty($timeSlot)) {
            return response()->json(['error' => 'Time slot is required'], 400);
        }

        // Parse the time slot to get start and end times
        $times = explode(' - ', $timeSlot);
        if (count($times) != 2) {
            return response()->json(['error' => 'Invalid time slot format'], 400);
        }

        try {
            $startTime = \Carbon\Carbon::parse($times[0])->format('H:i:s');
            $endTime = \Carbon\Carbon::parse($times[1])->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid time format'], 400);
        }

        // Find the ward assignment for this time slot (check both date and weekday assignments)
        $wardAssignment = \App\Models\DoctorAssignment::where('doctor_id', $currentUser->id)
            ->where(function($query) use ($todayDate, $currentWeekday) {
                // Get assignments for today's date OR assignments for today's weekday
                $query->where('appointment_date', $todayDate)
                      ->orWhere('weekday', $currentWeekday);
            })
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->whereNull('patient_id') // Only get ward assignments, not patient appointments
            ->where('status', '!=', 'cancelled') // Exclude cancelled assignments
            ->with('ward')
            ->first();

        if ($wardAssignment && $wardAssignment->ward) {
            return response()->json([
                'ward_id' => $wardAssignment->ward->id,
                'ward_name' => $wardAssignment->ward->name,
                'assignment_id' => $wardAssignment->id,
                'status' => $wardAssignment->status
            ]);
        }

        return response()->json(['error' => 'No ward assignment found for this time slot'], 404);
    }

    /**
     * Export individual therapy report to PDF
     *
     * @param TherapyReport $therapyReport
     * @return \Illuminate\Http\Response
     */
    private function exportIndividualTherapyReportPdf(TherapyReport $therapyReport)
    {
        $pdfExport = new IndividualTherapyReportPdfExport($therapyReport);
        return $pdfExport->download();
    }
    
    /**
     * Export group therapy report to PDF
     *
     * @param TherapyReport $therapyReport
     * @return \Illuminate\Http\Response
     */
    private function exportGroupTherapyReportPdf(TherapyReport $therapyReport)
    {
        $pdfExport = new GroupTherapyReportPdfExport($therapyReport);
        return $pdfExport->download();
    }
}
