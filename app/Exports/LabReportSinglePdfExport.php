<?php

namespace App\Exports;

use App\Models\LabReport;
use App\Models\Company;

class LabReportSinglePdfExport extends BasePdfExport
{
    public function __construct(LabReport $labReport)
    {
        $company = Company::find($labReport->company_id);
        $company->setSettings();
        
        parent::__construct(
            [
                'labReport' => $labReport,
                'company' => $company,
                'title' => 'Lab Report - ' . $labReport->user->name
            ],
            'LabReport_' . $labReport->id,
            'exports.lab-report-single-pdf',
            'portrait'
        );
    }
}