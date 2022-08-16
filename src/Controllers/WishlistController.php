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
    public function __construct()
    {
        $this->middleware('web');
    }

    public function wishlist()
    {
        $product = Product::all();
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();

        return view ('wecommerce::user-profile.wishlist.index')
        ->with('wishlist', $wishlist)
        ->with('product', $product);
    }

    public function add($id)
    {
        $product = Product::find($id);
        
        if(Auth::check()){
            $check_wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();
            
            if(empty($check_wishlist)){
                Wishlist::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
    
                Session::flash('product_added_whislist', 'Producto guardado en el wishlist.');
            }

            return redirect()->back();
        }else{
            Session::flash('info', 'Inicia sesión para guardar productos en tu Wishlist.');

            return redirect()->route('login');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        
        Wishlist::where([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
        ])->delete();

        Session::flash('product_removed_whislist', 'Producto quitado del wishlist.');

        return redirect()->back();
    }
}
