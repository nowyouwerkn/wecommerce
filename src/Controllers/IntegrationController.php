<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Image;
use Session;
use Auth;
use Str;

use Nowyouwerkn\WeCommerce\Models\Integration;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }
    
    public function index()
    {
        $integrations = Integration::all();

        $store_logo = StoreConfig::first();

        return view('wecommerce::back.store_config.index', compact('integrations', 'store_logo'));
    }

    public function storeLogo(Request $request)
    {
        $config = StoreConfig::first();

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = 'logo-store' . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/img/' . $filename);

            Image::make($image)->resize(400,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $config->store_logo = $filename;
        }

        $config->save();

        //Session message
        Session::flash('success', 'Guardado exitoso, se guardó el logo correctamente en tu sitio web.');

        return redirect()->back();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $config = Integration::create([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => true
        ]);

        //Session message
        Session::flash('success', 'Guardado exitoso, se integró correctamente en tu sitio web.');

        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $config = Integration::find($id);

        if($config->is_active == true){
            $config->is_active = false;
        }else{
            $config->is_active = true;
        }

        $config->save();

        //Session message
        Session::flash('success', 'Cambio en el estado de la integración exitoso.');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $config = Integration::find($id);

        $config->update([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $config->is_active,
        ]);

        //Session message
        Session::flash('success', 'Editado exitoso, se integró correctamente en tu sitio web.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $config = Integration::find($id);

        // Notificación
        $type = 'delete';
        $by = Auth::user();
        $data = 'eliminó la integración "' . $config->name . '" de la página web.';
        $model_action = "delete";
        $model_id = $config->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        //
        $config->delete();

        Session::flash('success', 'Se eliminó la integración correctamente.');

        return redirect()->back();
    }
}
