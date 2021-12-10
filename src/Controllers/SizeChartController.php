<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Size_chart;
use Nowyouwerkn\WeCommerce\Models\Size_guide;

class SizeChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $size_chart = size_chart::get();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size_chart = new Size_chart;

        $size_chart->name = $request->name;
        $size_chart->category_id = $request->category_id;
        $size_chart->save();
        $size_chart = size_chart::get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    public function show(size_chart $size_chart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\size_chart  $size_chart
     * @return \Illuminate\Http\Response
     */
    public function edit(size_chart $size_chart)
    {
        //
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
        $size_chart = Size_chart::find($id);
        $size_chart->name = $request->name;
        $size_chart->category_id = $request->category_id;
        $size_chart->save();
        $size_chart = size_chart::get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\size_chart  $size_chart
     * @return \Illuminate\Http\Response
     */
    public function destroy(size_chart $size_chart)
    {
        //
    }
}
