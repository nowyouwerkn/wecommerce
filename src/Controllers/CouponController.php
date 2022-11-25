<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserRule;
use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Models\CouponExcludedCategory;
use Nowyouwerkn\WeCommerce\Models\CouponExcludedProduct;
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
        $coupons = Coupon::orderBy('created_at', 'desc')->orderBy('end_date', 'desc')->orderBy('is_active', 'asc')->paginate(10);
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
            'code' => 'required|unique:coupons|max:255',
            'start_date' => 'required',
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
        $coupon->end_date = $request->end_date ?? null;
        $coupon->is_active = true;

        $coupon->save();

        // Categorías excluidas
        if(isset($request->excluded_categories)){
            $categories = $request->input('excluded_categories');
            foreach($categories as $cat) {
                $exc_cat = new CouponExcludedCategory;

                $exc_cat->category_id = $cat;
                $exc_cat->coupon_id = $coupon->id;
                $exc_cat->save();
            }
        }

        if(isset($request->excluded_products)){
            // Productos Excluidos
            $products = $request->input('excluded_products');
            foreach($products as $prod) {
                $exc_pro = new CouponExcludedProduct;

                $exc_pro->product_id = $prod;
                $exc_pro->coupon_id = $coupon->id;
                $exc_pro->save();
            }
        }
        
        // Notificación
        $type = 'Cupón';
        $by = Auth::user();
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
        $by = Auth::user();
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
        $by = Auth::user();
        $data = 'eliminó el cupón con código: ' . $coupon->code;
        $model_action = "destroy";
        $model_id = $coupon->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        // Eliminar cupon con sus exlusiones de categoría
        $coupon_cat = CouponExcludedCategory::where('coupon_id', $id)->get();
        foreach ($coupon_cat as $cat){
            $cat->delete();
        }

        // Eliminar cupon con sus exlusiones de producto
        $coupon_pro = CouponExcludedProduct::where('coupon_id', $id)->get();
        foreach ($coupon_pro as $pro){
            $pro->delete();
        }

        $coupon->coupons()->delete();
        $coupon->delete();

        Session::flash('success', 'Se eliminó el cupón correctamente.');

        return redirect()->back();
    }
}
