<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule;
use Nowyouwerkn\WeCommerce\Models\ShipmentOption;
use Illuminate\Http\Request;

class ShipmentMethodController extends Controller
{
    public function index()
    {
        $config = StoreConfig::first();

        $shipments = ShipmentMethod::all();
        $shipment_rules = ShipmentMethodRule::all();
        $shipment_options = ShipmentOption::orderBy('price', 'asc')->get();

        $ups_method = ShipmentMethod::where('supplier', 'UPS')->first();
        $manual_method = ShipmentMethod::where('type', 'manual')->first();

        return view('wecommerce::back.shipments.index')
        ->with('config', $config)
        ->with('shipments', $shipments)
        ->with('shipment_rules', $shipment_rules)
        ->with('shipment_options', $shipment_options)
        ->with('ups_method', $ups_method)
        ->with('manual_method', $manual_method);
    }

    public function create()
    {
        return view('wecommerce::back.shipments.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        // Desactivar cualquier otro método activo

        $deactivate = ShipmentMethod::where('is_active', true)->get();

        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        $payment = ShipmentMethod::where('supplier', $request->supplier)->first();

        if (!empty($payment)) {
            $payment->update([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'cost' => str_replace(',', '',$request->cost),
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
                'cost' => str_replace(',', '',$request->cost),
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
        return view('wecommerce::back.shipments.show', compact('shipmentMethod'));
    }

    public function edit(ShipmentMethod $shipmentMethod)
    {
        return view('wecommerce::back.shipments.edit', compact('shipmentMethod'));
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
