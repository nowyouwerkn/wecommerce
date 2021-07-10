<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Str;
use Config;
use Artisan;
use Exception;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function index()
    {
        return view('wecommerce::back.install.index');
    }

    /*
    public function key(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('key:generate');

        return response()->json(['mensaje' => 'Llave de Encriptación Generada.'], 200);
    }
    */

    public function views(Request $request)
    {
        if (empty($request)) {
            return response()->json(['mensaje' => 'No completaste la información de conexión a la DB'], 500);
        }else{
            Artisan::call('cache:clear');
            
            Config::set('database.connections.mysql.host', '127.0.0.1');
            Config::set('database.connections.mysql.port', $request->db_port);
            Config::set('database.connections.mysql.database', $request->db_database);
            Config::set('database.connections.mysql.username', $request->db_username);
            Config::set('database.connections.mysql.password', $request->db_password);

            $envFileData =
            'APP_NAME=\''."E-Commerce"."'\n".
            'APP_ENV='."local"."\n".
            'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
            'APP_DEBUG='."true"."\n".
            'APP_URL='."http://localhost"."\n\n".
            'DB_CONNECTION='."mysql"."\n".
            'DB_HOST='. "127.0.0.1" ."\n".
            'DB_PORT='.$request->db_port."\n".
            'DB_DATABASE='.$request->db_database."\n".
            'DB_USERNAME='.$request->db_username."\n".
            'DB_PASSWORD='.$request->db_password."\n\n";

            try {
                Storage::disk('root')->put('.env', $envFileData);
            } catch (Exception $e) {
                return response()->json(['mensaje' => 'Información mal formada. Recarga la página e intenta de nuevo. Posiblemente falta configurar las rutas de tu disco.'], 500);
            }    
        }

        return response()->json(['mensaje' => 'Vistas predeterminadas completadas.'], 200);
    }

    public function migrations(Request $request)
    {
        Artisan::call('migrate');

        return response()->json(['mensaje' => 'Migraciones listas.'], 200);
    }

    public function seeders(Request $request)
    {
        /*
        Auth::attempt([
            'email' => 'admin@test.com',
            'password' => 'test12345',
        ]);
        */
        try {
            Artisan::call('db:seed');
        } catch (Exception $e) {
            return response()->json(['mensaje' => 'Ya existía información en el sistema.'], 200);
        } 

        return response()->json(['mensaje' => 'Información predeterminada completada.'], 200);
    }

    public function auth()
    {
        return view('wecommerce::back.install.auth');
    }

    public function authPost(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $user->assignRole('admin');

        Auth::login($user);

        return redirect()->route('config.step1')->with('user', $user);
    }

    public function config()
    {
        return view('wecommerce::back.users.config');
    }
}
