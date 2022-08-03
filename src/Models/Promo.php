<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promo_products', 'promo_id', 'product_id');
    }
}
