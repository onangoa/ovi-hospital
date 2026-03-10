<?php

namespace App\Exports;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PatientDetailPdfExport extends BasePdfExport
{
    public function __construct(User $patientDetail)
    {
        parent::__construct(
            ['patientDetail' => $patientDetail],
            'PatientDetail_' . $patientDetail->name,
            'exports.patient-detail-pdf'
        );
    }

    /**
     * Generate and download the PDF with portrait orientation
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $data = array_merge($this->data, ['logoPath' => $this->logoPath]);
        $pdf = PDF::loadView($this->view, $data);
        
        // Set paper orientation to portrait for single patient details
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download($this->filename . '.pdf');
    }
}