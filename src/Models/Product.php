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

    public function secondary_image()
    {
        return ProductImage::where('product_id', $this->id)->orderBy('priority', 'asc')->orderBy('created_at', 'asc')->first();
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants', 'product_id', 'variant_id')->orderBy('value', 'asc')->withPivot('stock', 'sku', 'new_price');
    }

    public function relationships()
    {
        /* Double Variant System */
        $product_relationships = ProductRelationship::where('base_product_id', $this->id)->orWhere('product_id', $this->id)->get();

        if ($product_relationships->count() == NULL) {
            $base_product = NULL;
            $relationships = NULL;
        }else{
            $base_product = $product_relationships->take(1)->first();
            $relationships = ProductRelationship::where('base_product_id', $base_product->base_product_id)->get();
        }

        return $relationships;

        //return $this->belongsToMany(Product::class, 'product_relationships', 'base_product_id', 'product_id')->orderBy('value', 'asc')->withPivot('type', 'value');
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
}
