<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Session;
use Auth;
use Str;

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

        $orders = Order::all();
        
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });


        $new_orders = Order::where('created_at', '>=', Carbon::now()->subWeek())->get();

        $new_orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

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
        
        $ventas_total = Order::where('created_at', '<=', $year_end)
        ->where('created_at', '>=', $year_start)
        ->get();

        $ventas_mes = Order::where('created_at', '<=', $month_end)
        ->where('created_at', '>=', $month_start)
        ->get();

        $ventas_semana = Order::where('created_at', '<=', $week_end)
        ->where('created_at', '>=', $week_start)
        ->get();

        $ven_total = 0;
        $ven_mes = 0;
        $ven_semana = 0;

        foreach ($ventas_total as $v_total) {
            $v_total->cart = unserialize($v_total->cart);

            $ven_total += $v_total->cart->totalPrice;
        };

        foreach ($ventas_mes as $v_month) {
            $ven_mes += $v_month->amount;

        };

        foreach ($ventas_semana as $v_week) {
            $v_week->cart = unserialize($v_week->cart);

            $ven_semana += $v_week->cart->totalPrice;
        };

        $ven_total;
        $ven_mes;
        $ven_semana;

        if ($orders->count() == 0) {
            $avg_order = 0;
        }else{
            $avg_order = ($ven_total)/($orders->count());
        }
        

        return view('wecommerce::back.index')
        ->with('product', $product)
        ->with('payment', $payment)
        ->with('shipment', $shipment)
        ->with('category', $category)
        ->with('ven_total', $ven_total)
        ->with('new_clients', $new_clients)
        ->with('new_orders', $new_orders)
        ->with('orders', $orders)
        ->with('avg_order', $avg_order);
    }

    public function configuration () 
    {
        return view('wecommerce::back.configuration');
    }

    public function generalPreferences () 
    {
        
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
}
