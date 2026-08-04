<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteLogItem extends Model
{
    protected $fillable = ['waste_log_id', 'menu_item_id', 'quantity', 'unit_price', 'subtotal'];

    public function menu_item(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}