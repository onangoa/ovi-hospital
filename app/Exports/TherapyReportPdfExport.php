<?php

namespace App\Exports;

use App\Models\TherapyReport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TherapyReportPdfExport extends BasePdfExport
{
    public function __construct(TherapyReport $therapyReport)
    {
        // Load the ward relationship to avoid N+1 queries
        $therapyReport->load(['ward', 'physiotherapist']);
        
        parent::__construct(
            ['therapyReport' => $therapyReport],
            'TherapyReport_' . ($therapyReport->patient_name ?? 'Group'),
            'exports.therapy-report-pdf'
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

        // Set paper orientation to portrait for single therapy report
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}