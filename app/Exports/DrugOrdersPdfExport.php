<?php

namespace App\Exports;

use App\Models\DrugOrder;
use Illuminate\Http\Request;

class DrugOrdersPdfExport extends BasePdfExport
{
    public function __construct(Request $request)
    {
        // Get all drug orders without any filters for now
        $drugOrders = DrugOrder::with(['orderedBy'])->get();

        // Debug: Log the count of drug orders found
        \Log::info('DrugOrdersPdfExport: Found ' . $drugOrders->count() . ' drug orders');
        
        // Debug: Log the first order details if any exist
        if ($drugOrders->count() > 0) {
            \Log::info('First order details: ', $drugOrders->first()->toArray());
        }

        parent::__construct(
            ['drugOrders' => $drugOrders],
            'DrugOrders',
            'exports.drug-orders-pdf'
        );
    }
}