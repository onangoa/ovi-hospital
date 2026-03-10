<?php

namespace App\Exports;

use App\Models\NursingCardex;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class NursingCardexPdfExport extends BasePdfExport
{
    public function __construct(NursingCardex $nursingCardex)
    {
        parent::__construct(
            ['nursingCardex' => $nursingCardex],
            'NursingCardex_' . $nursingCardex->patient->name,
            'exports.nursing-cardex-pdf'
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
            'title' => 'Nursing Cardex'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single nursing cardex
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}