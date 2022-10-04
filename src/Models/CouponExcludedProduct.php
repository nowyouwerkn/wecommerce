<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponExcludedProduct extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_excluded_products', 'product_id', 'coupon_id');
    }
}
