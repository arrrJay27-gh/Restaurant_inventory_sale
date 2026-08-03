<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    use HasFactory;

    // Define the table name explicitly if needed
    protected $table = 'stock_logs';

    // Allow mass assignment for these fields
    protected $fillable = [
        'item_id',
        'type',
        'quantity',
        'reason',
        'user_id'
    ];

    public function item(): BelongsTo
{
    return $this->belongsTo(Item::class, 'item_id');
}

public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
}
