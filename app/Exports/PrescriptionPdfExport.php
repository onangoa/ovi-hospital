<?php

namespace App\Exports;

use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PrescriptionPdfExport extends BasePdfExport
{
    public function __construct(Prescription $prescription)
    {
        parent::__construct(
            ['prescription' => $prescription],
            'Prescription_' . $prescription->user->name,
            'exports.prescription-pdf'
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
            'title' => 'Prescription'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single prescription
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}