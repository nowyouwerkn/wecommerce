<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function notes()
    {
    	return $this->hasMany(OrderNote::class, 'order_id');
    }

    public function trackings()
    {
        return $this->hasMany(OrderTracking::class, 'order_id');
    }

}
