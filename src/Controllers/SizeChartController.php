<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\SizeChart;
use Nowyouwerkn\WeCommerce\Models\SizeGuide;

class SizeChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $size_chart = sizeChart::get();
         $categories = Category::all();
         return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('wecommerce::back.size_chart.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size_chart = new SizeChart;

        $size_chart->name = $request->name;
        $size_chart->category_id = $request->category_id;
        $size_chart->save();
        $size_chart_id = SizeChart::where('name', $request->name)->where('category_id', $request->category_id)->first();


        $size_chart = SizeChart::get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
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
        return view('wecommerce::back.size_chart.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\size_chart  $size_chart
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size_chart = SizeChart::find($id);
        $size_guide = SizeGuide::where('size_chart_id', $id)->get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.edit')->with('size_chart', $size_chart)->with('size_guide', $size_guide)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\size_chart  $size_chart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $size_chart = SizeChart::find($id);
        $size_chart->name = $request->name;
        $size_chart->category_id = $request->category_id;
        $size_chart->save();
        $size_chart = SizeChart::get();
        $categories = Category::all();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\size_chart  $size_chart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size_chart = SizeChart::find($id);
        $size_chart->delete();

        return redirect()->back();
    }
}
