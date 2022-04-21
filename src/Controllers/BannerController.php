<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Image;
use Session;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('priority','asc')->paginate(5);

        return view('wecommerce::back.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('wecommerce::back.banners.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'title' => 'unique:banners|required|max:255',
            'subtitle' => 'nullable',
            'text_button' => 'required',
            'link' => 'nullable',
        ));

        // Guardar datos en la base de datos
        $banner = new Banner;

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text_button = $request->text_button;
        $banner->link = $request->link;
        $banner->has_button = true;
        $banner->is_active = true;
        $banner->hex = $request->hex;
        $banner->is_promotional = $request->is_promotional;
        $banner->hex_text_title = $request->hex_text_title;
        $banner->hex_text_subtitle = $request->hex_text_subtitle;
        $banner->hex_button = $request->hex_button;
        $banner->hex_text_button = $request->hex_text_button;
        $banner->position = $request->position;
        $banner->priority = $request->priority;

        // Video en Banner
        $banner->video_background = $request->video_background;

        $banner->video_autoplay = $request->video_autoplay;
        $banner->video_controls = $request->video_controls;
        $banner->video_loop = $request->video_loop;

        $img2 = 'banner';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $img2 . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/banners/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $banner->image_desktop = $filename;
        }

        // Imagen responsiva en Banner

        if ($request->hasFile('image_responsive')) {
            $image = $request->file('image_responsive');
            $filename = $img2 . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/banners/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);
            $banner->image_responsive = $filename;
        }

        $banner->save();


        // Mensaje de session
        Session::flash('success', 'Se creo el banner con exito.');

        // Enviar a vista
        return redirect()->route('banners.show', $banner->id);
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        return view('wecommerce::back.banners.show')->with('banner', $banner);
    }


    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('wecommerce::back.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $banner = Banner::find($id);

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text_button = $request->text_button;
        $banner->link = $request->link;
        $banner->has_button = true;
        $banner->is_active = true;
        $banner->hex = $request->hex;
        $banner->hex_text_title = $request->hex_text_title;
        $banner->hex_text_subtitle = $request->hex_text_subtitle;
        $banner->hex_button = $request->hex_button;
        $banner->hex_text_button = $request->hex_text_button;
        $banner->position = $request->position;
        $banner->priority = $request->priority;
        $banner->is_promotional = $request->is_promotional;

        $img2 = 'model';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $img2 . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/banners/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $banner->image_desktop = $filename;
        }

        $banner->save();

        // Mensaje de session
        Session::flash('success', 'El banner se ha editado satisfactoriamente.');

        // Enviar a vista
        return redirect()->route('banners.show', $banner->id);

    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $banner = Banner::find($request->id);

        if($banner->is_active == true) {
            $banner->is_active = false;
        }else {
            $banner->is_active = true;
        }

        $banner->save();

        // Mensaje de session
        Session::flash('success', 'El banner se ha cambiado de estado.');

        // Enviar a vista
        return redirect()->route('banners.index');
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        $banner->delete();

        Session::flash('success', 'El banner se elimino correctamente.');

        return redirect()->route('banners.index');
    }
}
