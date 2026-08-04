<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\WasteLog;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WasteLogController extends Controller
{
    public function create()
    {
        $menuItems = MenuItem::all();
        return view('waste-logs.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;

            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['unit_price'];
            }

            $wasteLog = WasteLog::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
            ]);

            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                
                $wasteLog->items()->create([
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('waste-logs.create')->with('success', 'Waste log recorded successfully.');
    }
}