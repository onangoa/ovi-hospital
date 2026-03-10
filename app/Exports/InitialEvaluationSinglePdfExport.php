<?php

namespace App\Exports;

use App\Models\InitialEvaluation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class InitialEvaluationSinglePdfExport extends BasePdfExport
{
    public function __construct(InitialEvaluation $initialEvaluation)
    {
        // Load the patient and provider relationships
        $initialEvaluation->load(['patient', 'provider']);
        
        // Decode vital_signs JSON if it exists
        if ($initialEvaluation->vital_signs) {
            $initialEvaluation->vital_signs = json_decode($initialEvaluation->vital_signs, true);
        }
        
        parent::__construct(
            ['initialEvaluation' => $initialEvaluation],
            'InitialEvaluation-' . $initialEvaluation->id,
            'exports.initial-evaluation-single-pdf',
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
            'title' => 'Initial Evaluation'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single evaluation
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}