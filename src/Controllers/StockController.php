<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;

use App\Models\Stock;
use App\Models\Variant;
use App\Models\ProductVariant;

use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index()
    {
        return view('back.stocks.index');
    }

    public function create()
    {
        return view('back.stocks.create');
    }

    public function store(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $stock = new ProductVariant;
        
        $stock->product_id = $id;
        
        $variant = Variant::where('value', $request->variant)->first();
        
        if(empty($variant)){
            $variant = new Variant;
            $variant->value = $request->variant;
            $variant->save();
        }

        $stock->variant_id = $variant->id;
        $stock->stock = $request->stock;

        $stock->save();

        // Mensaje de session
        Session::flash('success', 'Se guardó exitosamente tu stock.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show(Stock $stock)
    {
        return view('back.stock.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        return view('back.stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        //
    }

    public function destroy(Stock $stock)
    {
        //
    }
}
