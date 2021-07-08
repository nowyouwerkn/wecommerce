<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $primaryKey = 'id';
    
    protected $fillable = ['user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
