<?php

namespace App\Exports;

use App\Models\MedicalReferral;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class MedicalReferralExport implements FromView
{
    protected $medicalReferrals;

    public function __construct(Request $request)
    {
        $query = MedicalReferral::with(['patient', 'referringDoctor'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('referring_doctor_id', auth()->id());
        elseif ($request->filled('referring_doctor_id'))
            $query->where('referring_doctor_id', $request->referring_doctor_id);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->filled('reason_for_referral')) {
            $query->where('reason_for_referral', 'like', $request->reason_for_referral.'%');
        }

        if ($request->filled('chief_complaint')) {
            $query->where('chief_complaint', 'like', $request->chief_complaint.'%');
        }

        $this->medicalReferrals = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.medical-referrals', [
            'medicalReferrals' => $this->medicalReferrals
        ]);
    }
}