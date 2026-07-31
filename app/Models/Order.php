<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'total_amount', 'payment_method', 'status'];

    // Relation: An order contains multiple items ordered
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}