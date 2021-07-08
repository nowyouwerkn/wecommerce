<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function taxes()
    {
        return $this->belongsTo(\App\Models\StoreTax::class, 'store_taxes', 'country_id');
    }
}
