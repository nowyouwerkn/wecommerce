<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Nowyouwerkn\WeCommerce\Models\Query;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Variant;

use Nowyouwerkn\WeCommerce\Models\StoreTheme;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $theme;

    public function __construct()
    {
        $this->theme = new StoreTheme;
    }

    public function query(Request $request)
    {   
        $search_query = $request->input('query');

        $products = Product::with('category')->where('status', 'Publicado')
        ->where('category_id', '!=', NULL)
        ->where('name', 'LIKE', "%{$search_query}%")
        ->orWhere('description', 'LIKE', "%{$search_query}%")
        ->where('status', 'Publicado')
        ->orWhere('search_tags', 'LIKE', "%{$search_query}%")
        ->where('status', 'Publicado')
        ->orWhereHas('category', function ($query) use ($search_query) {
            $query->where(strtolower('name'), 'LIKE', '%' . strtolower($search_query) . '%');
        })->paginate(30);

        $popular_products = Product::with('category')->where('is_favorite', true)->get();
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        return view('front.theme.' . $this->theme->get_name() . '.search.general_query')
        ->with('products', $products)
        ->with('popular_products', $popular_products)
        ->with('categories', $categories)
        ->with('variants', $variants);
    }

    public function search(Request $request)
    {
        $results = Product::with('category')
        ->where('status', 'Publicado')
        ->where('category_id', '!=', NULL)
        ->where('name', 'LIKE', "%{$request->search}%")
        ->orWhere('search_tags', 'LIKE', "%{$request->search}%")
        ->where('status', 'Publicado')->get()->take(6);

        $query = new Query;
        $query->query = $request->search;
        $query->save();  

        return view('front.theme.' . $this->theme->get_name() . '.search.query', compact('results'))
        ->with(['search' => $request->search])->render();
    }
}
