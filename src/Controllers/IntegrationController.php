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

use Illuminate\Http\Request;

class IntegrationController extends Controller
{
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
