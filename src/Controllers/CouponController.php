<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;


class CouponController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
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
            'start_date' => 'required',
            'end_date' => 'required',
            'qty' => 'required|max:255'
        ));

        // Guardar datos en la base de datos
        $coupon = new Coupon;

        $coupon->code = $request->code;
        $coupon->description = $request->description;
        $coupon->type = $request->type;
        $coupon->qty = str_replace(',', '',$request->qty);

        $coupon->minimum_requirements_value = str_replace(',', '',$request->minimum_requirements_value);
        $coupon->usage_limit_per_user = str_replace(',', '',$request->usage_limit_per_user);
        $coupon->usage_limit_per_code = str_replace(',', '',$request->usage_limit_per_code);
        $coupon->exclude_discounted_items = $request->exclude_discounted_items;
        $coupon->individual_use = $request->individual_use;

        if ($request->type == 'free_shipping') {
            $coupon->is_free_shipping = true;
        }

        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->is_active = true;

        $coupon->save();

        // Notificación
        $type = 'Cupón';
        $by = $user;
        $data = 'creó un nuevo cupón con el código: ' . $coupon->code;
        $model_action = "create";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

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
        $by = $user;
        $data = 'editó las condiciones del cupón: ' . $coupon->code;
        $model_action = "update";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

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
        $by = $user;
        $data = 'eliminó el cupón con código: ' . $coupon->code
        $model_action = "destroy";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        //
        $coupon->coupons()->delete();

        $coupon->delete();

        Session::flash('success', 'Se eliminó el cupón correctamente.');

        return redirect()->back();
    }
}
