<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('Nowyouwerkn\WeCommerce\Models\User');
    }
    
    public function notes()
    {
    	return $this->hasMany('Nowyouwerkn\WeCommerce\Models\OrderNote', 'order_id');
    }

}
