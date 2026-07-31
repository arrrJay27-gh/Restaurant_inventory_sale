<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class PosController extends Controller {
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService) {
        $this->checkoutService = $checkoutService;
    }

    public function index() {
        $menuItems = MenuItem::all();
        return view('pos.index', compact('menuItems'));
    }

    public function checkout(Request $request) {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:menu_items,id',
            'cart.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            $order = $this->checkoutService->processOrder($request->cart);
            return response()->json(['success' => true, 'message' => 'Tagumpay ang transaksyon!', 'order_id' => $order->id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}