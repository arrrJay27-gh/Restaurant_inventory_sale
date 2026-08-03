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

    // Establish link relationship back to the parent item
    public function item(): BelongsTo
    {
        return $table->belongsTo(Item::class, 'item_id');
    }

    // Establish link relationship back to the user who processed it
    public function user(): BelongsTo
    {
        return $table->belongsTo(User::class, 'user_id');
    }
}
