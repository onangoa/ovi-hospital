<?php

namespace App\Exports;

use App\Models\VitalSign;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VitalSignPdfExport extends BasePdfExport
{
    public function __construct(VitalSign $vitalSign)
    {
        parent::__construct(
            ['vitalSign' => $vitalSign],
            'VitalSign_' . $vitalSign->display_name,
            'exports.vital-sign-pdf'
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
            'title' => 'Vital Sign Details'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single vital sign
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}