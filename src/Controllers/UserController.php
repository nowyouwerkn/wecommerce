<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Session;

use Carbon\Carbon;
use Nowyouwerkn\WeCommerce\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('wecommerce::back.users.index')->with('users', $users)->with('roles', $roles);
    }

    public function create()
    {
        return view('wecommerce::back.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
        ]);

        $admin = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $rol = Role::findByName($request->rol);

        // Guardar primero el admin
        $admin->save();

        // Asignar el Rol
        $admin->assignRole($rol->name);

        return redirect()->back();
    }

    public function show($id)
    {
        return view('wecommerce::back.users.show', compact('id'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if($user->id == Auth::user()->id){
            Session::flash('error', 'No puedes borrar el usuario que está actualmente conectado.');
            
            return redirect()->back();
        }else{

            if ($user->hasRole('technician')) {
                if ($user->tickets_open->count() == 0) {
                    $user->delete();
                }else{
                    Session::flash('error', 'Este usuario técnico tiene tickets asignados, no es posible borrarlo hasta que complete sus tareas pendientes o se le asignen a alguien más.');

                    return redirect()->back();
                }
            }

            $user->delete();

            Session::flash('exito', 'El Usuario ha sido borrado exitosamente.');

            return redirect()->back();
        }        
    }

    public function config()
    {
        return view('wecommerce::back.users.config');
    }
}
