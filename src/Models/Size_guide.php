<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size_guide extends Model
{
    use HasFactory;

 	public function size_chart()
    {
    	return $this->belongsTo(Size_chart::class);
	}
}
