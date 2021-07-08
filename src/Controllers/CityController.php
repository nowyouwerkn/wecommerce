<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        return view('back.cities.index');
    }

    public function create()
    {
        return view('back.cities.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $city = City::create([
            'name' => $request->name,
            'code' => $request->code,
            'slug' => Str::slug($request->name),
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('cities.show', $city->id);
    }


    public function show(City $city)
    {
        return view('back.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('back.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        //Validation
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $city = City::find($id);

        $city->update([
            'name' => $request->name,
            'code' => $request->code,
            'slug' => Str::slug($request->name),
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('cities.show', $city->id);
    }

    public function destroy(City $city)
    {
        //
    }
}
