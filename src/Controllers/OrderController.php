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

/* Stripe Helpers */
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Plan;
use Stripe\Customer;
use Stripe\Subscription;

/* Paypal Helpers */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

/*Loyalty system*/
use Nowyouwerkn\WeCommerce\Models\UserPoint;
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;
use Openpay;

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

        $orders = Order::where('type', 'single_payment')->orderBy('created_at', 'desc')->paginate(30);

        $subs = Order::where('type', 'recurring_payment')->orderBy('created_at', 'desc')->paginate(30);

        $new_orders = Order::where('created_at', '>=', Carbon::now()->subWeek())->count();

        return view('wecommerce::back.orders.index')
            ->with('clients', $clients)
            ->with('orders', $orders)
            ->with('subs', $subs)
            ->with('new_orders', $new_orders);
    }

    public function subscriptions()
    {
        $dt = Carbon::now()->isCurrentMonth();

        $clients = User::all();

        $orders_month = Order::where('created_at', $dt)->get();

        $orders = Order::where('type', 'recurring_payment')->orderBy('created_at', 'desc')->paginate(30);

        $new_orders = Order::where('created_at', '>=', Carbon::now()->subWeek())->count();

        return view('wecommerce::back.orders.subscriptions')
            ->with('clients', $clients)
            ->with('orders', $orders)
            ->with('new_orders', $new_orders);
    }

    public function show($id)
    {
        $order = Order::find($id);
        $membership = MembershipConfig::where('is_active', true)->first();

        if ($order->cart != 'N/A') {
            $order->cart = unserialize($order->cart);
        }

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();
        $shipping_method = '0';

        $shipping_option = ShipmentOption::where('id', $order->shipping_option)->first();

        return view('wecommerce::back.orders.show')
            ->with('order', $order)
            ->with('membership', $membership)
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
        $membership = MembershipConfig::where('is_active', true)->first();
        $order->status = $status_string;

        $available = NULL;
        $used =  NULL;
        if (!empty($membership)) {
            if ($status_string == 'Entregado' && $order->total >= $membership->minimum_purchase) {
                $points = new UserPoint;

                $points->user_id = $order->user_id;
                $points->order_id = $order->id;
                $points->type = 'in';

                //PUNTOS PARA VIP//
                $available_points = UserPoint::where('user_id', $order->user->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
                $used_points = UserPoint::where('user_id', $order->user->id)->where('type', 'out')->get();
                $total_orders = Order::where('user_id', $order->user->id)->get();


                foreach ($available_points as $a_point) {
                    $available += $a_point->value;
                }

                foreach ($used_points as $u_point) {
                    $used += $u_point->value;
                }

                $valid = $available - $used;

                $type = 'normal';

                if ($membership->on_vip_account == true) {
                    if ($membership->has_vip_minimum_points == true && $valid >= $membership->vip_minimum_points) {
                        $type = 'vip_normal';
                    }

                    if ($membership->has_vip_minimum_orders == true && $total_orders->count() >= $membership->vip_minimum_orders) {
                        $type = 'vip_cool';
                    }
                }

                switch ($type) {
                    case 'vip_normal':
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->points_vip_accounts;
                        break;

                    case 'vip_cool':
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->points_vip_accounts;
                        break;

                    default:
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->earned_points;
                        break;
                }


                if ($membership->has_expiration_time == true) {
                    $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                }

                $points->save();
            }
        }

        $order->save();

        if ($status_string == 'Cancelado') {
            $cart = unserialize($order->cart);

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

                    $product_variant->stock = $product_variant->stock + $product['qty'];
                    $product_variant->save();
                } else {
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                }
                if ($request->value == 'Entregado') {
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();

                    $this->notification->orderDelivered($order->id);
                }
            }
        }

        if ($order->shipment != NULL) {
            if ($order->shipment->type == 'pickup' && $status_string == 'Empaquetado') {
                $mail = MailConfig::first();
                $user = User::where('id', $order->user_id)->first();

                config(['mail.driver' => $mail->mail_driver]);
                config(['mail.host' => $mail->mail_host]);
                config(['mail.port' => $mail->mail_port]);
                config(['mail.username' => $mail->mail_username]);
                config(['mail.password' => $mail->mail_password]);
                config(['mail.encryption' => $mail->mail_encryption]);

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
                    Mail::send('wecommerce::mail.order_ready_for_pickup', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                        $message->to($email, $name)->subject('¡Tu pedido está listo para recolección!');

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

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Estado cambiado exitosamente.');

        return redirect()->back();
    }

    public function changeStatus($id, Request $request)
    {
        $order = Order::find($id);

        $membership = MembershipConfig::where('is_active', true)->first();

        $order->status = $request->value;

        $available = NULL;
        $used =  NULL;
        if (!empty($membership)) {
            if ($request->value == 'Entregado' && $order->total >= $membership->minimum_purchase) {
                $points = new UserPoint;

                $points->user_id = $order->user_id;
                $points->order_id = $order->id;
                $points->type = 'in';

                //PUNTOS PARA VIP//
                $available_points = UserPoint::where('user_id', $order->user->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
                $used_points = UserPoint::where('user_id', $order->user->id)->where('type', 'out')->get();
                $total_orders = Order::where('user_id', $order->user->id)->get();


                foreach ($available_points as $a_point) {
                    $available += $a_point->value;
                }

                foreach ($used_points as $u_point) {
                    $used += $u_point->value;
                }

                $valid = $available - $used;

                $type = 'normal';

                if ($membership->on_vip_account == true) {
                    if ($membership->has_vip_minimum_points == true && $valid >= $membership->vip_minimum_points) {
                        $type = 'vip_normal';
                    }

                    if ($membership->has_vip_minimum_orders == true && $total_orders->count() >= $membership->vip_minimum_orders) {
                        $type = 'vip_cool';
                    }
                }

                switch ($type) {
                    case 'vip_normal':
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->points_vip_accounts;
                        break;

                    case 'vip_cool':
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->points_vip_accounts;
                        break;

                    default:
                        $points->value = floor($order->total / $membership->qty_for_points) * $membership->earned_points;
                        break;
                }

                if ($membership->has_expiration_time == true) {
                    $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                }

                $points->save();
            }
        }

        $order->save();

        if ($request->value == 'Cancelado') {
            $cart = unserialize($order->cart);

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {
                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

                    $product_variant->stock = $product_variant->stock + $product['qty'];
                    $product_variant->save();
                } else {
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();
                }
                if ($request->value == 'Entregado') {

                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock + $product['qty'];
                    $product_stock->save();

                    $this->notification->orderDelivered($order->id);
                }
            }
        }

        if ($order->shipment != NULL) {
            if ($order->shipment->type == 'pickup' && $request->value == 'Empaquetado') {
                $mail = MailConfig::first();
                $user = User::where('id', $order->user_id)->first();

                config(['mail.driver' => $mail->mail_driver]);
                config(['mail.host' => $mail->mail_host]);
                config(['mail.port' => $mail->mail_port]);
                config(['mail.username' => $mail->mail_username]);
                config(['mail.password' => $mail->mail_password]);
                config(['mail.encryption' => $mail->mail_encryption]);

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
                    Mail::send('wecommerce::mail.order_ready_for_pickup', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                        $message->to($email, $name)->subject('¡Tu pedido está listo para recolección!');

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

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        return response()->json([
            'mensaje' => 'Estado cambiado exitosamente',
            'status' => $request->value
        ], 200);
    }

    public function givePoints($order)
    {
        // Funcion para dar puntos y notificar por correo al usuario
        $points = new UserPoint;

        $points->user_id = $order->user_id;
        $points->order_id = $order->id;
        $points->type = 'in';
        $points->value = ($order->total / $membership->qty_for_points) * $membership->earned_points;

        $points->save();
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

    public function filter($order, $filter)
    {

        if ($filter == 'payment_total' && $order == 'desc') {
            $orders = Order::orderByRaw('payment_total * 1 desc')->paginate(30);
        } elseif ($filter == 'payment_total' && $order == 'asc') {
            $orders = Order::orderByRaw('payment_total * 1 asc')->paginate(30);
        } else {
            $orders = Order::orderBy($filter, $order)->paginate(30);
        }

        $clients = User::all();

        return view('wecommerce::back.orders.index')
            ->with('clients', $clients)
            ->with('orders', $orders);
    }


    public function cancelSubscription($id)
    {
        $order = Order::find($id);

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();

        if ($payment_method->supplier == 'Conekta') {
            require_once(base_path() . '/vendor/conekta/conekta-php/lib/Conekta/Conekta.php');
            if ($payment_method->sandbox_mode == '1') {
                $private_key_conekta = $payment_method->sandbox_private_key;
            } else {
                $private_key_conekta = $payment_method->private_key;
            }
            \Conekta\Conekta::setApiKey($private_key_conekta);
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
        }

        if ($payment_method->supplier == 'Stripe') {
            if ($payment_method->sandbox_mode == true) {
                $private_key_stripe = $payment_method->sandbox_private_key;
            } else {
                $private_key_stripe = $payment_method->private_key;
            }
            Stripe::setApiKey($private_key_stripe);

            /* Actualizar suscripción */
            $subscription = Subscription::update(
                $order->stripe_subscription_id,
                array(
                    "cancel_at_period_end" => true,
                ),
            );

            $order->subscription_status = false;
            $order->save();
        }

        return redirect()->back();
    }

    public function refundOrder($id)
    {
        $order = Order::find($id);

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();

        if ($payment_method->supplier == 'Conekta') {
            require_once(base_path() . '/vendor/conekta/conekta-php/lib/Conekta/Conekta.php');
            if ($payment_method->sandbox_mode == '1') {
                $private_key_conekta = $payment_method->sandbox_private_key;
            } else {
                $private_key_conekta = $payment_method->private_key;
            }
            \Conekta\Conekta::setApiKey($private_key_conekta);
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
        }

        if ($payment_method->supplier == 'Stripe') {
            if ($payment_method->sandbox_mode == '1') {
                $private_key_stripe = $payment_method->sandbox_private_key;
            } else {
                $private_key_stripe = $payment_method->private_key;
            }
            Stripe::setApiKey($private_key_stripe);
        }

        if ($payment_method->supplier == 'MercadoPago') {
            if ($payment_method->sandbox_mode == '1') {
                $private_key_mercadopago = $payment_method->sandbox_private_key;
            } else {
                $private_key_mercadopago = $payment_method->private_key;
            }
            MercadoPago\SDK::setAccessToken($private_key_mercadopago);
        }

        if ($payment_method->supplier == 'OpenPay') {
            if ($payment_method->sandbox_mode == '1') {
                $private_key_openpay = $payment_method->sandbox_private_key;
                $merchant_id_openpay = $payment_method->sandbox_merchant_id;
            } else {
                $private_key_openpay = $payment_method->private_key;
                $merchant_id_openpay = $payment_method->merchant_id;
            }
        }

        switch ($order->payment_method) {

            case 'Conekta':
                try {
                    $order = \Conekta\Order::find($order->payment_id);
                    $order->refund([
                        'reason' => 'requested_by_client',
                        'ammount' => $order->payment_total,
                    ]);
                } catch (\Exception $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (\Conekta\ParameterValidationError $error) {
                    echo $error->getMessage();
                    return redirect()->back()->with('error', $error->getMessage());
                } catch (\Conekta\Handler $error) {
                    echo $error->getMessage();
                    return redirect()->back()->with('error', $error->getMessage());
                }

                break;

            case 'Stripe':
                try {

                    $stripe = new \Stripe\StripeClient(
                        $private_key_stripe
                    );

                    $stripe->refunds->create([
                        'charge' => $order->payment_id,
                    ]);
                } catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
                    return redirect()->back()->with('error', $e->getError());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    return redirect()->back()->with('error', $e->getError());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    return redirect()->back()->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    return redirect()->back()->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user
                    return redirect()->back()->with('error', $e->getError());
                }
                break;

            case 'OpenPay':

                try {
                    $openpay = Openpay::getInstance($merchant_id_openpay, $private_key_openpay);

                    $refundData = array(
                        'description' => 'devolución',
                        'amount' => $order->payment_total,
                    );

                    $customer = $openpay->customers->get('ag4nktpdzebjiye1tlze');
                    $charge = $customer->charges->get('tr6cxbcefzatd10guvvw');
                    $charge->refund($refundData);
                } catch (OpenpayApiTransactionError $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                } catch (OpenpayApiRequestError $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                } catch (OpenpayApiConnectionError $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                } catch (OpenpayApiAuthError $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                } catch (OpenpayApiError $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Hubo un error. Revisa tu información e intenta de nuevo o ponte en contacto con nosotros.');
                }

                break;

            case 'Paypal':


                dd('sisi Pay');
                break;


            case 'MercadoPago':


                dd('sisi Merc');
                break;

            default:
                // code...
                break;
        }

        $order->status = 'Reembolsado';
        $order->save();

        return redirect()->back();
    }
}
