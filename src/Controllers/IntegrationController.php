<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Session;
use Auth;
use Str;

use Nowyouwerkn\WeCommerce\Models\Integration;

use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        $integrations = Integration::all();

        return view('wecommerce::back.store_config.index', compact('integrations'));
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
