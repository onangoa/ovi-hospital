<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\DoctorDetail;
use App\Models\HospitalDepartment;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;

/**
 * Class UserController
 * @package App\Http\Controllers
 * @category Controller
 */
class UserController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
   function __construct()
   {
       $this->middleware('permission:user-list|user-create|user-update|user-delete', ['only' => ['index']]);
       $this->middleware('permission:user-create', ['only' => ['create','store']]);
       $this->middleware('permission:user-update', ['only' => ['edit','update']]);
       $this->middleware('permission:user-delete', ['only' => ['destroy']]);
   }

    /**
     * Display a listing of the resource
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->export)
            return $this->doExport($request);

        $users = $this->filter($request)->paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new UserExport($request), 'Users.xlsx');
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        $query = User::orderBy('id','DESC');

        if ($request->id)
            $query->where('id', $request->id);

        if ($request->name)
            $query->where('name', 'like', $request->name.'%');

        if ($request->email)
            $query->where('email', 'like', $request->email.'%');

        return $query;
    }

    /**
     * Show the form for creating a new resource
     *
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $staffRoles = Role::where('role_for', '1')->pluck('name','name')->all();
        $userRoles = Role::where('role_for', '0')->pluck('name','name')->all();
        $companies = auth()->user()->companies()->get();
        $hospitalDepartments = HospitalDepartment::where('status', '1')->get();
        foreach ($companies as $company) {
            $company->setSettings();
        }
        return view('users.create',compact('staffRoles','userRoles','companies','hospitalDepartments'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'status' => 'required',
            'role_for' => 'required',
            'photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ]);

        $logoUrl = "";
        if($request->hasFile('photo'))
        {
            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('lara/user',$logoNewName);
            $logoUrl = 'lara/user/'.$logoNewName;
        }

        $input = array();

        if($request->role_for == "1") //staff
        {
            $roles = $request->staff_roles;
            $companies = $request->staff_company;
            $input['company_id'] = $companies;
        }

        if($request->role_for == "0") //user
        {
            $roles = $request->user_roles;
            $companies = $request->user_company; //array
        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = bcrypt($request->password);
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        $input['status'] = $request->status;
        $input['photo'] = $logoUrl;
        $user = User::create($input);
        $user->assignRole($roles);
        
        // Handle Doctor role - create DoctorDetail record
        if (in_array('Doctor', (array)$roles) && !$user->doctorDetails) {
            $doctorData = [
                'user_id' => $user->id,
                'hospital_department_id' => $request->hospital_department_id ?? null,
                'specialist' => $request->specialist ?? null,
                'designation' => $request->designation ?? null,
                'biography' => $request->biography ?? null,
            ];
            DoctorDetail::create($doctorData);
            
            // Set company_id for Doctor role users
            if (isset($companies) && !empty($companies)) {
                if (is_array($companies)) {
                    $user->update(['company_id' => $companies[0]]);
                } else {
                    $user->update(['company_id' => $companies]);
                }
            }
        }
        
        if($request->role_for == "1") //staff
        {
            // Attach company
            $user->companies()->attach($companies);
        }
        if($request->role_for == "0") //user
        {
            if (isset($companies) && !empty($companies)) {
                foreach ($companies as $company) {
                    $user->companies()->attach($company);
                }
            }
        }
        return redirect()->route('users.index')->with('success', trans('users.user created successfully'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @access public
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @access public
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roleName = $user->getRoleNames();
        $roleFor = Role::findByName($roleName['0']);

        $cId = array();
        $selectedCompanies = $user->companies()->select('id')->get();
        foreach ($selectedCompanies as $companies) {
            $cId[] = $companies->id;
        }
        $cIdStd = implode(",",$cId);

        $staffRoles = Role::where('role_for', '1')->pluck('name','name')->all();
        $userRoles = Role::where('role_for', '0')->pluck('name','name')->all();
        $companies = auth()->user()->companies()->get();
        $hospitalDepartments = HospitalDepartment::where('status', '1')->get();

        foreach ($companies as $company) {
            $company->setSettings();
        }

        return view('users.edit',compact('user','roleFor','staffRoles', 'userRoles','companies','cIdStd','hospitalDepartments'));
    }


    /**
     * Remove the specified resource from storage
     *
     * @param $id
     * @access public
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::table("model_has_roles")->where('model_id',$user->id)->delete();
            DB::table("user_companies")->where('user_id',$user->id)->delete();
            DB::commit();
            return redirect()->route('users.index')->with('success', trans('users.user deleted successfully'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('error',$e);
        }
    }

    /**
     * Methot to custom update
     *
     * @access public
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|same:password_confirmation',
            'password_confirmation' => 'nullable|required_with:password',
            'status' => 'required',
            'role_for' => 'required',
            'photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ]);

        $logoUrl = "";
        if($request->hasFile('photo'))
        {
            $logo = $request->photo;
            $logoNewName = time().$logo->getClientOriginalName();
            $logo->move('lara/user',$logoNewName);
            $logoUrl = 'lara/user/'.$logoNewName;
        }

        $password = $user->password;

        if ($request->role_for == "1") {
            $roles = $request->staff_roles;
            $companies = $request->staff_company;
        }

        if($request->role_for == "0") {
            $roles = $request->user_roles;
            $companies = $request->user_company; //array
        }

        $input = array();
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        } else {
            $input['password'] = $password;
        }
        $input['phone'] = $request->phone;
        $input['address'] = $request->address;
        $input['status'] = $request->status;

        if($request->photo)
            $input['photo'] = $logoUrl;
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$user->id)->delete();

        $userSelectedCompaniesStr = $request->user_selected_companies;
        $userSelectedCompaniesArray = explode(',',$userSelectedCompaniesStr);
        foreach ($userSelectedCompaniesArray as $company) {
            DB::table('user_companies')->where('user_id',$user->id)
                                       ->where('company_id',$company)
                                       ->delete();
        }
        if($request->role_for == "1") //staff
        {
            // Attach company
            $user->companies()->attach($companies);
        }
        if($request->role_for == "0") //user
        {
            if(!empty($companies))
            {
                foreach ($companies as $company)
                {
                    $user->companies()->attach($company);
                }
            }

        }
        
        // Handle Doctor role - create or update DoctorDetail record
        $isDoctorRole = in_array('Doctor', (array)$roles);
        $hasDoctorDetail = $user->doctorDetails;
        
        if ($isDoctorRole && !$hasDoctorDetail) {
            // Create DoctorDetail record
            $doctorData = [
                'user_id' => $user->id,
                'hospital_department_id' => $request->hospital_department_id ?? null,
                'specialist' => $request->specialist ?? null,
                'designation' => $request->designation ?? null,
                'biography' => $request->biography ?? null,
            ];
            DoctorDetail::create($doctorData);
            
            // Set company_id for Doctor role users
            if (isset($companies) && !empty($companies)) {
                if (is_array($companies)) {
                    $user->update(['company_id' => $companies[0]]);
                } else {
                    $user->update(['company_id' => $companies]);
                }
            }
        } elseif ($isDoctorRole && $hasDoctorDetail) {
            // Update existing DoctorDetail record
            $doctorData = [];
            if ($request->has('hospital_department_id')) {
                $doctorData['hospital_department_id'] = $request->hospital_department_id;
            }
            if ($request->has('specialist')) {
                $doctorData['specialist'] = $request->specialist;
            }
            if ($request->has('designation')) {
                $doctorData['designation'] = $request->designation;
            }
            if ($request->has('biography')) {
                $doctorData['biography'] = $request->biography;
            }
            if (!empty($doctorData)) {
                $user->doctorDetails->update($doctorData);
            }
            
            // Ensure company_id is set for Doctor role users
            if (isset($companies) && !empty($companies)) {
                if (is_array($companies)) {
                    $user->update(['company_id' => $companies[0]]);
                } else {
                    $user->update(['company_id' => $companies]);
                }
            }
        } elseif (!$isDoctorRole && $hasDoctorDetail) {
            // Remove Doctor role - optionally delete DoctorDetail record
            // Uncomment the next line if you want to delete DoctorDetail when Doctor role is removed
            // $user->doctorDetails->delete();
        }
        
        $user->assignRole($roles);
        return redirect()->route('users.index')->with('success', trans('users.user updated successfully'));
    }
}
