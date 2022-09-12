<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

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

        $tracking->is_delivered = true;
        $tracking->status = 'Completado';
 
        $tracking->save();

        $order = Order::where('id', $tracking->order_id)->first();
        $order->status = 'Entregado';
        $order->save();

        // Mensaje de session
        Session::flash('success', 'Tu guía de envío se actualizó correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
