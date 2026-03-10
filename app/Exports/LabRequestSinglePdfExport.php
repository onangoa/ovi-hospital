<?php

namespace App\Exports;

use App\Models\LabRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LabRequestSinglePdfExport extends BasePdfExport
{
    public function __construct(LabRequest $labRequest)
    {
        // Load the patient and clinician relationships
        $labRequest->load(['patient', 'clinician']);
        
        // Decode vital_signs JSON if it exists
        if ($labRequest->vital_signs) {
            $labRequest->vital_signs = json_decode($labRequest->vital_signs, true);
        }
        
        parent::__construct(
            ['labRequest' => $labRequest],
            'LabRequest-' . $labRequest->id,
            'exports.lab-request-single-pdf',
            'portrait'
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
            'title' => 'Laboratory Request Form'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single lab request
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}