<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variants()
    {
        return $this->belongsTo(Nowyouwerkn\WeCommerce\Models\Variant::class, 'variant_id');
    }
}
