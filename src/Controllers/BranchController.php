<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

// Ayudantes
use Str;
use Session;
use Auth;
use Purifier;

// Modelos
use Nowyouwerkn\WeCommerce\Models\Branch;
use Nowyouwerkn\WeCommerce\Models\BranchInventory;
use Nowyouwerkn\WeCommerce\Models\Country;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $branches = Branch::all();
        $countries = Country::all();

        return view('wecommerce::back.branches.index')->with('branches', $branches)->with('countries', $countries);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
            'country_id' => 'required|max:255',
            'street' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $branch = new Branch;
        $branch->name = $request->name;
        $branch->slug = Str::slug($request->name);
        $branch->is_warehouse = $request->is_warehouse;
        $branch->country_id = $request->country_id;
        $branch->street = $request->street;
        $branch->street_num = $request->street_num;
        $branch->postal_code = $request->postal_code;
        $branch->city = $request->city;
        $branch->state = $request->state;
        $branch->phone = $request->phone;
        $branch->is_default = $request->is_default ?? 0;
        $branch->save();

        // Mensaje de session
        Session::flash('success', 'Se guardó la información de la sucursal de forma exitosa.');

        // Notificación
        $type = 'branch';
        $by = Auth::user();
        $data = 'creó una nueva sucursal';
        $model_action = "create";
        $model_id = $branch->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Enviar a vista
        return redirect()->route('branches.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }

    public function stockUpdate(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $branch = Branch::find($id);
        $by = Auth::user();

        $inventory = BranchInventory::where('branch_id', $branch->id)->where('product_id', $request->product_id)->first();

        if(empty($inventory)){
            $stock = new BranchInventory;
            $stock->branch_id = $branch->id;
            $stock->product_id = $request->product_id;
            $stock->stock = $request->stock;
            $stock->save();
        }else{
            $inventory->stock = $request->stock;
            $inventory->save();
        }
        
        // Notificación
        $type = 'Sucursal';
        $data = 'Actualizó el inventario de la sucursal:' . $branch->name;
        $model_action = "update";
        $model_id = $branch->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Se actualizó exitosamente tu stock.');

        // Enviar a vista
        return redirect()->back();
    }
}
