<?php
namespace App\Services;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService {
    public function processOrder(array $cartItems) {
        return DB::transaction(function () use ($cartItems) {
            $total = 0;
            foreach ($cartItems as $item) {
                $menuItem = MenuItem::with('recipeItems.ingredient')->findOrFail($item['id']);
                $total += $menuItem->price * $item['quantity'];
            }

            $order = Order::create([
                'total' => $total,
                'status' => 'completed'
            ]);

            foreach ($cartItems as $item) {
                $menuItem = MenuItem::with('recipeItems.ingredient')->findOrFail($item['id']);
                
                $order->items()->create([
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price
                ]);

                foreach ($menuItem->recipeItems as $recipe) {
                    $deductionAmount = $recipe->quantity_required * $item['quantity'];
                    $ingredient = $recipe->ingredient;

                    if ($ingredient->current_stock < $deductionAmount) {
                        throw new Exception("Kulang ang stock para sa sangkap: {$ingredient->name}");
                    }

                    $ingredient->update([
                        'current_stock' => $ingredient->current_stock - $deductionAmount
                    ]);
                }
            }

            return $order;
        });
    }
}