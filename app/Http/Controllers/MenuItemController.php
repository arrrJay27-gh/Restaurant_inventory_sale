<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MenuItemController extends Controller
{
    // Ipakita ang listahan ng mga menu items sa POS admin panel
    public function index(): View
    {
        $menuItems = MenuItem::orderBy('name')->paginate(15);
        return view('menu-items.index', compact('menuItems'));
    }

    // I-save ang bagong produkto mula sa input form ng manager
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:menu_items,name',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        MenuItem::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'is_active' => true, // Automatic active agad pagka-create
        ]);

        return redirect()->back()->with('success', 'New POS Menu Item added successfully!');
    }
}
