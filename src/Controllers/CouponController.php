<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Models\Notification;

use Illuminate\Http\Request;


class CouponController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new Notification;
    }

    public function index()
    {
        $coupons = Coupon::paginate(10);

        return view('wecommerce::back.coupons.index')->with('coupons', $coupons);
    }

    public function create()
    {
        return view('wecommerce::back.coupons.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'code' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $coupon = new Coupon;

        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->type = $request->type;
        $coupon->qty = $request->qty;

        $coupon->minimum_requirements_value = $request->minimum_requirements_value;
        $coupon->usage_limit_per_user = $request->usage_limit_per_user;
        $coupon->usage_limit_per_code = $request->usage_limit_per_code;
        $coupon->exclude_discounted_items = $request->exclude_discounted_items;
        $coupon->individual_use = $request->individual_use;
        $coupon->is_free_shipping = $request->is_free_shipping;


        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->is_active = true;

        $coupon->save();

        // Notificación
        $type = 'Cupón';
        $by = Auth::user();
        $data = 'creó un nuevo cupón con el código: ' . $coupon->code;

        $this->notification->send($type, $by ,$data);

        // Mensaje de session
        Session::flash('success', 'Se guardó correctamente la información en tu base de datos.');

        // Enviar a vista
        return redirect()->route('coupons.index');
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
        //Validar
        $this -> validate($request, array(
            'code' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $coupon = Coupon::find($id);

        $coupon->code = $request->code;
        $coupon->description = $request->description;

        $coupon->save();

        // Notificación
        $type = 'Cupón';
        $by = Auth::user();
        $data = 'editó las condiciones del cupón: ' . $coupon->code;

        $this->notification->send($type, $by ,$data);

        // Mensaje de session
        Session::flash('success', 'Se guardó correctamente la información en tu base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        // Notificación
        $type = 'Cupón';
        $by = Auth::user();
        $data = 'eliminó el cupón con código: ' . $coupon->code;

        $this->notification->send($type, $by ,$data);

        //
        $coupon->delete();

        Session::flash('success', 'Se eliminó el cupón correctamente.');

        return redirect()->back();
    }
}
