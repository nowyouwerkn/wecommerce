<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;

use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;

use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10);

        return view('wecommerce::back.stocks.index')->with('products', $products);
    }

    public function create()
    {
        return view('wecommerce::back.stocks.create');
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
        $stock->stock = $request->stock_variant;
        $stock->new_price = $request->price_variant;
        $stock->sku = $request->sku_variant;
        $stock->barcode = $request->barcode_variant;

        $stock->save();

        // Mensaje de session
        Session::flash('success', 'Se guardó exitosamente tu stock.');

        // Enviar a vista
        return redirect()->back();
    }

    public function storeDynamic(Request $request)
    {
        // Guardar datos en la base de datos
        $stock = new ProductVariant;
        
        $stock->product_id = $request->product_id;
        
        $variant = Variant::where('value', $request->variant)->first();
        
        if(empty($variant)){
            $variant = new Variant;
            $variant->value = $request->variant;
            $variant->save();
        }

        $stock->variant_id = $variant->id;
        $stock->stock = $request->stock;

        $stock->save();

        return response()->json([
            'mensaje' => 'Mensaje de exito', 
            'variant' => $variant->value
        ], 200);
    }

    public function show($id)
    {
        return view('wecommerce::back.stock.show', compact('stock'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.stocks.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $stock = ProductVariant::find($id);
        
        $stock->stock = $request->stock_variant;
        $stock->new_price = $request->price_variant;
        $stock->sku = $request->sku_variant;

        $stock->save();

        // Mensaje de session
        Session::flash('success', 'Se actualizó exitosamente tu stock.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        // Obtener datos de variante
        $stock = ProductVariant::find($id);

        $stock->delete();

        // Mensaje de session
        Session::flash('success', 'Se eliminó exitosamente la variante de este producto.');

        // Enviar a vista
        return redirect()->back();
    }
}
