<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Session;
use Auth;
use Carbon\Carbon;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Cart;

/* Facebook Events API Conversion */
use Nowyouwerkn\WeCommerce\Services\FacebookEvents;

class CartController extends Controller
{
    private $store_config;

    public function __construct()
    {
        $this->store_config = new StoreConfig;
    }

    public function addCart(Request $request, $id, $variant)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        if ($product->has_discount == false) {
            $price = $product->price;
        }else{
            $price = $product->discount_price;
        }
        $cart->add($product, $product->id, $variant, $price);

        $request->session()->put('cart', $cart);

        //Facebook Event
        if($product->has_discount == true)
            $value = $product->discount_price;
        else{
            $value = $product->price;
        }
        $product_name = $product->name;
        $product_sku = $product->sku;

        if ($this->store_config->facebook_pixel != NULL) {
            $event = new FacebookEvents;
            $event->addToCart($value, $product_name, $product_sku);
        }

        //dd( $request->session()->get('cart') );
        Session::flash('product_added', 'Producto guardado en el carrito.');

        return redirect()->back();
        //return response()->json(['mensaje' => 'Producto agregado al carrito.'],200);
    }

    public function addMore($id, $variant)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        if ($product->has_discount == false) {
            $price = $product->price;
        }else{
            $price = $product->discount_price;
        }
        $cart->addMore($id, $price, $variant);

        //Facebook Event
        if($product->has_discount == true)
            $value = $product->discount_price;
        else{
            $value = $product->price;
        }
        $product_name = $product->name;
        $product_sku = $product->sku;

        if ($this->store_config->facebook_pixel != NULL) {
            $event = new FacebookEvents;
            $event->addToCart($value, $product_name, $product_sku);
        }
        
        Session::put('cart', $cart);

        //alert()->success('Se agregó 1 a la cantidad.', '¡Listo!')->persistent('Ok, gracias');
        //return redirect()->back();

        $item_merged = ($id . ',' . $variant);
        $qty = number_format($cart->items[$item_merged]['qty']);
        $price = '$ ' . number_format($cart->items[$item_merged]['price']);
        $totalQty = number_format($cart->totalQty);
        $totalPrice = '$ ' . number_format($cart->totalPrice);

        return redirect()->back();
        //return response()->json(['mensaje' => 'Sumado 1 producto al carrito.', 'qty' => $qty, 'price' => $price , 'totalQty' => $totalQty, 'totalPrice' => $totalPrice], 200);
    }

    public function substractOne($id, $variant)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);

        if ($product->has_discount == false) {
            $price = $product->price;
        }else{
            $price = $product->discount_price;
        }

        $cart->substractOne($id, $price, $variant);

        $item_merged = ($id . ',' . $variant);
        $qty = number_format($cart->items[$item_merged]['qty']);
        $price = '$ ' . number_format($cart->items[$item_merged]['price']);
        $totalQty = number_format($cart->totalQty);
        $totalPrice = '$ ' . number_format($cart->totalPrice);

        if(count($cart->items) > 0){
            Session::put('cart', $cart);

            return redirect()->back();
            //return response()->json(['mensaje' => 'Eliminado 1 producto del carrito.', 'qty' => $qty, 'price' => $price , 'totalQty' => $totalQty, 'totalPrice' => $totalPrice], 200);
        }else{
            return redirect()->back();

            Session::forget('cart');
        }

    }

    public function deleteItem($id, $variant)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);
        $cart->deleteItem($id, $variant);

        if(count($cart->items) > 0){
            Session::put('cart', $cart);    
        }else{
            Session::forget('cart');
        }
        //return response()->json(['mensaje' => 'Producto eliminado del carrito.'],200);
        return redirect()->back();
    }
}
