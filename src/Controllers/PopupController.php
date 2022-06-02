<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Image;
use Session;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Nowyouwerkn\WeCommerce\Models\Popup;

use Illuminate\Http\Request;

class PopupController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $popups = Popup::paginate(5);

        return view('wecommerce::back.popups.index', compact('popups'));
    }

    public function create()
    {
        return view('wecommerce::back.popups.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'title' => 'required|max:255',
            'subtitle' => 'nullable',
            'image' => 'sometimes|min:10|max:2100'
        ));

        // Guardar datos en la base de datos
        $popup = new Popup;

        $popup->style_type = $request->style_type;
        $popup->title = $request->title;
        $popup->subtitle = $request->subtitle;
        $popup->text_button = $request->text_button;
        $popup->link = $request->link;
        $popup->text = $request->text;
        $popup->position = $request->position;
        $popup->has_button = $request->has_button;
        if($popup->has_button == null){
            $popup->has_button = 0;
        }
        $popup->is_active = true;
        $popup->hex = $request->hex;

        $popup->show_on_exit = $request->show_on_exit;
        $popup->show_on_enter = $request->show_on_enter;

        $img2 = 'popup';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $img2 . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/popups/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $popup->image = $filename;
        }

        $popup->save();

        // Mensaje de session
        Session::flash('success', 'Se creo el popup con exito.');

        // Enviar a vista
        return redirect()->route('popups.show', $popup->id);
    }

    public function show($id)
    {
        $popup = Popup::find($id);

        return view('wecommerce::back.popups.show')->with('popup', $popup);
    }


    public function edit($id)
    {
        $popup = Popup::find($id);
        return view('wecommerce::back.popups.edit', compact('popup'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'image' => 'sometimes|min:10|max:2100'
        ));

        // Guardar datos en la base de datos
        $popup = Popup::find($id);

        $popup->style_type = $request->style_type;
        $popup->title = $request->title;
        $popup->subtitle = $request->subtitle;
        $popup->text_button = $request->text_button;
        $popup->link = $request->link;
        $popup->text = $request->text;
        $popup->position = $request->position;
        $popup->has_button = $request->has_button;
        if ($popup->has_button == null) {
            $popup->has_button = 0;
        }
        $popup->is_active = true;
        $popup->hex = $request->hex;

        $popup->show_on_exit = $request->show_on_exit;
        $popup->show_on_enter = $request->show_on_enter;

        $img2 = 'popup';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $img2 . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/popups/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $popup->image = $filename;
        }

        $popup->save();

        // Mensaje de session
        Session::flash('success', 'El popup se ha editado satisfactoriamente.');

        // Enviar a vista
        return redirect()->route('popups.show', $popup->id);
    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $popup = Popup::find($request->id);

        if($popup->is_active == true) {
            $popup->is_active = false;
        }else {
            $popup->is_active = true;
        }

        $popup->save();

        // Mensaje de session
        Session::flash('success', 'El popup se ha cambiado de estado.');

        // Enviar a vista
        return redirect()->route('popups.index');
    }

    public function destroy($id)
    {
        $popup = Popup::find($id);

        $popup->delete();

        Session::flash('success', 'El popup se elimino correctamente.');

        return redirect()->route('popups.index');
    }
}
