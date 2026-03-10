<?php

namespace App\Http\Controllers;

use App\Models\HospitalDepartment;
use App\Models\Invoice;
use App\Models\DoctorAssignment;
use App\Models\PatientCaseStudy;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\User;
use App\Models\Ward;
use App\Models\DrugOrder;
use App\Models\CarePlan;
use App\Models\WeeklyWellnessCheck;
use App\Models\TherapyReport;
use App\Models\LabReport;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 * @category Controller
 */
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            return $this->adminDashboard();
        } else {
            // Always fetch doctor assignments based on user role
            if (auth()->user()->hasRole('Doctor')) {
                $doctorId = auth()->user()->id;
                $doctorAssignments = DoctorAssignment::with(['patient', 'ward', 'doctor'])
                    ->where('doctor_id', $doctorId)
                    ->where('company_id', session('company_id'))
                    ->get();
                    
                // Also fetch patient appointments for backward compatibility
                $patientAppointment = $doctorAssignments;
                return view('dashboards.common-dashboard', compact('patientAppointment', 'doctorAssignments'));
            } elseif (auth()->user()->hasRole('Patient')) {
                $patientId = auth()->user()->id;
                $doctorAssignments = DoctorAssignment::with(['patient', 'ward', 'doctor'])
                    ->where('patient_id', $patientId)
                    ->where('company_id', session('company_id'))
                    ->get();
                    
                // Also fetch appointments for backward compatibility
                $appointments = $doctorAssignments;
                return view('dashboards.common-dashboard', compact('appointments', 'doctorAssignments'));
            } elseif (auth()->user()->hasRole('Receptionist')) {
                $doctorAssignments = DoctorAssignment::with(['patient', 'ward', 'doctor'])
                    ->where('company_id', session('company_id'))
                    ->get();
                    
                // Also fetch receptionist appointments for backward compatibility
                $receptionistAppointments = $doctorAssignments;
                return view('dashboards.common-dashboard', compact('receptionistAppointments', 'doctorAssignments'));
            } else {
                // For other roles, fetch all doctor assignments
                $doctorAssignments = DoctorAssignment::with(['patient', 'ward', 'doctor'])
                    ->where('company_id', session('company_id'))
                    ->get();
                return view('dashboards.common-dashboard', compact('doctorAssignments'));
            }
        }
    }

    /**
     * shows admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    private function adminDashboard()
    {
        $dashboardCounts = $this->dashboardCounts();

        return view('dashboardview', compact('dashboardCounts'));
    }

    /**
     * shows admin chart data
     *
     * @return \Illuminate\Http\Response
     */
    public function getChartData()
    {
        return response()->json([
            'monthlyAppointments' => $this->monthlyAppointments(),
            'wardDistribution' => $this->wardDistribution(),
            'patientDoctorRatio' => $this->patientDoctorRatio(),
            'wellnessCheckStats' => $this->wellnessCheckStats()
        ], 200);
    }

    /**
     * Get monthly appointments data for chart
     *
     * @return array
     */
    private function monthlyAppointments()
    {
        return cache()->remember('monthlyAppointments', 600, function () {
            $appointments = []; $labels = [];
            $results = DB::select('SELECT DISTINCT YEAR(appointment_date) AS "year", MONTH(appointment_date) AS "month" FROM doctor_assignments ORDER BY year DESC LIMIT 12');
            foreach ($results as $result) {
                $labels[] = date('F', mktime(0, 0, 0, $result->month, 10)).' '.$result->year;
                $appointments[] = DoctorAssignment::whereYear('appointment_date', $result->year)->whereMonth('appointment_date', $result->month)->count();
            }

            return [
                'appointments' => $appointments,
                'labels' => $labels
            ];
        });
    }

    /**
     * Get ward distribution data for chart
     *
     * @return array
     */
    private function wardDistribution()
    {
        return cache()->remember('wardDistribution', 600, function () {
            $wards = Ward::withCount(['patients'])->get();
            $wardNames = [];
            $patientCounts = [];

            foreach ($wards as $ward) {
                $wardNames[] = $ward->name;
                $patientCounts[] = $ward->patients_count;
            }

            return [
                'wards' => $wardNames,
                'patientCounts' => $patientCounts
            ];
        });
    }

    /**
     * Get patient vs doctors ratio data for chart
     *
     * @return array
     */
    private function patientDoctorRatio()
    {
        return cache()->remember('patientDoctorRatio', 600, function () {
            $patientCount = User::role('Patient')->count();
            $doctorCount = User::role('Doctor')->count();

            return [
                'patients' => $patientCount,
                'doctors' => $doctorCount
            ];
        });
    }

    /**
     * Get wellness check engagement statistics for charting
     *
     * @return array
     */
    private function wellnessCheckStats()
    {
        return cache()->remember('wellnessCheckStats', 600, function () {
            // Get engagement data grouped by month for the last 12 months
            $engagementData = DB::table('weekly_wellness_checks')
                ->select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('MONTHNAME(date) as month_name'),
                    DB::raw('AVG(CASE WHEN engagement REGEXP "^[0-9]+$" THEN CAST(engagement AS UNSIGNED) ELSE NULL END) as avg_engagement')
                )
                ->where('date', '>=', now()->subMonths(12))
                ->groupBy('year', 'month', 'month_name')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $labels = [];
            $engagementScores = [];

            foreach ($engagementData as $data) {
                $labels[] = $data->month_name . ' ' . $data->year;
                $engagementScores[] = round($data->avg_engagement, 2);
            }

            return [
                'labels' => $labels,
                'engagementScores' => $engagementScores
            ];
        });
    }

    private function dashboardCounts()
    {
        // Clear the cache to ensure new keys are included
        cache()->forget('dashboardCounts');
        
        return cache()->remember('dashboardCounts', 600, function () {
            return [
                'departments' => HospitalDepartment::count(),
                'doctors' => User::role('Doctor')->count(),
                'patients' => User::role('Patient')->count(),
                'appointments' => DoctorAssignment::count(),
                'caseStudies' => PatientCaseStudy::count(),
                'prescriptions' => Prescription::count(),
                'wards' => Ward::count(),
                'drugOrders' => DrugOrder::count(),
                'carePlans' => CarePlan::count(),
                'wellnessChecks' => WeeklyWellnessCheck::count(),
                'therapyReports' => TherapyReport::count(),
                'labReports' => LabReport::count(),
                'insurancePolicies' => Insurance::count()
            ];
        });
    }
}
