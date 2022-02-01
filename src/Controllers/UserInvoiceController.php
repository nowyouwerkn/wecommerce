<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Str;
use Auth;
use Storage;
use Session;
use Mail;
use Image;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\UserInvoice;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/* Exportar Info */
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class UserInvoiceController extends Controller
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
        $invoice_month = UserInvoice::where('created_at', $dt)->get();
        $invoices = UserInvoice::orderBy('created_at', 'desc')->paginate(30);
        $new_invoices = UserInvoice::where('created_at', '>=', Carbon::now()->subWeek())->count();

        return view('wecommerce::back.invoices.index')
        ->with('clients', $clients)
        ->with('invoices', $invoices)
        ->with('new_invoices', $new_invoices);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'condition' => 'unique:user_rules|max:255',
        ));

        $rule = UserInvoice::create([
            'type' => $request->type,
            'value' => str_replace(',', '',$request->value),
            'is_active' => true
        ]);

        // Notificación
        $type = 'Invoice';
        $by = Auth::user();
        $data = 'Solicitó una factura para la orden: ' . $invoice->order->id;
        $model_action = "create";
        $model_id = $invoice->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        //Session message
        Session::flash('success', 'Tu solicitud de factura fue guardada exitosamente');

        return redirect()->route('coupons.index');
    }


    public function show($id)
    {
        $invoice = UserInvoice::find($id);

        return view('wecommerce::back.invoices.show')
        ->with('invoice', $invoice);
    }


    public function edit($id)
    {
        
    }

 
    public function update(Request $request, $id)
    {
        $invoice = UserInvoice::find($id);

        //$invoice->file_attachment = $request->file_attachment;
        //$invoice->pdf_file = $request->pdf_file;
        //$invoice->xml_file = $request->xml_file;

        $user = User::find($invoice->user_id);

        if ($request->hasFile('file_attachment')) {
            $archivo = $request->file('file_attachment');
            $filename = 'factura_' . Str::slug($user->name, '_') . '_' . Carbon::now()->format('d_m_y') . '_orden_' . $invoice->order_id .'.' . $archivo->getClientOriginalExtension();
            
            $location = public_path('files/invoices/');
            $archivo->move($location, $filename);

            $invoice->file_attachment = $filename;
        }

        if ($request->hasFile('pdf_file')) {
            $archivo = $request->file('pdf_file');
            $filename_pdf = 'factura_' . Str::slug($user->name, '_') . Carbon::now()->format('d_m_y') . 'order_' . $invoice->order_id .'.' . $archivo->getClientOriginalExtension();
            
            $location = public_path('files/invoices/');
            $archivo->move($location, $filename_pdf);

            $invoice->pdf_file = $filename_pdf;
        }

        if ($request->hasFile('xml_file')) {
            $archivo = $request->file('xml_file');
            $filename_xml = 'factura_' . Str::slug($user->name, '_') . Carbon::now()->format('d_m_y') . 'order_' . $invoice->order_id .'.' . $archivo->getClientOriginalExtension();
            
            $location = public_path('files/invoices/');
            $archivo->move($location, $filename_xml);

            $invoice->xml_file = $filename_xml;
        }

        $invoice->status = 'Completado';

        $invoice->save();

        // Notificación
        $type = 'Invoice';
        $by = Auth::user();
        $data = 'Se agregaron archivos para la factura con identificador interno: ' . $invoice->invoice_request_num;
        $model_action = "update";
        $model_id = $invoice->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        /* Enviar Correo */
        $mail = MailConfig::first();

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $order = Order::find($invoice->order_id);
        $user = User::find($invoice->user_id);

        $email = $user->email;
        $name = $user->name;

        $config = StoreConfig::first();
        $theme = StoreTheme::first();

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;

        $logo = asset('themes/' . $theme->get_name() . '/img/logo.svg');

        $data = array('order_id' => $order->id, 'user_id' => $user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

        try {
            Mail::send('wecommerce::mail.order_invoice', $data, function($message) use($name, $email, $sender_email, $store_name, $invoice, $theme) {
                $message->to($email, $name)->subject
                ('¡Tu factura de tu compra en línea!');
                
                if ($invoice->file_attachment != NULL) {
                    $message->attach(asset('files/invoices/' . $invoice->file_attachment ));
                }

                if ($invoice->pdf_file != NULL) {
                    $message->attach(asset('files/invoices/' . $invoice->pdf_file ));
                }

                if ($invoice->xml_file != NULL) {
                    $message->attach(asset('files/invoices/' . $invoice->xml_file ));
                }
                
                $message->from($sender_email, $store_name);
            });
        } catch (Exception $e) {
            Session::flash('error', 'No se ha identificado servidor SMTP en la plataforma. Configuralo correctamente para enviar correos desde tu sistema.');

            return redirect()->back();
        }

        //Session message
        Session::flash('success', 'Se guardaron los archivos de forma exitosa. Se envió automáticamente el correo con los archivos a tu cliente y el estado de la factura pasó a completado.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        
    }

    public function changeStatus($id)
    {
        // Encontrar el valor de la regla que se quiere cambiar
        $rule = UserInvoice::find($id);

        // si la regla esta activa
        if ($rule->is_active == true) {
            // Desactivar cualquier otro método activo
            $deactivate = UserInvoice::where('is_active', false)->get();
            $rule->is_active = false;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
              
                }
            }
        }else{
            // Desactivar cualquier otro método activo
            $deactivate = UserInvoice::where('is_active', true)->get();
            $rule->is_active = true;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
                    $dt->is_active = false;
                    $dt->save();
                }
            }
        }
        $rule->save();

        //Session message
        Session::flash('success', 'El elemento fue actualizado exitosamente.');

        return redirect()->back();
    }

    public function filter($invoice , $filter)
    {

        if ($filter == 'payment_total' && $invoice == 'desc') {
            $invoices = UserInvoice::orderByRaw('payment_total * 1 desc')->paginate(30);
        }elseif($filter == 'payment_total'&& $invoice == 'asc'){
            $invoices = UserInvoice::orderByRaw('payment_total * 1 asc')->paginate(30);
        }
        else{
            $invoices = UserInvoice::orderBy($filter, $invoice)->paginate(30);
        }
        
        $clients = User::all();

         return view('wecommerce::back.invoices.index')
        ->with('clients', $clients)
        ->with('invoices', $invoices);

    }
}
