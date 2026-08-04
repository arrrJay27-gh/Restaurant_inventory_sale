<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteLog extends Model
{
    protected $fillable = ['total_amount', 'user_id'];

    public function items(): HasMany
    {
        return $this->hasMany(WasteLogItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}