<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock_qty', 'unit', 'low_stock_threshold'];

    // Relation: An ingredient belongs to many MenuItems through the recipe pivot
    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'recipe_items')
                    ->withPivot('quantity_required')
                    ->withTimestamps();
    }

    // Relation: Track stock history for this ingredient
    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLog::class);
    }
}