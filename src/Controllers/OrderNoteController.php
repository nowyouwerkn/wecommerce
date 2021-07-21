<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Session;

use Nowyouwerkn\WeCommerce\Models\OrderNote;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class OrderNoteController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
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
        //Validar
        $this -> validate($request, array(
            'note' => 'required',
        ));

        // Guardar datos en la base de datos
        $note = new OrderNote;

        $note->order_id = $request->order_id;
        $note->user_id = $request->user_id;
        $note->note = $request->note;

        $note->save();

        // Notificación
        $type = 'Orden';
        $by = Auth::user();
        $data = 'creó una nueva nota en la orden #' . $request->order_id;

        $this->notification->send($type, $by ,$data);

        // Mensaje de session
        Session::flash('success', 'Tu nota se guardó exitosamente en la base de datos.');

        // Enviar a vista
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

    public function destroy($id)
    {
        //
    }
}
