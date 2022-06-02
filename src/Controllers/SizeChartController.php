<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;
use Image;

use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\SizeChart;

class SizeChartController extends Controller
{
    public function index()
    {
         $size_chart = SizeChart::get();
         $categories = Category::all();

         return view('wecommerce::back.size_charts.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    public function create()
    {
        $categories = Category::all();
        return view('wecommerce::back.size_charts.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'image' => 'sometimes|min:10|max:2100'
        ));

        $size_chart = new SizeChart;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'size_chart' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $size_chart->image = $filename;
        }

        $size_chart->name = $request->name;
        $size_chart->category_id = $request->category_id;
        $size_chart->save();

        Session::flash('success', 'Guardada información de guía de tallas..');

        return redirect()->back();
    }

     public function createsize(Request $request)
    {
        $size_guide = new SizeGuide;
        $size_guide->size_chart_id = $request->size_chart_id;
        $size_guide->size_value = $request->size_value;
        $size_guide->save();
        return redirect()->back();
    }

    public function update_value(Request $request)
    {
        $size_guide = SizeGuide::find($request->id);
        $size_guide->size_value = $request->size_value;
        $size_guide->save();
        return redirect()->back();
    }

    public function show($id)
    {
        return view('wecommerce::back.size_charts.show');
    }

    public function edit($id)
    {
        $size_chart = SizeChart::find($id);

        return view('wecommerce::back.size_charts.edit')->with('size_chart', $size_chart);
    }

    public function update(Request $request,  $id)
    {
        //Validar
        $this -> validate($request, array(
            'image' => 'sometimes|min:10|max:2100'
        ));

        $size_chart = SizeChart::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'size_chart' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('img/products/' . $filename);

            Image::make($image)->resize(1280,null, function($constraint){ $constraint->aspectRatio(); })->save($location);

            $size_chart->image = $filename;
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $size_chart = SizeChart::find($id);
        $size_chart->delete();

        return redirect()->back();
    }
}
