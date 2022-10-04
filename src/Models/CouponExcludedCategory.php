<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponExcludedCategory extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_excluded_categories', 'category_id', 'coupon_id');
    }
}
