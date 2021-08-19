<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

/* E-commerce Models */
use Config;
use Mail;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Nowyouwerkn\WeCommerce\Models\Notification;

use Nowyouwerkn\WeCommerce\Services\MailService;


use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $mail = MailConfig::take(1)->first();

        return view('wecommerce::back.notifications.index', compact('mail'));
    }

    public function all()
    {
        $notifications = Notification::paginate(50);

        return view('wecommerce::back.notifications.all', compact('notifications'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $notifications = Notification::findOrFail($id);

        $notification->read_at = Carbon::now();

        $notification->save();
        

        // Mensaje de session
        Session::flash('success', 'Notificación marcadas como leídas.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }

    public function send($type, $by, $data)
    {
        /* LOG */
        if ($by == NULL) {
            $log = new Notification([
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }else{
            $log = new Notification([
                'action_by' => $by->id,
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }
        
        $log->save();
    }

    public function mailOrder($data, $name, $email)
    {
        $config = StoreConfig::find($id);

        Mail::send('wecommerce::mail.order_completed', $data, function($message) use($name, $email) {

            $message->to($email, $name)->subject('Gracias por comprar en '. $config->store_name);
            
            $message->from($config->sender_email, $config->store_name);
        });
    }

    public function markAsRead()
    {
        $notifications = Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->get();

        foreach($notifications as $notification){
            $notification->read_at = Carbon::now();

            $notification->save();
        }

        // Mensaje de session
        Session::flash('success', 'Notificaciones marcadas como leídas.');

        return redirect()->back();
    }

    public function mailTest() {
        return view('wecommerce::mail.mail_test');
    }
    
    public function order_email() {
        $mail = MailConfig::first();

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $user = User::find($id);

        $order = Order::where('user_id', $user->id)->first();
        $order->cart = unserialize($order->cart);

        $data = array('name'=> $user->name, 'email' => $user->email, 'orden'=> $order, 'total'=> $order->cart->totalPrice, 'num_orden'=> $order->id );

        Mail::send('wecommerce::mail.order_completed', $data, function($message) {
            $message->to('hey@werkn.mx', $user->name)->subject
            ('Gracias por tu compra');
            $message->from('noreply@werkn.mx','Tienda');
        });

        echo "Correo HTML Estándar. Revisa tu bandeja de entrada.";
    }

    public function resendOrder(Request $request, $order_id) {
        $mail = MailConfig::first();

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $order = Order::find($order_id);
        $order->cart = unserialize($order->cart);

        $email = $request->email;
        $user = User::find($order->user->id);
        $name = $user->name;

        $config = StoreConfig::first();
        $theme = StoreTheme::first();

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;

        $logo = asset('themes/' . $theme->get_name() . '/img/logo.svg');

        $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

        try {
            Mail::send('wecommerce::mail.order_completed', $data, function($message) use($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject
                ('¡Gracias por comprar con nosotros!');
                
                $message->from($sender_email, $store_name);
            });
        } catch (Exception $e) {
            Session::flash('error', 'No se ha identificado servidor SMTP en la plataforma. Configuralo correctamente para enviar correos desde tu sistema.');

            return redirect()->back();
        }

        Session::flash('success', 'Correo reenviado al usuario exitosamente.');

        return redirect()->back();
    }

    public function attachment_email() {
        $data = array('name'=>"Jorge Peña");
        Mail::send('wecommerce::mail.order_completed', $data, function($message) {
            $message->to('hey@werkn.mx', '¡Gracias por tu compra!')->subject
            ('Enviado un archivo adjunto.');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('noreply@werkn.mx','Tienda');
        });
        echo "Correo enviado con un adjunto. Revisa tu bandeja de entrada.";
    }
}
