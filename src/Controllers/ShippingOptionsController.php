<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;

use Nowyouwerkn\WeCommerce\Models\ShipmentOption;
use Illuminate\Http\Request;

class ShippingOptionsController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
          $this -> validate($request, array(
            'name' => 'required',
             'delivery_time' => 'required'
        ));

        // Guardar datos en la base de datos
        $shipping = new ShipmentOption;

        $shipping->name = $request->name;
        $shipping->delivery_time = $request->delivery_time;
        $shipping->is_active = $request->is_active;
        $shipping->icon = $request->icon;
        $shipping->price = $request->price;


        $shipping->save();

        // Mensaje de session
        Session::flash('success', 'Tu información de opciones de envio se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show(shipping_options $shipping_options)
    {

    }


    public function edit(shipping_options $shipping_options)
    {

    }

    public function update(Request $request, $id)
    {
     //Validar
           $this -> validate($request, array(
            'name' => 'required',
             'delivery_time' => 'required'
        ));

        // Guardar datos en la base de datos
        $shipping = ShipmentOption::find($id);
        $shipping->name = $request->name;
        $shipping->delivery_time = $request->delivery_time;
        $shipping->is_active = $request->is_active;
         $shipping->icon = $request->icon;
        $shipping->price = $request->price;


        $shipping->save();

        // Mensaje de session
        Session::flash('success', 'Tu información de opciones de envio se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
          $shipping = ShipmentOption::find($id);

        $shipping->delete();

        Session::flash('success', 'La opcion de envio fue eliminada de manera correcta.');

        return redirect()->back();
    }
}