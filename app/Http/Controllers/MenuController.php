<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Pahina kung saan makikita ang listahan ng Menu Items / Products
    public function index()
    {
        // Palitan ang 'Item' depende sa Model name ng mga paninda mo
        // Pwedeng mag-filter kung may 'type' o 'category' field ka
        return view('menu.index'); 
    }

    // Form para mag-add ng bagong Menu / Product (Admin Only)
    public function create()
    {
        return view('menu.create');
    }

    // Save action para sa bagong Product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Logic sa pag-save ng bagong menu item sa database...

        return redirect()->route('menu.index')->with('success', 'New menu product added successfully!');
    }
}