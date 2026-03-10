<?php

namespace App\Http\Controllers;

use App\Models\DrugOrder;
use App\Models\User;
use App\Exports\DrugOrderExport;
use App\Exports\DrugOrderPdfExport;
use App\Exports\DrugOrdersPdfExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DrugOrderController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:drug-orders-read|drug-orders-create|drug-orders-update|drug-orders-delete', ['only' => ['index','show']]);
         $this->middleware('permission:drug-orders-create', ['only' => ['create','store']]);
         $this->middleware('permission:drug-orders-update', ['only' => ['edit','update']]);
         $this->middleware('permission:drug-orders-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->export)
            return $this->doExport($request);
            
        if ($request->export_pdf)
            return $this->doPdfExport($request);

        $drugOrders = DrugOrder::with('orderedBy')->latest()->paginate(20);
        return view('drug-orders._index', compact('drugOrders'));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new DrugOrderExport($request), 'DrugOrders.xlsx');
    }
    
    /**
     * Performs PDF exporting
     *
     * @param Request $request
     * @return void
     */
    private function doPdfExport(Request $request)
    {
        $pdfExport = new DrugOrdersPdfExport($request);
        return $pdfExport->download();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drug-orders.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ordered_by_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.dosage' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $total_quantity = 0;
        $total_amount = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $total_quantity += $item['quantity'];
                // Fix: Total amount should be quantity * amount for each item
                $total_amount += ($item['quantity'] * $item['amount']);
            }
        }
        $data['total_quantity'] = $total_quantity;
        $data['total_amount'] = $total_amount;

        DrugOrder::create($data);

        return redirect()->route('drug-orders.index')
            ->with('success', 'Drug Order created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DrugOrder  $drugOrder
     * @return \Illuminate\Http\Response
     */
    public function show(DrugOrder $drugOrder)
    {
        if (request()->export_pdf) {
            return $this->exportDrugOrderPdf($drugOrder);
        }
        
        return view('drug-orders.show', compact('drugOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DrugOrder  $drugOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(DrugOrder $drugOrder)
    {
        $users = User::all();
        return view('drug-orders.edit', compact('drugOrder', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DrugOrder  $drugOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrugOrder $drugOrder)
    {
        $request->validate([
            'ordered_by_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.dosage' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $total_quantity = 0;
        $total_amount = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $total_quantity += $item['quantity'];
                // Total amount should be quantity * amount for each item
                $total_amount += ($item['quantity'] * $item['amount']);
            }
        }
        $data['total_quantity'] = $total_quantity;
        $data['total_amount'] = $total_amount;

        $drugOrder->update($data);

        return redirect()->route('drug-orders.index')
            ->with('success', 'Drug Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DrugOrder  $drugOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrugOrder $drugOrder)
    {
        $drugOrder->delete();

        return redirect()->route('drug-orders.index')
            ->with('success', 'Drug Order deleted successfully');
    }

    /**
     * Export individual drug order to PDF
     *
     * @param DrugOrder $drugOrder
     * @return \Illuminate\Http\Response
     */
    private function exportDrugOrderPdf(DrugOrder $drugOrder)
    {
        // Load necessary relationships for PDF export
        $drugOrder->load(['orderedBy', 'user']);
        
        $pdfExport = new DrugOrderPdfExport($drugOrder);
        return $pdfExport->download();
    }
}
