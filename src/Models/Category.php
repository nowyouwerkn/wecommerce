<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];
    protected $guarded = [];
    
    use HasFactory;
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsIndex()
    {
        return $this->hasMany(Product::class)->where('status', 'Publicado');
    }

    public function favoriteProduct()
    {
        return $this->hasOne(Product::class);
    }

    public function getParentCategoryName()
    {
        $parentCategory = $this->where('id', '=', $this->attributes['parent_id'])->get()->first();

        return (null != $parentCategory) ? $parentCategory->name : '';
    }

    public function subCategory()
    {
        return $this->where('parent_id', '!=', NULL)
                    ->orWhere('parent_id', '!=', 0)
                    ->get();
    }

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getAllCategories()
    {
        $data = [];

        $rootCategories = $this->where('parent_id', '=', '0')->get();
        $data = $this->list_categories($rootCategories);

        return $data;
    }

    public function list_categories($categories)
    {
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'object' => $category,
                'children' => $this->list_categories($category->children),
            ];
        }

        return $data;
    }

    public function getChilds($id)
    {
        return $this->where('parent_id', '=', $id)->get();
    }
}
