<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Session;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Illuminate\Http\Request;

class UserRuleController extends Controller
{   
    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'condition' => 'unique:user_rules|max:255',
        ));

        // Desactivar cualquier otro método activo
        $deactivate = UserRule::where('is_active', true)->get();

        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        $rule = UserRule::create([
            'type' => $request->type,
            'value' => str_replace(',', '',$request->value),
            'is_active' => true
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');
        return redirect()->route('coupons.index');
    }
 
    public function update(Request $request, $id)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        $rule = UserRule::find($id);
        $rule->update([
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => true,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');
        return redirect()->route('coupons.index');
    }

    public function destroy($id)
    {
        
    }

    public function changeStatus($id)
    {
        // Encontrar el valor de la regla que se quiere cambiar
        $rule = UserRule::find($id);

        // si la regla esta activa
        if ($rule->is_active == true) {
            // Desactivar cualquier otro método activo
            $deactivate = UserRule::where('is_active', false)->get();
            $rule->is_active = false;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
              
                }
            }
        }else{
            // Desactivar cualquier otro método activo
            $deactivate = UserRule::where('is_active', true)->get();
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
