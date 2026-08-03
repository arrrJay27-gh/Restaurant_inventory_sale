<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService
{
    /**
     * Iproseso ang order mula sa POS checkout.
     *
     * @param array $cart
     * @return Order
     * @throws Exception
     */
    public function processOrder(array $cart)
    {
        return DB::transaction(function () use ($cart) {
            $totalAmount = 0;

            // Normalize items para sigurado ang price at quantity
            $normalizedCart = array_map(function ($item) {
                $price = $item['price'] ?? $item['unit_price'] ?? $item['amount'] ?? 0;
                $quantity = $item['quantity'] ?? $item['qty'] ?? 1;

                return [
                    'id'       => $item['id'],
                    'price'    => (float) $price,
                    'quantity' => (int) $quantity,
                ];
            }, $cart);

            // 1. Kompyutin ang Kabuuan
            foreach ($normalizedCart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // 2. Lumikha ng Order record
            $order = Order::create([
                'order_number'   => 'ORD-' . strtoupper(uniqid()),
                'total_amount'   => $totalAmount,
                'payment_method' => 'cash',
                'status'         => 'completed',
            ]);

            // 3. I-save ang OrderItem records
            foreach ($normalizedCart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $item['id'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['price'],
                    'subtotal'     => $item['price'] * $item['quantity'],
                ]);
            }

            return $order;
        });
    }
}