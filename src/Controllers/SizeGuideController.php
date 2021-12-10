<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Size_chart;
use Nowyouwerkn\WeCommerce\Models\Size_guide;

class SizeGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $size_guide = Size_guide::get();
        $categories = Category::all();
        return view('wecommerce::back.size_guide.index')->with('size_guide', $size_guide)->with('categories', $categories);
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
        $size_guide = new Size_guide;

        $size_guide->name = $request->name;
        $size_guide->category_id = $request->category_id;
        $size_guide->save();
        $size_chart = size_chart::get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\size_guide  $size_guide
     * @return \Illuminate\Http\Response
     */
    public function show(size_guide $size_guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\size_guide  $size_guide
     * @return \Illuminate\Http\Response
     */
    public function edit(size_guide $size_guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\size_guide  $size_guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $guide = Size_guide::find($id);
        $guide->name = $request->name;
        $guide->category_id = $request->category_id;
        $guide->save();
        $size_chart = size_chart::get();
        $categories = Category::all();
        return view('wecommerce::back.size_chart.index')->with('size_chart', $size_chart)->with('categories', $categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\size_guide  $size_guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(size_guide $size_guide)
    {
        //
    }
}
