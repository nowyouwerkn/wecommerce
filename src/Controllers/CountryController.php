<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Nowyouwerkn\WeCommerce\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        return view('wecommerce::back.country.index');
    }

    public function create()
    {
        return view('wecommerce::back.country.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Country $country)
    {
        return view('wecommerce::back.country.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('wecommerce::back.country.edit', compact('country'));
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
