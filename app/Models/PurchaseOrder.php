<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'po_number', 'total_amount', 'status', 'notes'];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function items() {
    return $this->hasMany(PurchaseOrderItem::class, 'po_id');
}

}
