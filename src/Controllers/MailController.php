<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

/* E-commerce Models */
use Carbon\Carbon;
use Session;
use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function update(Request $request, $id){
        $mail = MailConfig::find($id);

        $mail->update([
            'mail_driver' => 'smtp',
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption
        ]);

        // Mensaje de session
        Session::flash('success', 'Configuración de correo exitosa.');

        return redirect()->back();
    }
}
