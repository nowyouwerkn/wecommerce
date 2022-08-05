<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;

use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;

use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index()
    {
        $products = Product::paginate(10);


        $all_products = Product::all();

        $size_total = 0;
        $inventory_value = 0;

        foreach ($all_products as $pr) {

            if($pr->variants_stock->count() == 0){
                $size_total += $pr->stock;
            }else{
                foreach($pr->variants_stock as $sz){
                    $size_total += $sz->stock;
                }
            }

            foreach ($pr->variants_stock as $v_price) {
                $inventory_value += ($v_price->stock * $v_price->new_price);
            }
        };

        $size_total;
        $inventory_value;

        return view('wecommerce::back.stocks.index')
        ->with('products', $products)
        ->with('size_total', $size_total)
        ->with('inventory_value', $inventory_value);
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
            $variant->type = $request->type_id;
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
        return redirect(url()->previous().'#variantCard');
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
        $by = Auth::user();

        $values = array('action_by' => $by->id, 'initial_value' => $stock->stock, 'final_value' => $request->stock_variant, 'product_id' => $id);

        DB::table('inventory_record')->insert($values);

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

    public function search(Request $request)
    {
        $search_query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$search_query}%")
        ->where('category_id', '!=', NULL)
        ->orWhere('description', 'LIKE', "%{$search_query}%")
        ->orWhere('search_tags', 'LIKE', "%{$search_query}%")
        ->orWhereHas('category', function ($query) use ($search_query) {
            $query->where(strtolower('name'), 'LIKE', '%' . strtolower($search_query) . '%');
        })->paginate(10);

        $all_products = Product::all();

        $size_total = 0;
        $inventory_value = 0;

        foreach ($all_products as $pr) {

            if($pr->variants_stock->count() == 0){
                $size_total += $pr->stock;
            }else{
                foreach($pr->variants_stock as $sz){
                    $size_total += $sz->stock;
                }
            }

            foreach ($pr->variants_stock as $v_price) {
                $inventory_value += ($v_price->stock * $v_price->new_price);
            }
        };

        $size_total;
        $inventory_value;


        return view('wecommerce::back.stocks.index')
        ->with('products', $products)
        ->with('size_total', $size_total)
        ->with('inventory_value', $inventory_value);
    }


      public function filter($order , $filter)
    {
        $products = Product::orderBy($filter, $order)->paginate(15);

        if ($filter == 'price' && $order == 'desc') {
            $products = Product::orderByRaw('price * 1 desc')->paginate(15);
        }
        if($filter == 'price'&& $order == 'asc'){
            $products = Product::orderByRaw('price * 1 asc')->paginate(15);
        }
        if ($filter == 'stock' && $order == 'desc') {
            $products = Product::orderByRaw('stock * 1 desc')->paginate(15);
        }
        if($filter == 'stock'&& $order == 'asc'){
            $products = Product::orderByRaw('stock * 1 asc')->paginate(15);
        }

        return view('wecommerce::back.stocks.index')->with('products', $products);

    }
}
