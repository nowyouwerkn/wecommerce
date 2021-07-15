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
}
