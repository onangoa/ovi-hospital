<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Exports\PatientDetailsPdfExport;
use App\Exports\PatientDetailPdfExport;
use App\Models\CarePreference;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PatientDetailController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:patient-detail-read|patient-detail-create|patient-detail-update|patient-detail-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patient-detail-create', ['only' => ['create','store']]);
        $this->middleware('permission:patient-detail-update', ['only' => ['edit','update']]);
        $this->middleware('permission:patient-detail-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->export)
            return $this->doExport($request);
            
        if ($request->export_pdf)
            return $this->doPdfExport($request);

        $patientDetails = $this->filter($request)->paginate(10);
        return view('patient-detail.index', compact('patientDetails'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new UserExport($request, 'Patient'), 'Patients.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new PatientDetailsPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        if (auth()->user()->hasRole('Patient')) {
            $query = User::role('Patient')->where('company_id', session('company_id'))->where('id', auth()->id());
        } else {
            $query = User::role('Patient')->where('company_id', session('company_id'));
        }

        $query->with(['cviScores', 'wards' => function ($q) {
            $q->whereNull('patient_ward.discharged_at');
        }])->latest();

        if ($request->name)
            $query->where('name', 'like', $request->name.'%');

        if ($request->phone)
            $query->where('phone', 'like', $request->phone.'%');

        if ($request->email)
            $query->where('email', 'like', $request->email.'%');

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient-detail.create');
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
        $userData = $request->only(['name','phone','address','gender','blood_group','status','weight','height', 'guardian_name', 'guardian_phone', 'guardian_email', 'guardian_address', 'guardian_relation']);
        $userData['email'] = time() . '@gmail.com';
        $userData['company_id'] = session('company_id');
        $userData['password'] = bcrypt('oVi3005');

        $logoUrl = "";
        if($request->hasFile('photo'))
        {
            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('lara/patient',$logoNewName);
            $logoUrl = 'lara/patient/'.$logoNewName;
            $userData['photo'] = $logoUrl;
        }

        if ($request->date_of_birth) {
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);
        }

        DB::transaction(function () use ($userData, $request) {
            $user = User::create($userData);
            $role = Role::where('name', 'Patient')->first();
            $user->assignRole([$role->id]);
            $user->companies()->attach(session('company_id'));

            $carePreferenceData = $request->only(['likes', 'dislikes', 'care_preferences', 'info']);
            $carePreferenceData['user_id'] = $user->id;
            CarePreference::create($carePreferenceData);
        });
        return redirect()->route('patient-details.index')->with('success', trans('Patient Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function show(User $patientDetail)
    {
        if (request()->export_pdf) {
            return $this->exportPatientDetailPdf($patientDetail);
        }
        
        if (auth()->user()->hasRole('Patient') && auth()->id() != $patientDetail->id)
            return redirect()->route('dashboard');

        $patientDetail->load([
            'carePreferences',
            'cviScores',
            'wards' => function ($q) {
                $q->wherePivotNull('discharged_at');
            },
            'medicalReferrals.referringDoctor',
            'radiologyRequests.provider',
            'carePlans.provider',
            'wardRoundNotes.attendingClinician',
            'therapyReports.physiotherapist',
            'caregiverDailyReports.caregiver',
            'labRequests.clinician',
            'labReports.labReportTemplate'
        ]);
        return view('patient-detail.show', compact('patientDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(User $patientDetail)
    {
        return view('patient-detail.edit',compact('patientDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $patientDetail)
    {
        $this->validation($request, $patientDetail->id);

        $userData = $request->only(['name','phone','address','gender','blood_group','status','weight','height', 'guardian_name', 'guardian_phone', 'guardian_email', 'guardian_address', 'guardian_relation']);

        $logoUrl = "";
        if($request->hasFile('photo'))
        {
            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('lara/patient',$logoNewName);
            $logoUrl = 'lara/patient/'.$logoNewName;
            $userData['photo'] = $logoUrl;
        }

        if ($request->date_of_birth)
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);

        DB::transaction(function () use ($patientDetail, $userData, $request) {
            $patientDetail->update($userData);

            $carePreferenceData = $request->only(['likes', 'dislikes', 'care_preferences', 'info']);
            $patientDetail->carePreferences()->updateOrCreate(
                ['user_id' => $patientDetail->id],
                $carePreferenceData
            );
        });

        return redirect()->route('patient-details.index')->with('success', trans('Patient Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patientDetail)
    {
        $patientDetail->delete();
        return redirect()->route('patient-details.index')->with('success', trans('Patient Deleted Successfully'));
    }

    /**
     * validation check for create & edit
     *
     * @param Request $request
     * @param integer $id
     * @return void
     */
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:14'],
            'gender' => ['nullable', 'in:male,female'],
            'blood_group' => ['nullable', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'status' => ['required', 'in:0,1'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'likes' => ['nullable', 'string'],
            'dislikes' => ['nullable', 'string'],
            'care_preferences' => ['nullable', 'string'],
            'info' => ['nullable', 'string'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:14'],
            'guardian_email' => ['nullable', 'email', 'max:255'],
            'guardian_address' => ['nullable', 'string', 'max:1000'],
            'guardian_relation' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * Get patient details for API.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPatientDetails($id)
    {
        $patient = User::find($id);
        
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
        
        // Calculate age from date_of_birth if available
        $age = null;
        if ($patient->date_of_birth) {
            $age = Carbon::parse($patient->date_of_birth)->age;
        }
        
        // Return the data in the format expected by the JavaScript
        return response()->json([
            'id' => $patient->id,
            'name' => $patient->name,
            'age' => $age,
            'weight' => $patient->weight,
            'height' => $patient->height,
            'gender' => $patient->gender,
            'blood_group' => $patient->blood_group,
            'date_of_birth' => $patient->date_of_birth,
            'phone' => $patient->phone,
            'address' => $patient->address
        ]);
    }
    
    /**
     * Export individual patient detail to PDF
     *
     * @param User $patientDetail
     * @return \Illuminate\Http\Response
     */
    private function exportPatientDetailPdf(User $patientDetail)
    {
        // Load necessary relationships for PDF export
        $patientDetail->load([
            'carePreferences',
            'wards' => function ($q) {
                $q->wherePivotNull('discharged_at');
            }
        ]);
        
        $pdfExport = new PatientDetailPdfExport($patientDetail);
        return $pdfExport->download();
    }
}
