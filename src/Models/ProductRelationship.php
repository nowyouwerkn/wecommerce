<?php

namespace Nowyouwerkn\WeCommerce\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRelationship extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function base_product()
    {
        return $this->belongsTo(Product::class, 'base_product_id');
    }
}
