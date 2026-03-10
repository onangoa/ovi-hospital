<?php

namespace App\Exports;

use App\Models\DrugOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class DrugOrderExport implements FromView
{
    protected $drugOrders;

    public function __construct(Request $request)
    {
        $query = DrugOrder::with(['orderedBy'])
            ->whereHas('orderedBy', function($q) use ($request) {
                $q->where('company_id', session('company_id'));
            });

        if (auth()->user()->hasRole('Doctor') || auth()->user()->hasRole('Pharmacist'))
            $query->where('ordered_by_id', auth()->id());
        elseif ($request->filled('ordered_by_id'))
            $query->where('ordered_by_id', $request->ordered_by_id);

        if ($request->date)
            $query->where('date', $request->date);

        if ($request->filled('total_amount')) {
            $query->where('total_amount', $request->total_amount);
        }

        $this->drugOrders = $query->get();
    }

    /**
     * @return Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('exports.drug-orders', [
            'drugOrders' => $this->drugOrders
        ]);
    }
}