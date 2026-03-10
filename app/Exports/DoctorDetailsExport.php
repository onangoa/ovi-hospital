<?php

namespace App\Exports;

use App\Models\DoctorDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class DoctorDetailsExport implements FromView
{
    protected $doctorDetails;

    public function __construct(Request $request)
    {
        $query = DoctorDetail::with(['user', 'hospitalDepartment'])
            ->whereHas('user', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Doctor'))
                    $q->where('id', auth()->id());
            });

        if ($request->filled('doctor_id')) {
            $query->where('user_id', $request->doctor_id);
        }

        if ($request->filled('specialist')) {
            $query->where('specialist', 'like', $request->specialist.'%');
        }

        if ($request->filled('designation')) {
            $query->where('designation', 'like', $request->designation.'%');
        }

        if ($request->filled('department_id')) {
            $query->where('hospital_department_id', $request->department_id);
        }

        if ($request->name) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', $request->name.'%');
            });
        }

        if ($request->email) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('email', 'like', $request->email.'%');
            });
        }

        $this->doctorDetails = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.doctor-details', [
            'doctorDetails' => $this->doctorDetails
        ]);
    }
}