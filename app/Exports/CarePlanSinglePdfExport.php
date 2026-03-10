<?php

namespace App\Exports;

use App\Models\CarePlan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CarePlanSinglePdfExport extends BasePdfExport
{
    public function __construct(CarePlan $carePlan)
    {
        // Load the patient and provider relationships
        $carePlan->load(['patient', 'provider']);
        
        parent::__construct(
            ['carePlan' => $carePlan],
            'CarePlan-' . $carePlan->id,
            'exports.care-plan-single-pdf',
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
            'title' => 'Care Plan'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single care plan
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}