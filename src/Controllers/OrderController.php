<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Size;
use Nowyouwerkn\WeCommerce\Models\ProductSize;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

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

        return view('wecommerce::back.orders.index')
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

        return view('wecommerce::back.orders.show')
        ->with('order', $order)
        ->with('payment_method', $payment_method)
        ->with('shipping_method', $shipping_method);
    }

    public function changeStatus($id, Request $request)
    {
        $order = Order::find($id);

        if($request->status == 'Pagado'){
            $order->is_completed = true;
            $order->status = NULL;

            $order->save();
        }

        if($request->status == 'Pendiente'){
            $order->is_completed = NULL;
            $order->status = NULL;

            $order->save();
        }

        if($request->status == 'Cancelar Orden'){
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

        // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'cambió el estado de la orden #' . $order->id . ' a ' . $request->status;

        $this->notification->send($type, $by ,$data);

        // Mensaje de session
        Session::flash('success', 'Estado Actualizado Exitosamente.');

        return redirect()->back();
    }
}
