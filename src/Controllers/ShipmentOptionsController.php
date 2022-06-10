<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Image;
use Session;

use Nowyouwerkn\WeCommerce\Models\ShipmentOption;
use Illuminate\Http\Request;

class ShipmentOptionsController extends Controller
{
    public function store(Request $request)
    {
        $this -> validate($request, array(
            'name' => 'required',
            'type' => 'required',
            'delivery_time' => 'required',
            'price' => 'required'
        ));

        // Guardar datos en la base de datos
        $option = new ShipmentOption;

        $option->name = $request->name;
        $option->type = $request->type;
        $option->delivery_time = $request->delivery_time;
        $option->is_active = $request->is_active;
        $option->price = $request->price;
        $option->location = $request->location;

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = 'option_' . time() . '.' . $icon->getClientOriginalExtension();
            $location = public_path('img/' . $filename);

            Image::make($icon)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $option->icon = $filename;
        }

        $option->save();

        // Mensaje de session
        Session::flash('success', 'La opción de envío fue configurada exitosamente. Ahora tus clientes pueden usarla en el proceso de compra.');

        // Enviar a vista
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required',
            'type' => 'required',
            'delivery_time' => 'required',
            'price' => 'required'
        ));

        // Guardar datos en la base de datos
        $option = ShipmentOption::find($id);

        $option->name = $request->name;
        $option->type = $request->type;
        $option->delivery_time = $request->delivery_time;
        $option->is_active = $request->is_active;
        $option->price = $request->price;
        $option->location = $request->location;

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = 'option_' . time() . '.' . $icon->getClientOriginalExtension();
            $location = public_path('img/' . $filename);

            Image::make($icon)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $option->icon = $filename;
        }

        $option->save();

        // Mensaje de session
        Session::flash('success', 'Tu información de opciones de envio se guardó editó en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $option = ShipmentOption::find($id);
        $option->delete();

        Session::flash('success', 'La opcion de envio fue eliminada de manera correcta.');

        return redirect()->back();
    }
}