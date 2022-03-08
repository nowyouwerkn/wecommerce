<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\Headerband;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class HeaderbandController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $headerbands = Headerband::paginate(5);

        return view('wecommerce::back.headerbands.index', compact('headerbands'));
    }

    public function create()
    {
        return view('wecommerce::back.headerbands.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $headerband = new Headerband;
        $headerband->title = $request->title;
        $headerband->text= Purifier::clean($request->text);
        $headerband->button_text= Purifier::clean($request->button_text);
        $headerband->priority = $request->priority;
        $headerband->hex_text = $request->hex_text;
        $headerband->hex_button_text = $request->hex_button_text;
        $headerband->hex_button_back = $request->hex_button_back;
        $headerband->band_link = $request->band_link;
        $headerband->is_active = true;
        $headerband->hex_background = $request->hex_background;
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'Se creó el cintillo con exito.');

        // Notificación
        $type = 'Headerband';
        $by = Auth::user();
        $data = 'creó un cintillo promocional';
        $model_action = "create";
        $model_id = $headerband->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Enviar a vista
        return redirect()->route('band.index');
    }

    public function show($id)
    {
        $headerband = Headerband::find($id);

        return view('wecommerce::back.headerbands.show')->with('headerband', $headerband);
    }


    public function edit($id)
    {
        $headerband = Headerband::find($id);

        return view('wecommerce::back.headerbands.edit', compact('headerband'));
    }

    public function update(Request $request, $id)
    {
       //Validar
        $this -> validate($request, array(
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $headerband = Headerband::find($id);
        $headerband->title = $request->title;
        $headerband->text= Purifier::clean($request->text);
        $headerband->button_text= Purifier::clean($request->button_text);
        $headerband->priority = $request->priority;
        $headerband->hex_text = $request->hex_text;
        $headerband->hex_button_text = $request->hex_button_text;
        $headerband->hex_button_back = $request->hex_button_back;
        $headerband->band_link = $request->band_link;
        $headerband->hex_background = $request->hex_background;
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'Se creo el cintillo con exito.');

        // Notificación
        $type = 'Headerband';
        $by = Auth::user();
        $data = 'editó un cintillo promocional';
        $model_action = "update";
        $model_id = $headerband->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Enviar a vista
        return redirect()->route('band.index');
    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $headerband = Headerband::find($request->id);

        if($headerband->is_active == true) {
            $headerband->is_active = false;
        }else {
            $headerband->is_active = true;
        }
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'El cintillo se ha cambiado de estado.');

        // Notificación
        $type = 'Headerband';
        $by = Auth::user();
        $data = 'cambió el estado de un cintillo promocional';
        $model_action = "update";
        $model_id = $headerband->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Enviar a vista
        return redirect()->route('band.index');
    }

    public function destroy($id)
    {
        $headerband = Headerband::find($id);

        // Notificación
        $type = 'Headerband';
        $by = Auth::user();
        $data = 'eliminó un cintillo promocional';
        $model_action = "destroy";
        $model_id = $headerband->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        $headerband->delete();

        Session::flash('success', 'El cintillo se eliminó correctamente.');

        return redirect()->route('band.index');
    }
}
