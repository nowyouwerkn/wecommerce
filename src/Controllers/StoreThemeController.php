<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Image;
use Str;

use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Illuminate\Http\Request;

class StoreThemeController extends Controller
{
    public function index()
    {
        $themes = StoreTheme::all();

        return view('wecommerce::back.store_themes.index', compact('themes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $deactivate = StoreTheme::where('is_active', true)->get();
        
        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        // Guardar datos en la base de datos
        $theme = new StoreTheme;

        $theme->name = $request->name;
        $theme->description = $request->description;
        $theme->version = $request->version;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug( $request->name , '-') . '.' . $image->getClientOriginalExtension();
            $location = public_path('assets/themes/' . $filename);

            Image::make($image)->resize(400,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $category->image = $filename;
        }

        $theme->is_active = true;
        
        $theme->save();

        //Session message
        Session::flash('success', 'Guardado exitoso, la nueva apariencia quedó activa y las demás se desactivaron.');

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
        //Validation
        $this -> validate($request, array(

        ));

        $config = StoreTheme::find($id);

        $config->google_analytics = $request->google_analytics;
        $config->facebook_pixel = $request->facebook_pixel;
        $config->rfc_name = $request->rfc_name;
        $config->phone = $request->phone;
 
        $config->save();


        //Session message
        Session::flash('success', 'Excelente, tu nueva apariencia de tienda esta activa.');

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        //
    }
}
