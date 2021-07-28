<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //massive
    protected $guarded = [];
    
    //relation
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants', 'product_id', 'variant_id')->withPivot('stock', 'sku', 'new_price');
    }

    public function variants_stock()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function approved_reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->where('is_approved', true);
    }

    public function subCategory()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    //filter
    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('name', 'LIKE', "%$name%");
    }

    public function scopeStatus($query, $status)
    {
        if($status)
            return $query->where('status', $status);
    }

    public static function getProductById($id)
    {
        $model = new static;
        return $model->where('id', '=', $id)->first();
    }
}
