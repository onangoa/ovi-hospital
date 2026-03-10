<?php

namespace App\Exports;

use App\Models\WardRoundNote;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class WardRoundNotePdfExport extends BasePdfExport
{
    public function __construct(WardRoundNote $wardRoundNote)
    {
        parent::__construct(
            ['wardRoundNote' => $wardRoundNote],
            'WardRoundNote_' . $wardRoundNote->patient->name,
            'exports.ward-round-note-pdf',
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
            'title' => 'Ward Round Note'
        ]);
        $pdf = PDF::loadView($this->view, $data);

        // Set paper orientation to portrait for single ward round note
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}