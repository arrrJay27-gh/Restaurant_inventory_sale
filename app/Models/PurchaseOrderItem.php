<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    // Forces Laravel to look for the shorthand table name
    protected $table = 'po_items';

    protected $fillable = ['po_id', 'item_id', 'quantity_ordered', 'unit_cost'];
}
