<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\WasteLog;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WasteLogController extends Controller
{
    public function create(): View
    {
        $items = Item::orderBy('name')->get();

        return view('waste_logs.create', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|min:0.001',
            'reason' => 'required|string|max:500',
        ]);

        WasteLog::create([
            'item_id' => $validated['item_id'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'logged_by' => Auth::id(),
        ]);

        $item = Item::find($validated['item_id']);
        if ($item) {
            $item->decrement('current_stock', $validated['quantity']);
        }

        return redirect()->route('dashboard')->with('success', 'Waste logged and inventory updated successfully.');
    }
}
