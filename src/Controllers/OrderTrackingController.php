<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Session;

use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\OrderTracking;

use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class OrderTrackingController extends Controller
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
        // Guardar datos en la base de datos
        $tracking = new OrderTracking;

        $tracking->order_id = $request->order_id;
        $tracking->products_on_order = $request->products_on_order;
        $tracking->service_name = $request->service_name;
        $tracking->tracking_number = $request->tracking_number;
        $tracking->is_delivered = false;
        $tracking->status = 'En proceso';
 
        $tracking->save();

        // Enviar a vista
        return redirect()->back();

        // Notificación
        $type = 'create';
        $by = Auth::user();
        $data = 'creó una nueva guía de envío en la orden #' . $request->order_id;

        $this->notification->send($type, $by ,$data);

        // Mensaje de session
        Session::flash('success', 'Tu guía de envío se guardó exitosamente en la base de datos.');


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

    public function updateComplete(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $tracking = OrderTracking::find($id);

        $tracking->is_delivered = true;
        $tracking->status = 'Completado';
 
        $tracking->save();

        // Mensaje de session
        Session::flash('success', 'Tu guía de envío se actulizó correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
