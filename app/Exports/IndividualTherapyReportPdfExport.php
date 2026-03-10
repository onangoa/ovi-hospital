<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class IndividualTherapyReportPdfExport extends BasePdfExport
{
    public function __construct(TherapyReport $therapyReport)
    {
        // Load necessary relationships for PDF export
        $therapyReport->load(['patient', 'physiotherapist']);
        
        parent::__construct(
            ['therapyReport' => $therapyReport],
            'IndividualTherapyReport_' . ($therapyReport->patient->name ?? 'N/A'),
            'exports.individual-therapy-report-pdf'
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
            'title' => 'Individual Therapy Report'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single therapy report
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}