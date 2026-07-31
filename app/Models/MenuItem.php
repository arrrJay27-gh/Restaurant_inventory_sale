<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {
    protected $fillable = ['name', 'price'];
    public function recipeItems() {
        return $this->hasMany(RecipeItem::class);
    }
}