<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    use HasFactory;


    public function sizeguide()
    {
        return $this->hasMany(Size_guide::class);
        return $this->belongsTo(Category::class);
    }

}
