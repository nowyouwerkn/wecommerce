<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Image;
use Str;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', NULL)->paginate(15);
        $categories_all = Category::all()->count();

        return view('back.categories.index')->with('categories', $categories)->with('categories_all', $categories_all);
    }

    public function create()
    {
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', NULL)->paginate(10);

        return view('back.categories.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $check_if_exists = Category::where('name', $request->name)->first();

        // Guardar datos en la base de datos
        $category = new Category;

        $category->name = $request->name;
        if (empty($check_if_exists)) {
            $category->slug = Str::slug($request->name, '-');
        }else{
            $parent_name = Category::where('id', $request->parent_id)->first();

            $category->slug = Str::slug(($parent_name->name . ' ' . $request->name), '-');
        }
        
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug( $request->name , '-') . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/categories/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $category->image = $filename;
        }

        $category->save();

        // Mensaje de session
        Session::flash('exito', 'Elemento guardado correctamente en la base de datos.');

        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        $category = Category::find($id);

        return view('back.categories.show')->with('category', $category);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('back.categories.show')->with('category', $category);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $category = Category::find($id);
        
        $category->name = $request->name;
        $category->translate_name = $request->translate_name;
        
        if (empty($check_if_exists)) {
            $category->slug = Str::slug($request->name, '-');
        }else{
            $parent_name = Category::where('id', $request->parent_id)->first();

            $category->slug = Str::slug(($parent_name->name . ' ' . $request->name), '-');
        }
        
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug( $request->name , '-') . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/categories/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $category->image = $filename;
        }

        $category->save();

        // Mensaje de session
        Session::flash('success', 'Se guardí tu categoría exitosamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        
        $category->delete();

        Session::flash('info', 'Elemento eliminado correctamente de la base de datos.');

        return redirect()->route('categories.index');
    }
}
