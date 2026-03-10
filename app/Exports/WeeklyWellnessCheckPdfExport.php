<?php

namespace App\Exports;

use App\Models\WeeklyWellnessCheck;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class WeeklyWellnessCheckPdfExport extends BasePdfExport
{
    public function __construct(WeeklyWellnessCheck $weeklyWellnessCheck)
    {
        parent::__construct(
            ['weeklyWellnessCheck' => $weeklyWellnessCheck],
            'WeeklyWellnessCheck_' . $weeklyWellnessCheck->patient->name,
            'exports.weekly-wellness-check-pdf'
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
            'title' => 'Weekly Wellness Check'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single wellness check
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}