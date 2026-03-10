<?php

namespace App\Exports;

use App\Models\MedicalReferral;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MedicalReferralPdfExport extends BasePdfExport
{
    public function __construct(MedicalReferral $medicalReferral)
    {
        parent::__construct(
            ['medicalReferral' => $medicalReferral],
            'MedicalReferral_' . $medicalReferral->patient->name,
            'exports.medical-referral-pdf'
        );
    }

    /**
     * Generate and download the PDF with portrait orientation
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $data = array_merge($this->data, [
            'logoPath' => $this->logoPath,
            'title' => 'Medical Referral'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single medical referral
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}