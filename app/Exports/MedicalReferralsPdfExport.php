<?php

namespace App\Exports;

use App\Models\MedicalReferral;
use Illuminate\Http\Request;

class MedicalReferralsPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        $query = MedicalReferral::with(['patient', 'referringDoctor'])
            ->whereHas('patient', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
                if (auth()->user()->hasRole('Patient'))
                    $q->where('id', auth()->id());
            });

        if (auth()->user()->hasRole('Doctor'))
            $query->where('referring_doctor_name', auth()->id());
        elseif ($request->filled('referring_doctor_name'))
            $query->where('referring_doctor_name', $request->referring_doctor_name);

        if (auth()->user()->hasRole('Patient'))
            $query->where('patient_id', auth()->id());
        elseif ($request->filled('patient_id'))
            $query->where('patient_id', $request->patient_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('reason_for_referral')) {
            $query->where('reason_for_referral', 'like', $request->reason_for_referral.'%');
        }

        $medicalReferrals = $query->get();

        // Decode vital_signs JSON for each record
        foreach ($medicalReferrals as $referral) {
            if ($referral->vital_signs) {
                $referral->vital_signs = json_decode($referral->vital_signs, true);
            }
        }

        parent::__construct(
            ['medicalReferrals' => $medicalReferrals],
            'MedicalReferrals',
            'exports.medical-referrals-pdf'
        );
    }
}