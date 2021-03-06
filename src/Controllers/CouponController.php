<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserRule;
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

        $user_rules = UserRule::all();

        return view('wecommerce::back.coupons.index')
        ->with('coupons', $coupons)
        ->with('user_rules', $user_rules);
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

        // Notificaci??n
        $type = 'Cup??n';
        $by = Auth::user();
        $data = 'cre?? un nuevo cup??n con el c??digo: ' . $coupon->code;
        $model_action = "create";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Se guard?? correctamente la informaci??n en tu base de datos.');

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

        // Notificaci??n
        $type = 'Cup??n';
        $by = Auth::user();
        $data = 'edit?? las condiciones del cup??n: ' . $coupon->code;
        $model_action = "update";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Mensaje de session
        Session::flash('success', 'Se guard?? correctamente la informaci??n en tu base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        // Notificaci??n
        $type = 'Cup??n';
        $by = Auth::user();
        $data = 'elimin?? el cup??n con c??digo: ' . $coupon->code;
        $model_action = "destroy";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        //
        $coupon->coupons()->delete();

        $coupon->delete();

        Session::flash('success', 'Se elimin?? el cup??n correctamente.');

        return redirect()->back();
    }
}
