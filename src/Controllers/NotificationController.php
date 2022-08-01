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
use Nowyouwerkn\WeCommerce\Models\MailTheme;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Nowyouwerkn\WeCommerce\Models\Notification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $theme;

    public function __construct()
    {
        $this->theme = new StoreTheme;
    }

    public function index()
    {
        $mail = MailConfig::take(1)->first();
        $template = MailTheme::take(1)->first();

        return view('wecommerce::back.notifications.index')->with('mail', $mail)->with('template', $template);
    }

    public function all()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(50);

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

    public function send($type, $by, $data, $model_action, $model_id)
    {
        /* LOG */
        if ($by == NULL) {
            $log = new Notification([
                'type' => $type,
                'data' => $data,
                'model_action' => $model_action,
                'model_id' => $model_id,
                'is_hidden' => false
            ]);
        }else{
            $log = new Notification([
                'action_by' => $by->id,
                'type' => $type,
                'data' => $data,
                'model_action' => $model_action,
                'model_id' => $model_id,
                'is_hidden' => false
            ]);
        }
        
        $log->save();
    }

    public function mailOrder($name, $email)
    {
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;

        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');
        //$logo = asset('assets/img/logo-store.jpg');

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $data = array('user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name);

        Mail::send('wecommerce::mail.order_completed', $data, function($message) use($name, $email) {

            $message->to($email, $name)->subject('Gracias por comprar en '. $config->store_name);
            
            $message->from($config->sender_email, $config->store_name);
        });
    }

    public function registerUser($name, $email)
    {
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;

        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');
        //$logo = asset('assets/img/logo-store.jpg');

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $data = array('name' => $name, 'logo' => $logo, 'store_name' => $store_name);

        Mail::send('wecommerce::mail.new_user', $data, function($message) use($name, $email, $sender_email, $store_name) {
            $message->to($email, $name)->subject('Gracias por registrarte en '. $store_name);
            $message->from($sender_email, $store_name);
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

     public function orderDelivered($order_id) {
        $mail = MailConfig::first();

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $order = Order::find($order_id);
        $order->cart = unserialize($order->cart);

        
        $user = User::find($order->user->id);
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
            Mail::send('wecommerce::mail.order_delivered', $data, function($message) use($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject
                ('¡Gracias por comprar con nosotros!');
                
                $message->from($sender_email, $store_name);
            });
        } catch (Exception $e) {
            Session::flash('error', 'No se ha identificado servidor SMTP en la plataforma. Configuralo correctamente para enviar correos desde tu sistema.');

            return redirect()->back();
        }

        Session::flash('success', 'Correo enviado al usuario exitosamente.');

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
