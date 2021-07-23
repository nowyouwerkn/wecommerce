<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Image;
use Str;

use Nowyouwerkn\WeCommerce\Models\SEO;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Illuminate\Http\Request;

class StoreConfigController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'store_name' => 'required|max:255',
        ));

        $config = StoreConfig::create([
            'store_name' => $request->store_name,
            'contact_email' => $request->contact_email,
            'sender_email' => $request->sender_email,
            'store_industry' => $request->store_industry,
            'currency_id' => $request->currency_id
        ]);

        $seo = SEO::create([
            'page_title' => $request->store_name
        ]);

        //Session message
        Session::flash('success', 'Guardado exitoso, puedes continuar con el llenado de información o dejarlo para después.');

        return redirect()->route('config.step2', $config->id);
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
        //Validation
        $this -> validate($request, array(

        ));

        $config = StoreConfig::find($id);

        $config->google_analytics = $request->google_analytics;
        $config->facebook_pixel = $request->facebook_pixel;
        $config->rfc_name = $request->rfc_name;
        $config->phone = $request->phone;
        $config->street = $request->street;
        $config->street_num = $request->street_num;
        $config->zip_code = $request->zip_code;
        $config->city = $request->city;
        $config->state = $request->state;
        $config->country_id = $request->country_id;
        $config->timezone = $request->timezone;
        $config->unit_system = $request->unit_system;
        $config->weight_system = $request->weight_system;
 
        $config->save();

        //Session message
        Session::flash('success', 'Excelente, tu tienda esta lista para usarse. Sigue las recomendaciones para completarla correctamente.');

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        //
    }
}
