<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Session;
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\MailConfig;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\OrderTracking;

use Nowyouwerkn\WeCommerce\Controllers\NotificationController;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;

/*Loyalty system*/
use Nowyouwerkn\WeCommerce\Models\UserPoint;
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;

use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    private $notification;
    private $theme;

    public function __construct()
    {
        $this->notification = new NotificationController;
        $this->theme = new StoreTheme;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Guardar datos en la base de datos
        $tracking = new OrderTracking;

        $tracking->order_id = $request->order_id;
        $tracking->products_on_order = $request->products_on_order;
        $tracking->service_name = $request->service_name;
        $tracking->tracking_number = $request->tracking_number;
        $tracking->is_delivered = false;
        $tracking->status = 'En proceso';

        $tracking->save();

        $order = Order::where('id', $request->order_id)->first();
        $order->status = 'Enviado';
        $order->save();

        $user = User::where('id', $request->user_id)->first();
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $name = $user->name;
        $email = $user->email;

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;
        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');
        //$logo = asset('assets/img/logo-store.jpg');

                // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'creó una nueva guía de envío en la orden #' . $request->order_id;
        $model_action = "update";
        $model_id = $request->order_id;



        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $data = array('order_id' => $tracking->order_id, 'user_id' => $user->id, 'tracking_id'=> $tracking->id, 'logo' => $logo, 'store_name' => $store_name);

        try {
            Mail::send('wecommerce::mail.order_tracking', $data, function($message) use($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject
                ('¡Guía de seguimiento de tu compra!');

                $message->from($sender_email, $store_name);
            });
        }
        catch (Exception $e) {
            Session::flash('error', 'No se pudo enviar el correo. Revisa tus configuracion SMTP e intenta nuevamente.');

            return redirect()->back();
        }

        // Mensaje de session
        Session::flash('success', 'La guía de envío de esta orden se guardó exitosamente en la base de datos.');

        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function updateComplete(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $tracking = OrderTracking::find($id);
        $membership = MembershipConfig::where('is_active', true)->first();

        $tracking->is_delivered = true;
        $tracking->status = 'Completado';

        $tracking->save();

        $order = Order::where('id', $tracking->order_id)->first();
        $order->status = 'Entregado';

        $available = NULL;
        $used =  NULL;
        if (!empty($membership)) {
            if($order->total >= $membership->minimum_purchase){
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
                    if ($membership->has_vip_minimum_points == true && $valid >= $membership->vip_minimum_points){
                        $type = 'vip_normal';
                    }

                    if ($membership->has_vip_minimum_orders == true && $total_orders->count() >= $membership->vip_minimum_orders){
                        $type = 'vip_cool';
                    }
                }

                switch ($type) {
                    case 'vip_normal':
                        $points->value = floor(($order->total / $membership->qty_for_points) * $membership->points_vip_accounts);
                        break;

                    case 'vip_cool':
                        $points->value = floor(($order->total / $membership->qty_for_points) * $membership->points_vip_accounts);
                        break;

                    default:
                        $points->value = floor(($order->total / $membership->qty_for_points) * $membership->earned_points);
                        break;
                }


                if ($membership->has_expiration_time == true){
                    $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                }

                $points->save();
            }
        }

        $order->save();

        // Mensaje de session
        Session::flash('success', 'Tu guía de envío se actualizó correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $tracking = OrderTracking::find($id);

        $tracking->delete();

        // Mensaje de session
        Session::flash('success', 'Tu guía de envío se borro correctamente.');

        // Enviar a vista
        return redirect()->back();
    }
}
