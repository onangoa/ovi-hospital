<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

abstract class BasePdfExport
{
    /**
     * The data to be exported
     */
    protected $data;

    /**
     * The filename for the export
     */
    protected $filename;

    /**
     * The view to be rendered
     */
    protected $view;

    /**
     * The logo path
     */
    protected $logoPath;

    /**
     * The paper orientation
     */
    protected $orientation = 'landscape';

    /**
     * Create a new export instance.
     *
     * @param mixed $data
     * @param string $filename
     * @param string $view
     * @param string $orientation
     */
    public function __construct($data, $filename, $view, $orientation = 'landscape')
    {
        $this->data = $data;
        $this->filename = $filename;
        $this->view = $view;
        $this->orientation = $orientation;
        $logoPath = public_path('assets/images/ovi_logo_gradient_ch_black.png');
        $this->logoPath = file_exists($logoPath) ? $logoPath : null;
    }

    /**
     * Generate and download the PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $data = array_merge($this->data, ['logoPath' => $this->logoPath]);
        $pdf = PDF::loadView($this->view, $data);
        
        // Set paper orientation based on the orientation property
        $pdf->setPaper('a4', $this->orientation);
        
        return $pdf->download($this->filename . '.pdf');
    }

    /**
     * Format date without timestamp
     *
     * @param mixed $date
     * @return string
     */
    protected function formatDate($date)
    {
        if (!$date) {
            return '';
        }
        
        if (is_string($date)) {
            return \Carbon\Carbon::parse($date)->format('d M, Y');
        }
        
        return $date->format('d M, Y');
    }
}