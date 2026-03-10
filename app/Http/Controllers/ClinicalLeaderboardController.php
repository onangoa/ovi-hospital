<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ClinicalLeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $providerId = $request->input('provider_id');

        // Get all potential providers for the filter dropdown
        $providers = User::whereHas('roles', function ($query) {
            // Adjust roles as needed for who is considered a "provider"
            $query->whereIn('name', ['Doctor', 'Nurse', 'Admin', 'Super Admin', 'Physiotherapist']);
        })->orderBy('name')->get();

        // Using correlated subqueries to count notes for each provider.
        $notesLeaderboardQuery = DB::table('users')
            ->select('users.id as provider_id', 'users.name as provider_name')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereColumn('model_has_roles.model_id', 'users.id')
                    ->whereIn('roles.name', ['Doctor', 'Nurse', 'Admin', 'super-admin', 'Physiotherapist']);
            })
            ->when($providerId, function ($query, $providerId) {
                $query->where('users.id', $providerId);
            })
            ->addSelect(DB::raw(
                '(SELECT COUNT(*) FROM therapy_reports WHERE therapy_reports.physiotherapist_id = users.id AND DATE(therapy_reports.date) BETWEEN ? AND ?) +
                 (SELECT COUNT(*) FROM prescriptions WHERE prescriptions.doctor_id = users.id AND DATE(prescriptions.prescription_date) BETWEEN ? AND ?) +
                 (SELECT COUNT(*) FROM lab_requests WHERE lab_requests.clinician_id = users.id AND DATE(lab_requests.request_date) BETWEEN ? AND ?) +
                 (SELECT COUNT(*) FROM radiology_requests WHERE radiology_requests.provider_id = users.id AND DATE(radiology_requests.created_at) BETWEEN ? AND ?) +
                 (SELECT COUNT(*) FROM nursing_cardexes WHERE nursing_cardexes.nurse_on_duty_id = users.id AND DATE(nursing_cardexes.date) BETWEEN ? AND ?) +
                 (SELECT COUNT(*) FROM drug_orders WHERE drug_orders.ordered_by_id = users.id AND DATE(drug_orders.date) BETWEEN ? AND ?)
                 as notes_submitted'
            ))
            ->addSelect(DB::raw(
                '(SELECT COUNT(*) FROM doctor_assignments WHERE doctor_assignments.doctor_id = users.id AND DATE(doctor_assignments.appointment_date) BETWEEN ? AND ? AND doctor_assignments.patient_id IS NOT NULL)
                 as appointments_conducted'
            ));

        $bindings = [];
        // Add bindings for notes_submitted (6 pairs of dates)
        for ($i = 0; $i < 6; $i++) {
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }
        // Add bindings for appointments_conducted (1 pair of dates)
        $bindings[] = $startDate;
        $bindings[] = $endDate;
        
        $notesLeaderboardQuery->setBindings($bindings, 'select');

        $notesLeaderboard = $notesLeaderboardQuery->groupBy('users.id', 'users.name')->get()->keyBy('provider_id');

        // Using UNION to collect all patient interactions and then counting distinct patients.
        $labPatients = DB::table('lab_requests')
            ->select('clinician_id as provider_id', 'patient_id')
            ->whereBetween('request_date', [$startDate, $endDate])->whereNotNull('patient_id');

        $prescriptionPatients = DB::table('prescriptions')
            ->select('doctor_id as provider_id', 'user_id as patient_id')
            ->whereBetween('prescription_date', [$startDate, $endDate])->whereNotNull('user_id');

        $radiologyPatients = DB::table('radiology_requests')
            ->select('provider_id as provider_id', 'patient_id')
            ->whereBetween('created_at', [$startDate, $endDate])->whereNotNull('patient_id');

        $nursingPatients = DB::table('nursing_cardexes')
            ->select('nurse_on_duty_id as provider_id', 'patient_id')
            ->whereBetween('date', [$startDate, $endDate])->whereNotNull('patient_id');

        $appointmentPatients = DB::table('doctor_assignments')
            ->select('doctor_id as provider_id', 'patient_id')
            ->whereBetween('appointment_date', [$startDate, $endDate])->whereNotNull('patient_id');

        $patientsUnion = $labPatients
            ->union($prescriptionPatients)
            ->union($radiologyPatients)
            ->union($nursingPatients)
            ->union($appointmentPatients);

        $patientsSeenQuery = DB::query()->fromSub($patientsUnion, 'patients_union')
            ->select('provider_id', DB::raw('COUNT(DISTINCT patient_id) as patients_seen'))
            ->groupBy('provider_id');

        if ($providerId) {
            $patientsSeenQuery->where('provider_id', $providerId);
        }

        $patientsSeen = $patientsSeenQuery->get()->keyBy('provider_id');

        $leaderboard = $notesLeaderboard;

        foreach ($patientsSeen as $provider_id => $data) {
            if ($leaderboard->has($provider_id)) {
                $leaderboard[$provider_id]->patients_seen = $data->patients_seen;
            } else {
                $providerUser = $providers->firstWhere('id', $provider_id);
                if ($providerUser) {
                    $leaderboard->put($provider_id, (object)[
                        'provider_id' => $provider_id,
                        'provider_name' => $providerUser->name,
                        'notes_submitted' => 0,
                        'appointments_conducted' => 0,
                        'patients_seen' => $data->patients_seen,
                    ]);
                }
            }
        }
        
        foreach($leaderboard as $item) {
            if (!isset($item->patients_seen)) {
                $item->patients_seen = 0;
            }
            if (!isset($item->appointments_conducted)) {
                $item->appointments_conducted = 0;
            }
        }

        $leaderboard = $leaderboard->filter(function ($item) {
            return $item->notes_submitted > 0 || $item->patients_seen > 0 || $item->appointments_conducted > 0;
        })->sortByDesc('notes_submitted');

        return view('clinical-leaderboard.index', compact('leaderboard', 'providers', 'startDate', 'endDate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        
        $provider = User::findOrFail($id);
        
        // Get therapy reports
        $therapyReports = DB::table('therapy_reports')
            ->join('users', 'therapy_reports.physiotherapist_id', '=', 'users.id')
            ->where('therapy_reports.physiotherapist_id', $id)
            ->whereBetween('therapy_reports.date', [$startDate, $endDate])
            ->select('therapy_reports.*', 'users.name as provider_name')
            ->get();
            
        // Get prescriptions
        $prescriptions = DB::table('prescriptions')
            ->join('users', 'prescriptions.doctor_id', '=', 'users.id')
            ->where('prescriptions.doctor_id', $id)
            ->whereBetween('prescriptions.prescription_date', [$startDate, $endDate])
            ->select('prescriptions.*', 'users.name as provider_name')
            ->get();
            
        // Get lab requests
        $labRequests = DB::table('lab_requests')
            ->join('users', 'lab_requests.clinician_id', '=', 'users.id')
            ->where('lab_requests.clinician_id', $id)
            ->whereBetween('lab_requests.request_date', [$startDate, $endDate])
            ->select('lab_requests.*', 'users.name as provider_name')
            ->get();
            
        // Get radiology requests
        $radiologyRequests = DB::table('radiology_requests')
            ->where('radiology_requests.provider_id', $id)
            ->whereBetween('radiology_requests.created_at', [$startDate, $endDate])
            ->get();
            
        // Get nursing cardexes
        $nursingCardexes = DB::table('nursing_cardexes')
            ->join('users', 'nursing_cardexes.nurse_on_duty_id', '=', 'users.id')
            ->where('nursing_cardexes.nurse_on_duty_id', $id)
            ->whereBetween('nursing_cardexes.date', [$startDate, $endDate])
            ->select('nursing_cardexes.*', 'users.name as provider_name')
            ->get();
            
        // Get drug orders
        $drugOrders = DB::table('drug_orders')
            ->join('users', 'drug_orders.ordered_by_id', '=', 'users.id')
            ->where('drug_orders.ordered_by_id', $id)
            ->whereBetween('drug_orders.date', [$startDate, $endDate])
            ->select('drug_orders.*', 'users.name as provider_name')
            ->get();
            
        // Get doctor assignments (appointments)
        $appointments = DB::table('doctor_assignments')
            ->join('users as doctors', 'doctor_assignments.doctor_id', '=', 'doctors.id')
            ->leftJoin('users as patients', 'doctor_assignments.patient_id', '=', 'patients.id')
            ->leftJoin('wards', 'doctor_assignments.ward_id', '=', 'wards.id')
            ->where('doctor_assignments.doctor_id', $id)
            ->where('doctor_assignments.patient_id', '!=', null) // Only get appointment assignments
            ->whereBetween('doctor_assignments.appointment_date', [$startDate, $endDate])
            ->select('doctor_assignments.*', 'doctors.name as doctor_name', 'patients.name as patient_name', 'wards.name as ward_name')
            ->get();

        return view('clinical-leaderboard.show', compact(
            'provider',
            'therapyReports',
            'prescriptions',
            'labRequests',
            'radiologyRequests',
            'nursingCardexes',
            'drugOrders',
            'appointments',
            'startDate',
            'endDate'
        ));
    }
}
