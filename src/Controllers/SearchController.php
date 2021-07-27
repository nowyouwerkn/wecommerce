<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use DB;

use Nowyouwerkn\WeCommerce\Models\Product;
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

        $products = Product::where('name', 'LIKE', "%{$search_query}%")
        ->where('category_id', '!=', NULL)
        ->orWhere('description', 'LIKE', "%{$search_query}%")
        ->orWhere('search_tags', 'LIKE', "%{$search_query}%")
        ->orWhereHas('category', function ($query) use ($search_query) {
            $query->where(strtolower('name'), 'LIKE', '%' . strtolower($search_query) . '%');
        })->paginate(30);

        return view('front.theme.' . $this->theme->get_name() . '.search.general_query')->with('products', $products);
    }
}
