<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'category',
        'unit',
        'current_stock',
        'min_stock',
        'cost_per_unit',
        'description',
    ];

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function wasteLogs(): HasMany
    {
        return $this->hasMany(WasteLog::class);
    }
    public function stockLogs()
{
    return $this->hasMany(StockLog::class);
}

}
