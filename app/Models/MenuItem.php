<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = ['name', 'category', 'price', 'is_active'];

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
