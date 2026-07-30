<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MenuItem;
use App\Models\Recipe;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(): View
    {
        $sales = Sale::with('user')->orderByDesc('created_at')->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function create(): View
    {
        $menuItems = MenuItem::where('is_active', true)->orderBy('name')->get();

        return view('sales.create', compact('menuItems'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|max:100',
            'order_type' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $totalAmount = collect($validated['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            $sale = Sale::create([
                'sale_number' => 'INV-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'order_type' => $validated['order_type'],
                'payment_method' => $validated['payment_method'],
                'total_amount' => $totalAmount,
                'status' => 'completed',
            ]);

            foreach ($validated['items'] as $singleItem) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'menu_item_id' => $singleItem['menu_item_id'],
                    'quantity' => $singleItem['quantity'],
                    'unit_price' => $singleItem['unit_price'],
                ]);

                $recipes = Recipe::where('menu_item_id', $singleItem['menu_item_id'])->get();

                foreach ($recipes as $recipe) {
                    Item::where('id', $recipe->item_id)->decrement('current_stock', $recipe->quantity_required * $singleItem['quantity']);
                }
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale created and inventory updated successfully.');
    }
}
