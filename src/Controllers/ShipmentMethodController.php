<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use App\Models\ShipmentMethod;
use Illuminate\Http\Request;

class ShipmentMethodController extends Controller
{
    public function index()
    {
        $shipments = ShipmentMethod::all();

        $ups_method = ShipmentMethod::where('supplier', 'UPS')->first();

        return view('back.shipments.index')
        ->with('shipments', $shipments)
        ->with('ups_method', $ups_method);
    }

    public function create()
    {
        return view('back.shipments.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        // Desactivar cualquier otro método activo

        $deactivate = ShipmentMethod::where('is_active', 'true');

        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        $payment = ShipmentMethod::where('supplier', $request->supplier)->first();

        if (!empty($payment)) {
            $payment->update([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => true,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'is_active' => true,
            ]);
        }else{
            $payment = ShipmentMethod::create([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => true,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'is_active' => true,
            ]);
        }
        

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('shipments.index');
    }

    public function show(ShipmentMethod $shipmentMethod)
    {
        return view('back.shipments.show', compact('shipmentMethod'));
    }

    public function edit(ShipmentMethod $shipmentMethod)
    {
        return view('back.shipments.edit', compact('shipmentMethod'));
    }

    public function update(Request $request, ShipmentMethod $shipmentMethod)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        $payment = ShipmentMethod::find($id);

        $payment->update([
            'type' => $request->type,
            'public_key' => $request->public_key,
            'private_key' => $request->private_key,
            'sandbox_mode' => $request->sandbox_mode,
            'email_access' => $request->email_access,
            'password_access' => $request->password_access,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('shipments.index');
    }

    public function destroy(ShipmentMethod $shipmentMethod)
    {
        //
    }
}
