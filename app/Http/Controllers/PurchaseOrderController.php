<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->orderByDesc('created_at')->paginate(20);

        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create(): View
    {
        $suppliers = Supplier::orderBy('name')->get();
        $items = Item::orderBy('name')->get();

        return view('purchase_orders.create', compact('suppliers', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|string|in:draft,ordered,received',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity_ordered' => 'required|numeric|min:0.001',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $totalAmount = collect($validated['items'])->sum(function ($item) {
            return $item['quantity_ordered'] * $item['unit_cost'];
        });

        $purchaseOrder = PurchaseOrder::create([
            'po_number' => 'PO-' . strtoupper(bin2hex(random_bytes(4))),
            'supplier_id' => $validated['supplier_id'],
            'status' => $validated['status'],
            'total_amount' => $totalAmount,
        ]);

        foreach ($validated['items'] as $orderItem) {
            PurchaseOrderItem::create([
                'po_id' => $purchaseOrder->id,
                'item_id' => $orderItem['item_id'],
                'quantity_ordered' => $orderItem['quantity_ordered'],
                'unit_cost' => $orderItem['unit_cost'],
            ]);

            if ($validated['status'] === 'received') {
                $item = Item::find($orderItem['item_id']);
                if ($item) {
                    $item->increment('current_stock', $orderItem['quantity_ordered']);
                }
            }
        }

        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order created successfully.');
    }
}
