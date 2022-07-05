<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Session;
use Auth;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index ()
    {
        $config = StoreConfig::take(1)->first();

        if(empty($config)){
            return redirect()->route('config.step1');
        }

        $product = Product::first();
        $payment = PaymentMethod::where('is_active', true)->first();
        $shipment = ShipmentMethod::first();
        $category = Category::first();

        $total_products = Product::where('status', 'Publicado')->get();
        $total_stock = 0;

        foreach ($total_products as $t_total) {
            $total_stock += $t_total->stock;
        };

        $total_stock;

        $new_clients = User::role('customer')->where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Conteo Ventas KPI's
        /*
         *  CALCULANDO SALDO PENDIENTE DEL MES
        */
        $year_start = Carbon::now()->startOfYear();
        $year_end = Carbon::now()->endOfYear();

        $month_start = Carbon::now()->startOfMonth();
        $month_end = Carbon::now()->endOfMonth();

        $week_start = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $week_end = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $ventas_total = Order::where('status', '!=', 'Cancelado')
        ->where('status', '!=', 'Expirado')
        ->where('status', '!=', 'Sin Completar')
        ->whereBetween('created_at', [$year_start, $year_end])
        ->get();

        $ventas_mes = Order::where('status', '!=', 'Cancelado')
        ->where('status', '!=', 'Expirado')
        ->where('status', '!=', 'Sin Completar')
        ->whereBetween('created_at', [$month_start, $month_end])
        ->get();

        $ventas_semana = Order::where('status', '!=', 'Cancelado')
        ->where('status', '!=', 'Expirado')
        ->where('status', '!=', 'Sin Completar')
        ->whereBetween('created_at', [$week_start, $week_end])
        ->get();

        $ventas_semana_prev = Order::where('status', '!=', 'Cancelado')
        ->where('status', '!=', 'Expirado')
        ->where('status', '!=', 'Sin Completar')
        ->whereBetween('created_at', [$week_start->subWeek(1), $week_end->subWeek(1)])
        ->get();

        $ven_total = 0;
        $ven_mes = 0;
        $ven_semana = 0;
        $ven_semana_prev = 0;

        foreach ($ventas_total as $v_total) {
            $ven_total += $v_total->payment_total;
        };

        foreach ($ventas_mes as $v_month) {
            $ven_mes += $v_month->amount;

        };

        foreach ($ventas_semana as $v_week) {
            $ven_semana += $v_week->payment_total;
        };

        foreach ($ventas_semana_prev as $v_week_prev) {
            $ven_semana_prev += $v_week_prev->payment_total;
        };

        $ven_total;
        $ven_mes;
        $ven_semana;
        $ven_semana_prev;

        if ($ventas_total->count() == 0) {
            $avg_order = 0;
        }else{
            $avg_order = ($ven_total)/($ventas_total->count());
        }

        /* Ventas por Semana */
        $lunes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek())
        ->get();

        $martes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->addDays(1)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->addDays(1))
        ->get();

        $miercoles = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->addDays(2)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->addDays(2))
        ->get();

        $jueves = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->addDays(3)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->addDays(3))
        ->get();

        $viernes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->addDays(4)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->addDays(4))
        ->get();

        $sabado = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->addDays(5)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->addDays(5))
        ->get();

        $domingo = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->endOfWeek()->endOfDay())
        ->where('created_at', '>=', Carbon::now()->endOfWeek())
        ->get();

        $lun = 0;
        $mar = 0;
        $mie = 0;
        $jue = 0;
        $vie = 0;
        $sab = 0;
        $dom = 0;

        foreach ($lunes as $v_1) {
            $lun += $v_1->payment_total;
        };

        foreach ($martes as $v_2) {
            $mar += $v_2->payment_total;
        };

        foreach ($miercoles as $v_3) {
            $mie += $v_3->payment_total;
        };

        foreach ($jueves as $v_4) {
            $jue += $v_4->payment_total;
        };

        foreach ($viernes as $v_5) {
            $vie += $v_5->payment_total;
        };

        foreach ($sabado as $v_6) {
            $sab += $v_6->payment_total;
        };

        foreach ($domingo as $v_0) {
            $dom += $v_0->payment_total;
        };

        $lun;
        $mar;
        $mie;
        $jue;
        $vie;
        $sab;
        $dom;

        /* Ventas Semana Anterior */
        $pre_lunes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(7)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(7))
        ->get();

        $pre_martes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(6)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(6))
        ->get();

        $pre_miercoles = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(5)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(5))
        ->get();

        $pre_jueves = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(4)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(4))
        ->get();

        $pre_viernes = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(3)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(3))
        ->get();

        $pre_sabado = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(2)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(2))
        ->get();

        $pre_domingo = Order::where('status', '!=', 'Cancelado')->where('status', '!=', 'Expirado')->where('status', '!=', 'Sin Completar')->where('created_at', '<=', Carbon::now()->startOfWeek()->subDays(1)->endOfDay())
        ->where('created_at', '>=', Carbon::now()->startOfWeek()->subDays(1))
        ->get();

        $pre_lun = 0;
        $pre_mar = 0;
        $pre_mie = 0;
        $pre_jue = 0;
        $pre_vie = 0;
        $pre_sab = 0;
        $pre_dom = 0;

        foreach ($pre_lunes as $vv_1) {
            $pre_lun += $vv_1->payment_total;
        };

        foreach ($pre_martes as $vv_2) {
            $pre_mar += $vv_2->payment_total;
        };

        foreach ($pre_miercoles as $vv_3) {
            $pre_mie += $vv_3->payment_total;
        };

        foreach ($pre_jueves as $vv_4) {
            $pre_jue += $vv_4->payment_total;
        };

        foreach ($pre_viernes as $vv_5) {
            $pre_vie += $vv_5->payment_total;
        };

        foreach ($pre_sabado as $vv_6) {
            $pre_sab += $vv_6->payment_total;
        };

        foreach ($pre_domingo as $vv_0) {
            $pre_dom += $vv_0->payment_total;
        };

        $pre_lun;
        $pre_mar;
        $pre_mie;
        $pre_jue;
        $pre_vie;
        $pre_sab;
        $pre_dom;

        $max = max([$lun,$mar,$mie,$jue,$vie,$sab,$dom]);
        $pre_max = max([$pre_lun,$pre_mar,$pre_mie,$pre_jue,$pre_vie,$pre_sab,$pre_dom]);

        if ($max > $pre_max) {
            $max = $max;
        }else{
            $max = $pre_max;
        }

        // Ordenes por su estado actual
        $total_entregado = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Entregado')
        ->count();

        $total_enviado = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Enviado')
        ->count();

        $total_pagado = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Pagado')
        ->count();

        $total_empaquetado = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Empaquetado')
        ->count();

        $total_sincompletar = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Sin Completar')
        ->count();

        $total_cancelado = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)->where('status', '=', 'Cancelado')
        ->count();


        /* Estadísticas de Ordenes Nuevas */

        $new_orders = $ventas_semana->count();
        $prev_orders = $ventas_semana_prev->count();

        if ($new_orders == NULL && $prev_orders == NULL) {
            $percent_diff_orders = number_format(0,2);
        } else {
            $diff_orders = $new_orders - $prev_orders;
            $avg_ord = ($new_orders + $prev_orders) / 2;

            $percent_diff_orders = number_format(($diff_orders / $avg_ord) * 100,2);
        }



        return view('wecommerce::back.index')
        ->with('product', $product)
        ->with('payment', $payment)
        ->with('shipment', $shipment)
        ->with('category', $category)
        ->with('ven_total', $ven_total)
        ->with('ven_semana', $ven_semana)
        ->with('ven_semana_prev', $ven_semana_prev)
        ->with('new_clients', $new_clients)
        ->with('new_orders', $new_orders)
        ->with('percent_diff_orders', $percent_diff_orders)
        ->with('avg_order', $avg_order)
        ->with('lun', $lun)
        ->with('mar', $mar)
        ->with('mie', $mie)
        ->with('jue', $jue)
        ->with('vie', $vie)
        ->with('sab', $sab)
        ->with('dom', $dom)
        ->with('pre_lun', $pre_lun)
        ->with('pre_mar', $pre_mar)
        ->with('pre_mie', $pre_mie)
        ->with('pre_jue', $pre_jue)
        ->with('pre_vie', $pre_vie)
        ->with('pre_sab', $pre_sab)
        ->with('pre_dom', $pre_dom)
        ->with('max', $max)
        ->with('total_stock', $total_stock)
        ->with('total_entregado', $total_entregado)
        ->with('total_enviado', $total_enviado)
        ->with('total_pagado', $total_pagado)
        ->with('total_empaquetado', $total_empaquetado)
        ->with('total_sincompletar', $total_sincompletar)
        ->with('total_cancelado', $total_cancelado);
    }

    public function configuration ()
    {
        return view('wecommerce::back.configuration');
    }

    public function shipping ()
    {
        return view('wecommerce::back.shipping.index');
    }

    // Configuration Steps
    public function configStep1 ()
    {
        return view('wecommerce::back.config_steps.step1');
    }

    public function configStep2 ($id)
    {
        $config = StoreConfig::find($id);

        return view('wecommerce::back.config_steps.step2')->with('config', $config);
    }

    public function changeColor()
    {
        $user_id = Auth::user()->id;

        $user = User::find($user_id);

        if ($user->color_mode == 0) {
            $user->color_mode = 1;
        }else{
            $user->color_mode = 0;
        }
        $user->save();

        // Mensaje de session
        Session::flash('success', 'Modo de color cambiado exitosamente.');

        return redirect()->back();
    }

    public function messages()
    {
        return view('wecommerce::back.messages');
    }

    public function generalSearch(Request $request)
    {
        $search_query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$search_query}%")
        ->where('category_id', '!=', NULL)
        ->orWhere('description', 'LIKE', "%{$search_query}%")
        ->orWhere('search_tags', 'LIKE', "%{$search_query}%")
        ->orWhereHas('category', function ($query) use ($search_query) {
            $query->where(strtolower('name'), 'LIKE', '%' . strtolower($search_query) . '%');
        })->paginate(30);

        return view('wecommerce::back.general_search')->with('products', $products);
    }
}
