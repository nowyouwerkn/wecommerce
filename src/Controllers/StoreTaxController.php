<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Nowyouwerkn\WeCommerce\Models\StoreTax;
use Nowyouwerkn\WeCommerce\Models\Country;

use Illuminate\Http\Request;

class StoreTaxController extends Controller
{
    public function index()
    {   
        $countries = Country::orderBy('id', 'desc')->get();

        return view('wecommerce::back.taxes.index')
        ->with('countries', $countries);
    }

    public function create($country_id)
    {
        $country = Country::find($country_id);

        $tax = StoreTax::where('country_id', $country->id)->where('parent_tax_id', NULL)->first();

        return view('wecommerce::back.taxes.create')->with('country', $country)->with('tax', $tax);
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'tax_rate' => 'required|max:255',
        ));

        $tax = StoreTax::find($request->tax_id);

        if(empty($tax)){
            $tax = StoreTax::create([
                'country_id' => $request->country_id,
                'parent_tax_id' => $request->parent_tax_id,
                'tax_rate' => $request->tax_rate,
                'description' => $request->description,
                'option' => $request->option,
            ]);
        }else{
            $tax->update([
                'country_id' => $request->country_id,
                'parent_tax_id' => $request->parent_tax_id,
                'tax_rate' => $request->tax_rate,
                'description' => $request->description,
                'option' => $request->option,
            ]);
        }

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->back();
    }

    public function show($id)
    {
        return view('wecommerce::back.taxes.show', compact('taxes'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.taxes.edit', compact('taxes'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
