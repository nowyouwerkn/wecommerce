<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

// Ayudantes
use Session;
use Auth;

// Modelos
use Nowyouwerkn\WeCommerce\Models\Channel;

use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::all();

        return view('back.channels.index')->with('channels', $channels);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $channel = Channel::create([
            'in' => $user->in,
            'info' => $request->info,
            'info_2' => $request->info_2,
            'info_3' => $request->info_3,
        ]);

        // Mensaje de session
        Session::flash('success', 'Your Channel was saved correctly in the database.');

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

    }

    public function destroy($id)
    {
        $channel = Channel::find($id);
        $channel->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
