<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/* Exportar Info */
use Maatwebsite\Excel\Facades\Excel;
use Nowyouwerkn\WeCommerce\Exports\OrderExport;

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

        $order->status = $request->value;
        $order->save();

        if($request->value == 'Cancelado'){
            $cart = unserialize($order->cart);

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
                    
                    $product_variant->stock = $product_variant->stock + $product['qty'];
                    $product_variant->save();
                }else{
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                }
                
            }
        }

        // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'cambió el estado de la orden #0' . $order->id . ' a ' . $request->value;

        $this->notification->send($type, $by ,$data);

        return response()->json([
            'mensaje' => 'Estado cambiado exitosamente', 
            'status' => $request->value
        ], 200);

        /*
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

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
                    
                    $product_variant->stock = $product_variant->stock + $product['qty'];
                    $product_variant->save();
                }else{
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                }
                
            }

            $order->save();
        }

        // Mensaje de session
        Session::flash('success', 'Estado Actualizado Exitosamente.');

        return redirect()->back();
        */
    }

    public function export() 
    {
        return Excel::download(new OrderExport, 'ordenes.xlsx');
    }
}
