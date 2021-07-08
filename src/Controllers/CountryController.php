<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        return view('back.country.index');
    }

    public function create()
    {
        return view('back.country.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Country $country)
    {
        return view('back.country.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('back.country.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        //
    }

    public function destroy(Country $country)
    {
        //
    }
}
