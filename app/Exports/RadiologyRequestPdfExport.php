<?php

namespace App\Exports;

use App\Models\RadiologyRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class RadiologyRequestPdfExport extends BasePdfExport
{
    public function __construct(RadiologyRequest $radiologyRequest)
    {
        parent::__construct(
            ['radiologyRequest' => $radiologyRequest],
            'RadiologyRequest_' . $radiologyRequest->patient->name,
            'exports.radiology-request-pdf'
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

        // Set paper orientation to portrait for single radiology request
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}