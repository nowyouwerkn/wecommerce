<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;

use Illuminate\Http\Request;

use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductRelationship;


/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

class ProductRelationshipController extends Controller
{

    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request, $id)
    {
        $base_check = ProductRelationship::where('base_product_id', $id)
        ->where('type', $request->type)
        ->where('value', $request->value)
        ->first();

        if(!empty($base_check)){
             Session::flash('error', 'El producto que estas tratando de agregar ya está relacionado con otro producto, selecciona uno nuevo o elimina la relación anterior para vincularlos.');
            return redirect()->back();
        }

        $product_check = ProductRelationship::where('base_product_id', $id)
        ->where('type', $request->type)
        ->where('product_id', $request->product_id)
        ->first();

        if(!empty($product_check)){
             Session::flash('error', 'El producto que estas tratando de agregar ya forma parte de esta relacion.');
            return redirect()->back();
        }

        $relationship = new ProductRelationship;

        $relationship->type = $request->type;
        $relationship->value = $request->value;
        $relationship->product_id = $request->product_id;
        $relationship->base_product_id = $id;

        $relationship->save();

        Session::flash('success', 'Los productos fueron relacionados exitosamente.');

        return redirect()->back();
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
            
        $relationship = ProductRelationship::where('id',$id)->first();

        // Notificación
        $type = 'Relacion';
        $by = Auth::user();
        $data = 'eliminó permanentemente la relacion con el id ' . $relationship->id;
        $model_action = "delete";
        $model_id = $relationship->id;



        $this->notification->send($type, $by ,$data, $model_action, $model_id);
        //
        $relationship->delete();

        Session::flash('success', 'Esta relación se eliminó exitosamente.');

        return redirect()->back();
    }

    public function fetchColor(Request $request)
    {
        $product = Product::where('id', $request->value)->first();

        if ($request->type == 'Color') {
            return response()->json(['product_color' => $product->color], 200);
        }else{
            return response()->json(['product_color' => $product->materials], 200);
        }
        
    }
}
