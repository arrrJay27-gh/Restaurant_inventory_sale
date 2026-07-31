<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model {
    protected $fillable = ['menu_item_id', 'ingredient_id', 'quantity_required'];
    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }
}
