<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'price', 'is_active'];

    // Relation: A dish consists of multiple ingredients (Recipe)
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_items')
                    ->withPivot('quantity_required')
                    ->withTimestamps();
    }
}