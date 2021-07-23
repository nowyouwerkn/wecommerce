<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTax extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function regions()
    {
        return $this->hasMany(self::class, 'parent_tax_id');
    }
}
