<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use App\Models\User;
use App\Models\Order;
use App\Models\Size;
use App\Models\ProductSize;

use App\Models\PaymentMethod;


use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $dt = Carbon::now()->isCurrentMonth();

        $clients = User::all();

        $orders_month = Order::where('created_at', $dt)->get();

        $orders = Order::orderBy('created_at', 'desc')->paginate(30);
        
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

        $new_orders = Order::where('created_at', '>=', Carbon::now()->subWeek())->count();

        return view('back.orders.index')
        ->with('clients', $clients)
        ->with('orders', $orders)
        ->with('new_orders', $new_orders);
    }


    public function show($id)
    {
        $order = Order::find($id);
        $order->cart = unserialize($order->cart);

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();
        $shipping_method = '0';

        return view('back.orders.show')
        ->with('order', $order)
        ->with('payment_method', $payment_method)
        ->with('shipping_method', $shipping_method);
    }

    public function changeStatus($id, Request $request)
    {
        $order = Order::find($id);

        if($request->status == 'Payed'){
            $order->is_completed = true;
            $order->status = NULL;

            $order->save();
        }

        if($request->status == 'Pending'){
            $order->is_completed = NULL;
            $order->status = NULL;

            $order->save();
        }

        if($request->status == 'Cancel Order'){
            $order->is_completed = NULL;
            $order->status = 1;

            $cart = unserialize($order->cart);

            foreach ($cart->items as $product) {
                $get_product = ProductSize::where('product_id', $product['item']['id'])->get();

                foreach($get_product as $search_size){
                    $get_size = Size::find($search_size->size_id);

                    if($get_size->size == $product['size']){
                        $actual_stock = $search_size->stock;
                        $new_stock = $actual_stock + $product['qty'];
                        $search_size->stock = $new_stock;

                        $search_size->save();
                    }
                }
            }

            $order->save();
        }

        // Mensaje de session
        Session::flash('success', 'Estado Actualizado Exitosamente.');

        return redirect()->back();
    }
}
