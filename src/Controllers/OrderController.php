<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Config;
use Mail;
use Auth;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentOption;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Nowyouwerkn\WeCommerce\Models\MailTheme;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;

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
        
        /*
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        */

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

        $shipping_option = ShipmentOption::where('id', $order->shipping_option)->first();

        return view('wecommerce::back.orders.show')
        ->with('order', $order)
        ->with('payment_method', $payment_method)
        ->with('shipping_method', $shipping_method)
        ->with('shipping_option', $shipping_option);
    }

    public function packingList($id) 
    {
        $order = Order::find($id);
        $order->cart = unserialize($order->cart);

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();
        $shipping_method = '0';

        return view('wecommerce::back.orders.packing_list')
        ->with('order', $order)
        ->with('payment_method', $payment_method)
        ->with('shipping_method', $shipping_method);
    }

    public function changeStatusStatic($id, $status_string)
    {
        $order = Order::find($id);

        $order->status = $status_string;
        $order->save();

        if($status_string == 'Cancelado'){
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
                if($request->value == 'Entregado'){
                     $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                      $this->notification->orderDelivered($order->id);
                }
                
            }
        }

        if($order->shipment != NULL){
            if($order->shipment->type == 'pickup' && $status_string == 'Empaquetado'){
                $mail = MailConfig::first();
                $user = User::where('id', $order->user_id)->first();

                config(['mail.driver'=> $mail->mail_driver]);
                config(['mail.host'=>$mail->mail_host]);
                config(['mail.port'=>$mail->mail_port]);   
                config(['mail.username'=>$mail->mail_username]);
                config(['mail.password'=>$mail->mail_password]);
                config(['mail.encryption'=>$mail->mail_encryption]);

                $order->cart = unserialize($order->cart);

                $email = $user->email;
                $name = $user->name;

                $config = StoreConfig::first();
                $theme = StoreTheme::first();

                $sender_email = $config->sender_email;
                $store_name = $config->store_name;
                $contact_email = $config->contact_email;

                $logo = asset('themes/' . $theme->get_name() . '/img/logo.svg');

                $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

                try {
                    Mail::send('wecommerce::mail.order_ready_for_pickup', $data, function($message) use($name, $email, $sender_email, $store_name) {
                        $message->to($email, $name)->subject
                        ('¡Tu pedido está listo para recolección!');
                        
                        $message->from($sender_email, $store_name);
                    });
                } catch (Exception $e) {
                    Session::flash('error', 'No se ha identificado servidor SMTP en la plataforma. Configuralo correctamente para enviar correos desde tu sistema.');

                    return redirect()->back();
                }
            }
        }
        // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'cambió el estado de la orden #0' . $order->id . ' a ' . $status_string;
        $model_action = "update";
        $model_id = $order->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        Session::flash('success', 'Estado cambiado exitosamente.');

        return redirect()->back();
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
                if($request->value == 'Entregado'){
                     $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                      $this->notification->orderDelivered($order->id);
                }
                
            }
        }

        if($order->shipment != NULL){
            if($order->shipment->type == 'pickup' && $request->value == 'Empaquetado'){
                $mail = MailConfig::first();
                $user = User::where('id', $order->user_id)->first();

                config(['mail.driver'=> $mail->mail_driver]);
                config(['mail.host'=>$mail->mail_host]);
                config(['mail.port'=>$mail->mail_port]);   
                config(['mail.username'=>$mail->mail_username]);
                config(['mail.password'=>$mail->mail_password]);
                config(['mail.encryption'=>$mail->mail_encryption]);

                $order->cart = unserialize($order->cart);

                $email = $user->email;
                $name = $user->name;

                $config = StoreConfig::first();
                $theme = StoreTheme::first();

                $sender_email = $config->sender_email;
                $store_name = $config->store_name;
                $contact_email = $config->contact_email;

                $logo = asset('themes/' . $theme->get_name() . '/img/logo.svg');

                $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

                try {
                    Mail::send('wecommerce::mail.order_ready_for_pickup', $data, function($message) use($name, $email, $sender_email, $store_name) {
                        $message->to($email, $name)->subject
                        ('¡Tu pedido está listo para recolección!');
                        
                        $message->from($sender_email, $store_name);
                    });
                } catch (Exception $e) {
                    Session::flash('error', 'No se ha identificado servidor SMTP en la plataforma. Configuralo correctamente para enviar correos desde tu sistema.');

                    return redirect()->back();
                }
            }
        }

        // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'cambió el estado de la orden #0' . $order->id . ' a ' . $request->value;
        $model_action = "update";
        $model_id = $order->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        return response()->json([
            'mensaje' => 'Estado cambiado exitosamente', 
            'status' => $request->value
        ], 200);

    }

    public function export() 
    {
        return Excel::download(new OrderExport, 'ordenes.xlsx');
    }

    public function query(Request $request)
    {
        $search_query = $request->input('query');
        
        $orders = Order::where('client_name', 'LIKE', "%{$search_query}%")
        ->orWhere('id', 'LIKE', "%{$search_query}%")
        ->orWhere('payment_id', 'LIKE', "%{$search_query}%")
        ->paginate(30);
    
        $clients = User::all();

         return view('wecommerce::back.orders.index')
        ->with('clients', $clients)
        ->with('orders', $orders);
    }

    public function filter($order , $filter)
    {

        if ($filter == 'payment_total' && $order == 'desc') {
            $orders = Order::orderByRaw('payment_total * 1 desc')->paginate(30);
        }elseif($filter == 'payment_total'&& $order == 'asc'){
            $orders = Order::orderByRaw('payment_total * 1 asc')->paginate(30);
        }
        else{
            $orders = Order::orderBy($filter, $order)->paginate(30);
        }
        
        $clients = User::all();

         return view('wecommerce::back.orders.index')
        ->with('clients', $clients)
        ->with('orders', $orders);

    }
}
