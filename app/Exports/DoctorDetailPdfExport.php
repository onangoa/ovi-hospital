<?php

namespace App\Exports;

use App\Models\DoctorDetail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DoctorDetailPdfExport extends BasePdfExport
{
    public function __construct(DoctorDetail $doctorDetail)
    {
        parent::__construct(
            ['doctorDetail' => $doctorDetail],
            'DoctorDetail_' . $doctorDetail->user->name,
            'exports.doctor-detail-pdf'
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
        
        // Set paper orientation to portrait for single doctor details
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download($this->filename . '.pdf');
    }
}