<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons', 'user_id', 'coupon_id');
    }

    public function coupons()
    {
        return $this->hasMany(UserCoupon::class, 'coupon_id', 'id');
    }

    public function madeForUser()
    {
        return $this->hasOne(User::class, 'made_for_user');
    }

    public function excludedCategories()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_excluded_categories', 'category_id', 'coupon_id');
    }

    public function excludedProducts()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_excluded_products', 'coupon_id', 'product_id');
    }
}
