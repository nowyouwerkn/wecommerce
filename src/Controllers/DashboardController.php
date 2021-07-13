<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Str;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\Category;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
        
        return view('wecommerce::back.index')
        ->with('product', $product)
        ->with('payment', $payment)
        ->with('shipment', $shipment)
        ->with('category', $category);
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
}
