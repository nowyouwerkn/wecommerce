<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Promo;
use Nowyouwerkn\WeCommerce\Models\PromoProduct;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Product;

use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $promos = Promo::all();

        return view('wecommerce::back.promos.index')
        ->with('promos', $promos);
    }

    public function create()
    {  
        $product_brands = Product::where('brand', '!=', NULL)->get();
        $brands = $product_brands->unique('brand');
        $products = Product::all();
        $categories = Category::where('parent_id', NULL)->orWhere('parent_id', '0')->get();

        return view('wecommerce::back.promos.create')->with('products', $products)->with('brands', $brands)->with('categories', $categories);
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'value' => 'required',
            'discount_type' => 'required',
            'end_date' => 'required',
            'is_active' => 'required'
        ));

        // Guardar datos en la base de datos
        $promo = new Promo;

        $promo->value = str_replace(',', '',$request->value);
        $promo->discount_type = $request->discount_type;
        $promo->filtered_by = $request->filter_by;
        $promo->end_date = $request->end_date;
        $promo->is_active = true;
        $promo->save();

        $promo->products()->sync($request->product_id);

        foreach($promo->products as $product){
            $pr = Product::find($product->id);
            $pr->discount_end = $promo->end_date;
            $pr->has_discount = true;

            switch ($promo->discount_type) {
                case 'numeric':
                    $pr->discount_price = $promo->value;
                    break;
    
                case 'percentage':
                    $discount_price = $pr->price - (($promo->value / 100) * $pr->price);

                    $pr->discount_price = $discount_price;
                    break;

                default:
                    $pr->discount_price = $promo->value;
                    break;
            }

            $pr->save();
        }

        // Notificación
        $type = 'Promoción';
        $by = Auth::user();
        $data = 'creó una nueva promoción con valor de: ' . $promo->value;
        $model_action = "create";
        $model_id = $promo->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Se guardó correctamente la información en tu base de datos.');

        // Enviar a vista
        return redirect()->route('promos.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $promo = Promo::find($id);

        return view('wecommerce::back.promos.edit')->with('promo', $promo);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'end_date' => 'required',
            'is_active' => 'required'
        ));

        // Guardar datos en la base de datos
        $promo = Promo::find($id);

        $promo->end_date = $request->end_date;
        $promo->is_active = $request->is_active;
        
        $promo->save();

        // Si se desactiva la promoción 
        if($request->is_active == 0){
            foreach($promo->products as $product){
                $pr = Product::find($product->id);
                $pr->has_discount = false;
                $pr->save();
            }
        }

        if($request->is_active == 1){
            foreach($promo->products as $product){
                $pr = Product::find($product->id);
                $pr->has_discount = true;
                $pr->save();
            }
        }

        foreach($promo->products as $product){
            $pr = Product::find($product->id);
            $pr->discount_end = $promo->end_date;
            $pr->save();
        }

        // Notificación
        $type = 'Promoción';
        $by = Auth::user();
        $data = 'editó las condiciones de la promoción: ' . $promo->value;
        $model_action = "update";
        $model_id = $promo->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Se guardó correctamente la información en tu base de datos.');

        // Enviar a vista
        return redirect()->route('promos.index');
    }

    public function destroy($id)
    {
        $promo = Promo::find($id);

        // Notificación
        $type = 'Promoción';
        $by = Auth::user();
        $data = 'eliminó la promoción con valor: ' . $promo->value;
        $model_action = "destroy";
        $model_id = $promo->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Desactivar descuento de los productos 
        foreach($promo->products as $product){
            $pr = Product::find($product->id);
            $pr->has_discount = false;
            $pr->save();
        }

        $promo->products()->detach();
        $promo->delete();

        Session::flash('success', 'Se eliminó la promoción correctamente.');

        return redirect()->back();
    }

    public function fetchProducts(Request $request)
    {
        $value = $request->get('value');
        $type = $request->get('type');
        $level = $request->get('level');

        switch($type){
            case 'gender':
                $products = Product::where('gender', $value)->get();
                break;
        
            case 'brand':
                $products = Product::where('brand', $value)->get();
                break;

            case 'category':
                if($level == 'first'){
                    $products = Product::where('category_id', $value)->get();
                }

                if($level == 'second'){
                    $category = Category::where('id', $value)->first();

                    $products = Product::whereHas('subCategory', function ($query) use ($category) {
                        $query->where('name', $category->name);
                    })->get();
                }

                if($level == 'third'){
                    $category = Category::where('id', $value)->first();

                    $products = Product::whereHas('subCategory', function ($query) use ($category) {
                        $query->where('name', $category->name);
                    })->get();
                }
                
                break;

            default:
                $products = Product::all();
                break;
        }

        return response()->json($products);
    }
}
