<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $orders = PurchaseOrder::with('supplier')->latest()->paginate(15);
        return view('purchase_orders.index', compact('orders'));
    }

    public function create(): View
    {
        $suppliers = Supplier::all();
        $items = Item::orderBy('name')->get();
        return view('purchase_orders.create', compact('suppliers', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'item_id' => 'required|exists:items,id',
            'quantity_ordered' => 'required|numeric|min:0.01',
            'unit_cost' => 'required|numeric|min:0',
        ]);

        // Generate automatic PO tracking invoice code
        $poNumber = 'PO-' . strtoupper(uniqid());
        $total = $request->quantity_ordered * $request->unit_cost;

        $po = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'po_number' => $poNumber,
            'total_amount' => $total,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        $po->items()->create([
            'item_id' => $request->item_id,
            'quantity_ordered' => $request->quantity_ordered,
            'unit_cost' => $request->unit_cost
        ]);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order generated cleanly.');
    }
}
