<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'subtotal',
        'tax_amount',
        'discount',
        'grand_total',
        'payment_status',
        'fulfillment_status',
        'processed_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            // Generates INV-2026-XXXXXX
            $sale->invoice_number = 'INV-' . date('Y') . '-' . strtoupper(Str::random(6));
            // Auto calculates grand total sequence
            $sale->grand_total = ($sale->subtotal + $sale->tax_amount) - $sale->discount;
        });
    }

    // Assumes you want to track line items for each sale order
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
