<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(UserInvoice::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons', 'user_id', 'coupon_id');
    }

    public function hasCoupon()
    {
        $value = Coupon::where('made_for_user', $this->id)->first();

        if ($value == NULL) {
            return false;
        }

        return true;
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'made_for_user', 'id');
    }

    public function isInWishlist($productId)
    {
        $wishList = Wishlist::where('user_id', '=', $this->attributes['id'])
            ->where('product_id', '=', $productId)->get();


        if (count($wishList) <= 0) {
            return false;
        }

        return true;
    }
}
