<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::orderBy('name')->paginate(20);

        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        return view('items.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. I-map ang 'quantity' papunta sa 'current_stock' kung galing ito sa simpleng form
        if ($request->has('quantity') && !$request->has('current_stock')) {
            $request->merge(['current_stock' => $request->input('quantity')]);
        }

        // 2. Auto-generate ng SKU kung walang in-input
        if (!$request->filled('sku')) {
            $request->merge(['sku' => 'ING-' . strtoupper(Str::random(6))]);
        }

        // 3. Validation Rules
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|max:100|unique:items,sku',
            'category'      => 'nullable|string|max:100',
            'unit'          => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'min_stock'     => 'nullable|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'description'   => 'nullable|string|max:1000',
        ]);

        // Default values para sa optional numeric fields
        $validated['min_stock'] = $validated['min_stock'] ?? 5;
        $validated['cost_per_unit'] = $validated['cost_per_unit'] ?? 0;

        // 4. I-save sa database
        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Inventory item added successfully.');
    }
}