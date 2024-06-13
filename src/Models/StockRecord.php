<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRecord extends Model
{
    protected $table = 'inventory_record';

    /* El identificador de producto es para el ID de VARIANTE */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}