<?php

namespace App\Exports;

use App\Models\DrugOrder;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DrugOrderPdfExport extends BasePdfExport
{
    public function __construct(DrugOrder $drugOrder)
    {
        parent::__construct(
            ['drugOrder' => $drugOrder],
            'DrugOrder_' . $drugOrder->user->name,
            'exports.drug-order-pdf'
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

        // Set paper orientation to portrait for single drug order
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($this->filename . '.pdf');
    }
}