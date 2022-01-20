<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;
use Session;
use Auth;


use Nowyouwerkn\WeCommerce\Models\ProductRelationship;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {

        $base_check = ProductRelationship::where('base_product_id', $request->product_id)->where('type', $request->type)->first();
        if(!empty($base_check)){
             Session::flash('error', 'El producto que estas tratando de agregar ya forma base para otra relacion.');
            return redirect()->back();
        }
        $product_check = ProductRelationship::where('base_product_id', $request->base_product_id)->where('type', $request->type)->where('product_id', $request->product_id)->first();
        if(!empty($product_check)){
             Session::flash('error', 'El producto que estas tratando de agregar ya forma parte de esta relacion.');
            return redirect()->back();
        }
        $relationship = new ProductRelationship;

        $relationship->type = $request->type;
        $relationship->value = $request->value;
        $relationship->product_id = $request->product_id;
        $relationship->base_product_id = $request->base_product_id;
        $relationship->save();
        Session::flash('success', 'El producto fue agregado a tu relación.');
        return redirect()->back();
    }

    public function show(ProductRelationship $productRelationship)
    {
        
    }

    public function edit(ProductRelationship $productRelationship)
    {
        
    }

    public function update(Request $request, ProductRelationship $productRelationship)
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
}
