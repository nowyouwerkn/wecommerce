<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Session;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Illuminate\Http\Request;

class UserRuleController extends Controller
{

    public function index()
    {
        
    }


    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $rule = new UserRule;
        $rule->is_active = $request->is_active;
        $rule->value = $request->value;
        $rule->save();
        Session::flash('success', 'Se actualizó exitosamente tu regla de usuario.');
        return redirect()->back();
    }


    public function show(UserRule $userRule)
    {
        
    }


    public function edit(UserRule $userRule)
    {
        
    }

 
    public function update(Request $request, $id)
    {
        $rule = UserRule::find($id);

        $rule->is_active = $request->input('is_active');
        $rule->save();
        Session::flash('success', 'Se actualizó exitosamente tu regla de usuario.');

        return redirect()->back();
    }

    public function destroy(UserRule $userRule)
    {
        
    }
}
