<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule;
use Illuminate\Http\Request;

class ShipmentMethodRuleController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('wecommerce::back.shipments.rules.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'condition' => 'unique:shipment_method_rules|max:255',
        ));

        // Desactivar cualquier otro método activo
        $deactivate = ShipmentMethodRule::where('is_active', true)->get();

        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        $rule = ShipmentMethodRule::create([
            'type' => $request->type,
            'condition' => $request->condition,
            'comparison_operator' => $request->comparison_operator,
            'value' => str_replace(',', '',$request->value),
            'allow_coupons' => $request->allow_coupons,
            'is_active' => true,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('shipments.index');
    }

    public function show($id)
    {
        return view('wecommerce::back.shipments.show', compact('shipmentMethod'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.shipments.edit', compact('shipmentMethod'));
    }

    public function update(Request $request, $id)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        $rule = ShipmentMethodRule::find($id);

        $rule->update([
            'type' => $request->type,
            'condition' => $request->condition,
            'comparison_operator' => $request->comparison_operator,
            'value' => $request->value,
            'allow_coupons' => $request->allow_coupons,
            'is_active' => true,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('shipments.index');
    }

    public function destroy($id)
    {
        $rule = ShipmentMethodRule::find($id);
        $rule->delete();

        //Session message
        Session::flash('error', 'El elemento fue eliminado exitosamente.');

        return redirect()->route('shipments.index');
    }

    public function changeStatus($id)
    {
        // Encontrar el valor de la regla que se quiere cambiar
        $rule = ShipmentMethodRule::find($id);

        // si la regla esta activa
        if ($rule->is_active == true) {
            // Desactivar cualquier otro método activo
            $deactivate = ShipmentMethodRule::where('is_active', false)->get();
            $rule->is_active = false;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
              
                }
            }
        }else{
            // Desactivar cualquier otro método activo
            $deactivate = ShipmentMethodRule::where('is_active', true)->get();
            $rule->is_active = true;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
                    $dt->is_active = false;
                    $dt->save();
                }
            }
        }
        $rule->save();

        //Session message
        Session::flash('success', 'El elemento fue actualizado exitosamente.');

        return redirect()->back();
    }
}
