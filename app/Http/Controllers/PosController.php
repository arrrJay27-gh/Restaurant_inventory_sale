<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PosController extends Controller 
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService) 
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * I-display ang POS main view kasama ang listahan ng menu items.
     */
    public function index() 
    {
        // Kukunin ang lahat ng menu items sa database
        $menuItems = MenuItem::all();
        
        return view('pos.index', compact('menuItems'));
    }

    /**
     * Iproseso ang checkout transaksyon mula sa POS interface.
     */
    public function checkout(Request $request) 
    {
        // 1. I-validate ang mga datos galing sa frontend cart
        $validated = $request->validate([
            'cart'             => 'required|array|min:1',
            'cart.*.id'        => 'required|exists:menu_items,id',
            'cart.*.quantity'  => 'required|integer|min:1',
            'payment_method'   => 'nullable|string',
            'paid_amount'      => 'nullable|numeric'
        ]);

        try {
            // 2. Iproseso ang order gamit ang CheckoutService
            $order = $this->checkoutService->processOrder($validated['cart']);

            return response()->json([
                'success'  => true,
                'message'  => 'Tagumpay ang transaksyon!',
                'order_id' => $order->id,
                'order'    => $order
            ], 200);

        } catch (\Exception $e) {
            // I-log ang error sa storage/logs/laravel.log para madaling i-debug
            Log::error('POS Checkout Error: ' . $e->getMessage(), [
                'exception' => $e,
                'cart_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Nagkaroon ng problema sa pagproseso: ' . $e->getMessage()
            ], 422);
        }
    }
}