<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Image;
use Str;

use Nowyouwerkn\WeCommerce\Models\SEO;
use Illuminate\Http\Request;

class SEOController extends Controller
{

    public function index()
    {
        $seo = SEO::take(1)->first();

        return view('wecommerce::back.seo.index')->with('seo', $seo);
    }

    public function create()
    {
        return view('wecommerce::back.seo.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(

        ));

        // Guardar datos en la base de datos
        $seo = new SEO;

        $seo->page_title = $request->page_title;
        $seo->page_description = $request->page_description;
        $seo->page_keywords = $request->page_keywords;

        $seo->page_theme_color_hex = $request->page_theme_color_hex;
        $seo->page_canonical_url = $request->page_canonical_url;
        $seo->page_alternate_url = $request->page_alternate_url;

        $seo->save();

         // Mensaje de aviso server-side
        Session::flash('success', 'Tu información de SEO se guardó correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        return view('wecommerce::back.seo.show', compact('seo'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.seo.edit', compact('seo'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(

        ));

        // Guardar datos en la base de datos
        $seo = SEO::find(1);

        $seo->page_title = $request->input('page_title');
        $seo->page_description = $request->input('page_description');
        $seo->page_keywords = $request->input('page_keywords');

        $seo->page_theme_color_hex = $request->input('page_theme_color_hex');
        $seo->page_canonical_url = $request->input('page_canonical_url');
        $seo->page_alternate_url = $request->input('page_alternate_url');

        $seo->save();

        // Mensaje de aviso server-side
        Session::flash('success', 'Tu información de SEO se guardó correctamente.');

        // Redireccionar con información de exito a publicacion.show
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
