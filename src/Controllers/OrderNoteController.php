<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Session;

use App\Models\OrderNote;
use Illuminate\Http\Request;

class OrderNoteController extends Controller
{
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

        // Mensaje de session
        Session::flash('success', 'Your note was saved correctly in the database.');

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
