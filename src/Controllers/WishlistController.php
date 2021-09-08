<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;

use Nowyouwerkn\WeCommerce\Models\Cart;
use Nowyouwerkn\WeCommerce\Models\Wishlist;
use Nowyouwerkn\WeCommerce\Models\Product;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $product = Product::all();
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();

        return view ('wecommerce::user-profile.wishlist.index')->with('wishlist', $wishlist)->with('product', $product);
    }

    public function add($id)
    {
        $product = Product::getProductById($id);

        Wishlist::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
        ]);

        Session::flash('product_added_whislist', 'Producto guardado en el wishlist.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $product = Product::getProductById($id);

        Wishlist::where([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
        ])->delete();

        Session::flash('product_removed_whislist', 'Producto quitado del wishlist.');

        return redirect()->back();
    }
}
