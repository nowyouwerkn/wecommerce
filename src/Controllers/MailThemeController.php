<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Nowyouwerkn\WeCommerce\Models\MailTheme;
use Illuminate\Http\Request;

class MailThemeController extends Controller
{

    public function index()
    {
       
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }


    public function show(MailTheme $mailTheme)
    {
  
    }

    public function edit(MailTheme $mailTheme)
    {
        
    }

    public function update(Request $request, $id)
    {
        $mail = MailTheme::find($id);

        $mail->hex = $request->hex;

        $mail->save();

        // Mensaje de session
        Session::flash('success', 'Configuración de plantilla exitosa.');

        return redirect()->back();
    }

    public function destroy(MailTheme $mailTheme)
    {
        
    }
}
