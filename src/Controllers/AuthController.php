<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

// Ayudantes
use Session;
use Illuminate\Support\Facades\Auth;

// Modelos
use Nowyouwerkn\WeCommerce\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registro()
    {
        return view('wecommerce::front.werkn-backbone.auth');
    }

    public function postRegistro(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
        ]);

        /* Forma 2 */
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->save();
        $user->assignRole('customer');

        Auth::login($user);

        if (Session::has('oldUrl')) {

            $oldUrl = Session::get('oldUrl');
            Session::forget('oldUrl');
            return redirect()->to($oldUrl);
        }
        
        return redirect()->route('index');
    }

    public function login()
    {
        return view('wecommerce::front.werkn-backbone.auth');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4',
        ]);

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {

            if (Session::has('oldUrl')) {

                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }

            return redirect()->route('index'); 
        }

        return redirect()->back();
    }

    public function logout()
    {

        $oldCart = Session::get('cart');
        $cart = new Carrito($oldCart);

        Session::forget('cart');

        Auth::logout();

        return redirect()->route('index');

    }
    
}
