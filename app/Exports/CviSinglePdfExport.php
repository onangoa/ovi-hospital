<?php

namespace App\Exports;

use App\Models\ChildVitalityIndexScore;

class CviSinglePdfExport extends BasePdfExport
{
    public function __construct(ChildVitalityIndexScore $cvi)
    {
        // Load the patient relationship
        $cvi->load('patient');
        
        parent::__construct(
            ['cvi' => $cvi],
            'CVI-' . $cvi->id,
            'exports.cvi-single-pdf',
            'portrait'
        );
    }
}