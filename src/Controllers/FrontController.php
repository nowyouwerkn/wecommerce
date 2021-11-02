<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Carbon\Carbon;

/* Stripe Helpers */
use Stripe\Stripe;
use Stripe\Charge;

/* Paypal Helpers */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

/* Openpay Helpers */
use Openpay;
use OpenpayApiError;
use OpenpayApiAuthError;
use OpenpayApiRequestError;
use OpenpayApiConnectionError;
use OpenpayApiTransactionError;

/* E-commerce Models */
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Nowyouwerkn\WeCommerce\Models\Banner;
use Nowyouwerkn\WeCommerce\Models\Cart;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Wishlist;
use Nowyouwerkn\WeCommerce\Models\LegalText;

use Nowyouwerkn\WeCommerce\Models\StoreTax;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserAddress;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/* Cuopon Models */
use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Models\UserCoupon;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/* Facebook Events API Conversion */
use Nowyouwerkn\WeCommerce\Services\FacebookEvents;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    private $notification;
    private $theme;
    private $store_config;

    public function __construct()
    {
        $this->notification = new NotificationController;
        $this->theme = new StoreTheme;
        $this->store_config = new StoreConfig;
    }
    
    public function index ()
    {
        $banners = Banner::where('is_active', true)->get();
        $main_categories = Category::where('parent_id', '0')->orWhere('parent_id', NULL)->get(['name', 'slug', 'image'])->take(4);

        $products = Product::where('in_index', true)->where('status', 'Publicado')->with('category')->get()->take(6);
        $products_favorites = Product::where('in_index', true)->where('is_favorite', true)->where('status', 'Publicado')->with('category')->get()->take(6);

        return view('front.theme.' . $this->theme->get_name() . '.index')
        ->with('products', $products)
        ->with('products_favorites', $products_favorites)
        ->with('main_categories', $main_categories)
        ->with('banners', $banners);
    }

    /*
    * Catálogo
    * Controladores para vistas de catálogo y producto
    */
    public function dynamicFilter(Request $request)
    {
        $total_products = Product::get(['id'])->count();

        $input = $request->all();

        $selected_category = $request->category;
        $selected_variant = $request->variant;
        
        $query = Product::select('*')->where('in_index', true)->where('status', 'Publicado');

        if (isset($selected_category)) {
            $query->whereHas('category', function ($query) use ($selected_category) {
                $query->whereIn('slug', $selected_category);
            });
        }

        if (isset($selected_variant)) {
            $query->whereHas('variants', function ($query) use ($selected_variant) {
                $query->whereIn('value', $selected_variant);
            });
        }

        $products = $query->with('category')->paginate(30)->withQueryString();

        /* Opciones para Filtro */
        $popular_products = Product::with('category')->where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = Category::with('productsIndex')->where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        if($products->count() > 0){
            return view('front.theme.' . $this->theme->get_name() . '.catalog_filter')
            ->with('products', $products)
            ->with('total_products', $total_products)
            ->with('selected_category', $selected_category)
            ->with('selected_variant', $selected_variant)
            ->with('popular_products', $popular_products)
            ->with('categories', $categories)
            ->with('variants', $variants);
        }else{
            $products = collect([]);

            return view('front.theme.' . $this->theme->get_name() . '.catalog_filter')
            ->with('products', $products)
            ->with('total_products', $total_products)
            ->with('selected_category', $selected_category)
            ->with('selected_variant', $selected_variant)
            ->with('popular_products', $popular_products)
            ->with('categories', $categories)
            ->with('variants', $variants);
        }   
    }

    public function catalogAll()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->where('status', 'Publicado')->paginate(15);

        /* Opciones para Filtro */
        $popular_products = Product::with('category')->where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = Category::with('productsIndex')->where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        return view('front.theme.' . $this->theme->get_name() . '.catalog')
        ->with('products', $products)
        ->with('popular_products', $popular_products)
        ->with('categories', $categories)
        ->with('variants', $variants);
    }

    public function catalog($category_slug)
    {
        $catalog = Category::where('slug', $category_slug)->firstOrFail();

        $products_category = Product::with('category')->where('category_id', $catalog->id)->where('status', 'Publicado')->get();
        $products_subcategory = Product::with('category')->where('status', 'Publicado')->whereHas('subCategory', function($q) use ($catalog){
            $q->where('category_id', $catalog->id);
        })->get();

        $products_merge = $products_category->merge($products_subcategory);
        $products = $products_merge->paginate(15);

        /* Opciones para Filtro */
        $popular_products = Product::with('category')->where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        return view('front.theme.' . $this->theme->get_name() . '.catalog')
        ->with('catalog', $catalog)
        ->with('products', $products)
        ->with('popular_products', $popular_products)
        ->with('categories', $categories)
        ->with('variants', $variants);
    }

    public function detail ($category_slug, $slug)
    {
        $catalog = Category::where('slug', $category_slug)->first();
        $product = Product::where('slug', '=', $slug)->where('status', 'Publicado')->with('category')->firstOrFail();

        $products_selected = Product::with('category')->where('category_id', $catalog->id)->where('slug', '!=' , $product->slug)->where('status', 'Publicado')->inRandomOrder()->take(6)->get();

        $next_product = Product::inRandomOrder()->where('slug', '!=' , $product->slug)->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();
        $last_product = Product::inRandomOrder()->where('slug', '!=' , $product->slug)->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();

        $store_config = $this->store_config;

        if (empty($product)) {
            return redirect()->back();
        }else{
            return view('front.theme.' . $this->theme->get_name() . '.detail')
            ->with('product', $product)
            ->with('products_selected', $products_selected)
            ->with('store_config', $store_config)
            ->with('next_product', $next_product)
            ->with('last_product', $last_product);
        }
    }

    /*
    * Checkout
    * Lógica de carrito, checkout y compra exitosa
    */
    public function cart()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();

        if (empty($store_tax)) {
            $tax_rate = .16;
        }else{
            $tax_rate = ($store_tax->tax_rate)/100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        }else{
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            }else{
                // Reglas especiales
                $shipping_rules = ShipmentMethodRule::where('is_active', true)->first();

                if (!empty($shipping_rules)) {
                    switch ($shipping_rules->type) {
                        case 'Envío Gratis':
                            $count = 0;
                            foreach ($cart->items as $product) {
                                $qty = $product['qty'];
                                $count += $qty;
                            };
                            $count;

                            $operator = $shipping_rules->comparison_operator;
                            $value = $shipping_rules->value;
                            $shipping = $store_shipping->cost;

                            switch ($shipping_rules->condition) {
                                case 'Cantidad Comprada':
                                    switch ($operator) {
                                        case '==':
                                            if ($cart->totalPrice == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($cart->totalPrice != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($cart->totalPrice < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($cart->totalPrice <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($cart->totalPrice > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($cart->totalPrice >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;
                                
                                case 'Productos en carrito':
                                    switch ($operator) {
                                        case '==':
                                            if ($count == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($count != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($count < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($count <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($count > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($count >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;

                                default:
                                    $shipping = $store_shipping->cost;
                                    break;
                            }
                            //
                            break;
                        
                        default:
                            $shipping = $store_shipping->cost;
                            break;
                    }
                }else{
                    $shipping = $store_shipping->cost;
                }
            }
        }

        //$subtotal = ($cart->totalPrice) / ($tax_rate + 1);
        $subtotal = ($cart->totalPrice);
        //$tax = ($cart->totalPrice) * ($tax_rate);
        $tax = 0;
        $total = ($cart->totalPrice + $shipping);

        return view('front.theme.' . $this->theme->get_name() . '.cart')
        ->with('products', $cart->items)
        ->with('total', $total)
        ->with('tax', $tax)
        ->with('shipping', $shipping)
        ->with('subtotal', $subtotal);
    }
    public function checkout()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }
        
        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $event = new FacebookEvents;
            $event->initiateCheckout();
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        
        $payment_methods = PaymentMethod::where('is_active', true)->get();
        $card_payment = PaymentMethod::where('supplier', '!=','Paypal')->where('type', 'card')->where('is_active', true)->first();
        $cash_payment = PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
        $paypal_payment = PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();

        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();

        if (empty($store_tax)) {
            $tax_rate = 0;
        }else{
            $tax_rate = ($store_tax->tax_rate)/100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        }else{
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            }else{
                // Reglas especiales
                $shipping_rules = ShipmentMethodRule::where('is_active', true)->first();

                if (!empty($shipping_rules)) {
                    switch ($shipping_rules->type) {
                        case 'Envío Gratis':
                            $count = 0;
                            foreach ($cart->items as $product) {
                                $qty = $product['qty'];
                                $count += $qty;
                            };
                            $count;

                            $operator = $shipping_rules->comparison_operator;
                            $value = $shipping_rules->value;
                            $shipping = $store_shipping->cost;

                            switch ($shipping_rules->condition) {
                                case 'Cantidad Comprada':
                                    switch ($operator) {
                                        case '==':
                                            if ($cart->totalPrice == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($cart->totalPrice != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($cart->totalPrice < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($cart->totalPrice <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($cart->totalPrice > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($cart->totalPrice >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;
                                
                                case 'Productos en carrito':
                                    switch ($operator) {
                                        case '==':
                                            if ($count == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($count != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($count < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($count <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($count > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($count >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;

                                default:
                                    $shipping = $store_shipping->cost;
                                    break;
                            }
                            //
                            break;
                        
                        default:
                            $shipping = $store_shipping->cost;
                            break;
                    }
                }else{
                    $shipping = $store_shipping->cost;
                }
            }
        }
        
        $tax = ($cart->totalPrice) * ($tax_rate);
        $subtotal = ($cart->totalPrice) / ($tax_rate + 1);
        $total = ($subtotal + $shipping);

        $store_config = $this->store_config;
        $legals = LegalText::all();

        if (!empty($payment_methods)) {
            return view('front.theme.' . $this->theme->get_name() . '.checkout.index')
            ->with('total', $total)
            ->with('payment_methods', $payment_methods)
            ->with('card_payment', $card_payment)
            ->with('cash_payment', $cash_payment)
            ->with('paypal_payment', $paypal_payment)
            ->with('subtotal', $subtotal)
            ->with('tax', $tax)
            ->with('shipping', $shipping)
            ->with('store_tax', $store_tax)
            ->with('products', $cart->items)
            ->with('store_config', $store_config)
            ->with('legals', $legals);
        }else{
            //Session message
            Session::flash('info', 'No se han configurado métodos de pago en esta tienda. Contacta con un administrador de sistema.');

            return redirect()->route('index');
        }
    }

    public function checkoutOld()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }
        
        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $event = new FacebookEvents;
            $event->initiateCheckout();
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        //$total = $cart->totalPrice;
        
        $payment_method = PaymentMethod::where('supplier', '!=', 'Paypal')->where('is_active', true)->where('type', 'card')->first();

        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();

        if (empty($store_tax)) {
            $tax_rate = 0;
        }else{
            $tax_rate = ($store_tax->tax_rate)/100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        }else{
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            }else{
                // Reglas especiales
                $shipping_rules = ShipmentMethodRule::where('is_active', true)->first();

                if (!empty($shipping_rules)) {
                    switch ($shipping_rules->type) {
                        case 'Envío Gratis':
                            $count = 0;
                            foreach ($cart->items as $product) {
                                $qty = $product['qty'];
                                $count += $qty;
                            };
                            $count;

                            $operator = $shipping_rules->comparison_operator;
                            $value = $shipping_rules->value;
                            $shipping = $store_shipping->cost;

                            switch ($shipping_rules->condition) {
                                case 'Cantidad Comprada':
                                    switch ($operator) {
                                        case '==':
                                            if ($cart->totalPrice == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($cart->totalPrice != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($cart->totalPrice < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($cart->totalPrice <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($cart->totalPrice > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($cart->totalPrice >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;
                                
                                case 'Productos en carrito':
                                    switch ($operator) {
                                        case '==':
                                            if ($count == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($count != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($count < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($count <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($count > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($count >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;

                                default:
                                    $shipping = $store_shipping->cost;
                                    break;
                            }
                            //
                            break;
                        
                        default:
                            $shipping = $store_shipping->cost;
                            break;
                    }
                }else{
                    $shipping = $store_shipping->cost;
                }
            }
        }
        
        $tax = ($cart->totalPrice) * ($tax_rate);
        $subtotal = ($cart->totalPrice) / ($tax_rate + 1);
        $total = ($subtotal + $shipping);

        $store_config = $this->store_config;

        if (!empty($payment_method)) {
            if(Auth::check()){
                $user = Auth::user();

                $address = UserAddress::where('user_id', Auth::user()->id)->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.card')
                ->with('total', $total)
                ->with('user', $user)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('store_tax', $store_tax)
                ->with('products', $cart->items)
                ->with('store_config', $store_config);
            }else{
                // COMPRA DE INVITADO
                $count = 0;
                foreach ($cart->items as $product) {
                    $qty = $product['qty'];
                    $count += $qty;
                };
                $count;

                $address = UserAddress::where('user_id', '000998')->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.card')
                ->with('total', $total)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('store_tax', $store_tax)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('products', $cart->items)
                ->with('cart_count', $count)
                ->with('store_config', $store_config);
            }
        }else{
            //Session message
            Session::flash('info', 'No se han configurado metodos de pago en esta tienda. Contacta con un administrador de sistema.');

            return redirect()->route('index');
        }
    }

    public function checkoutCash ()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }
        
        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $event = new FacebookEvents;
            $event->initiateCheckout();
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        //$total = $cart->totalPrice;
        
        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'cash')->first();
        
        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();

        if (empty($store_tax)) {
            $tax_rate = .16;
        }else{
            $tax_rate = ($store_tax->tax_rate)/100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        }else{
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            }else{
                // Reglas especiales
                $shipping_rules = ShipmentMethodRule::where('is_active', true)->first();

                if (!empty($shipping_rules)) {
                    switch ($shipping_rules->type) {
                        case 'Envío Gratis':
                            $count = 0;
                            foreach ($cart->items as $product) {
                                $qty = $product['qty'];
                                $count += $qty;
                            };
                            $count;

                            $operator = $shipping_rules->comparison_operator;
                            $value = $shipping_rules->value;
                            $shipping = $store_shipping->cost;

                            switch ($shipping_rules->condition) {
                                case 'Cantidad Comprada':
                                    switch ($operator) {
                                        case '==':
                                            if ($cart->totalPrice == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($cart->totalPrice != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($cart->totalPrice < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($cart->totalPrice <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($cart->totalPrice > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($cart->totalPrice >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;
                                
                                case 'Productos en carrito':
                                    switch ($operator) {
                                        case '==':
                                            if ($count == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($count != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($count < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($count <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($count > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($count >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;

                                default:
                                    $shipping = $store_shipping->cost;
                                    break;
                            }
                            //
                            break;
                        
                        default:
                            $shipping = $store_shipping->cost;
                            break;
                    }
                }else{
                    $shipping = $store_shipping->cost;
                }
            }
        }
        
        $subtotal = ($cart->totalPrice);
        //$tax = ($cart->totalPrice) * ($tax_rate);
        $tax = 0;
        $total = ($cart->totalPrice + $shipping);
        /*
        $subtotal = ($cart->totalPrice) / ($tax_rate + 1);
        $tax = ($cart->totalPrice) * ($tax_rate);
        */

        $store_config = $this->store_config;

        if (!empty($payment_method)) {
            if(Auth::check()){
                $user = Auth::user();

                $address = UserAddress::where('user_id', Auth::user()->id)->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.cash')
                ->with('total', $total)
                ->with('user', $user)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('store_tax', $store_tax)
                ->with('products', $cart->items)
                ->with('store_config', $store_config);
            }else{
                // COMPRA DE INVITADO
                $count = 0;
                foreach ($cart->items as $product) {
                    $qty = $product['qty'];
                    $count += $qty;
                };
                $count;

                $address = UserAddress::where('user_id', '000998')->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.cash')
                ->with('total', $total)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('store_tax', $store_tax)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('products', $cart->items)
                ->with('cart_count', $count)
                ->with('store_config', $store_config);
            }
        }else{
            //Session message
            Session::flash('info', 'No se han configurado metodos de pago en esta tienda. Contacta con un administrador de sistema.');

            return redirect()->route('index');
        }
    }

    public function checkoutPaypal ()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }
        
        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $event = new FacebookEvents;
            $event->initiateCheckout();
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        
        $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();
        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();

        if (empty($store_tax)) {
            $tax_rate = .16;
        }else{
            $tax_rate = ($store_tax->tax_rate)/100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        }else{
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            }else{
                // Reglas especiales
                $shipping_rules = ShipmentMethodRule::where('is_active', true)->first();

                if (!empty($shipping_rules)) {
                    switch ($shipping_rules->type) {
                        case 'Envío Gratis':
                            $count = 0;
                            foreach ($cart->items as $product) {
                                $qty = $product['qty'];
                                $count += $qty;
                            };
                            $count;

                            $operator = $shipping_rules->comparison_operator;
                            $value = $shipping_rules->value;
                            $shipping = $store_shipping->cost;

                            switch ($shipping_rules->condition) {
                                case 'Cantidad Comprada':
                                    switch ($operator) {
                                        case '==':
                                            if ($cart->totalPrice == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($cart->totalPrice != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($cart->totalPrice < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($cart->totalPrice <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($cart->totalPrice > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($cart->totalPrice >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;
                                
                                case 'Productos en carrito':
                                    switch ($operator) {
                                        case '==':
                                            if ($count == $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '!=':
                                            //dd('la cuenta NO ES IGUAL');
                                            if ($count != $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<':
                                            //dd('la cuenta es MENOR QUE');
                                            if ($count < $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '<=':
                                            //dd('la cuenta es MENOR QUE O IGUAL');
                                            if ($count <= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        case '>':
                                            //dd('la cuenta es MAYOR QUE');
                                            if ($count > $value) {
                                                $shipping = '0';
                                            }
                                            break;
                                        
                                        case '>=':
                                            //dd('la cuenta es MAYOR QUE O IGUAL');
                                            if ($count >= $value) {
                                                $shipping = '0';
                                            }
                                            break;

                                        default:
                                            $shipping = $store_shipping->cost;
                                            break;
                                    }
                                    break;

                                default:
                                    $shipping = $store_shipping->cost;
                                    break;
                            }
                            //
                            break;
                        
                        default:
                            $shipping = $store_shipping->cost;
                            break;
                    }
                }else{
                    $shipping = $store_shipping->cost;
                }
            }
        }
        
        $subtotal = ($cart->totalPrice);
        //$tax = ($cart->totalPrice) * ($tax_rate);
        $tax = 0;
        $total = ($cart->totalPrice + $shipping);
        /*
        $subtotal = ($cart->totalPrice) / ($tax_rate + 1);
        $tax = ($cart->totalPrice) * ($tax_rate);
        */

        $store_config = $this->store_config;

        if (!empty($payment_method)) {
            if(Auth::check()){
                $user = Auth::user();

                $address = UserAddress::where('user_id', Auth::user()->id)->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.paypal')
                ->with('total', $total)
                ->with('user', $user)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('store_tax', $store_tax)
                ->with('products', $cart->items)
                ->with('store_config', $store_config);
            }else{
                // COMPRA DE INVITADO
                $count = 0;
                foreach ($cart->items as $product) {
                    $qty = $product['qty'];
                    $count += $qty;
                };
                $count;

                $address = UserAddress::where('user_id', '000998')->first();

                return view('front.theme.' . $this->theme->get_name() . '.checkout.paypal')
                ->with('total', $total)
                ->with('address', $address)
                ->with('payment_method', $payment_method)
                ->with('store_tax', $store_tax)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('products', $cart->items)
                ->with('cart_count', $count)
                ->with('store_config', $store_config);
            }
        }else{
            //Session message
            Session::flash('info', 'No se han configurado metodos de pago en esta tienda. Contacta con un administrador de sistema.');

            return redirect()->route('index');
        }
    }

    public function postCheckout(Request $request)
    {
        if (!Auth::check()) {
            //Validar
            $this -> validate($request, array(
                'email' => 'unique:users|required|max:255',
            ));
        }

        if (!Session::has('cart')) {
            return redirect()->view('checkout.cart');
        }

        switch ($request->method) {
            case 'Pago con Oxxo':
                $payment_method = PaymentMethod::where('is_active', true)->where('type', 'cash')->first();

                break;
            case 'Pago con Paypal':
                $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();

                break;

            case 'Pago con Tarjeta':
                $payment_method = PaymentMethod::where('supplier', '!=', 'Paypal')->where('is_active', true)->where('type', 'card')->first();
                break;

            default:
                $payment_method = PaymentMethod::where('supplier', '!=', 'Paypal')->where('is_active', true)->where('type', 'card')->first();
                break;
        }

        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
            'last_name' => 'required',
            'phone' => 'required',
            'street' => 'required',
            'street_num' => 'required',
            'suburb' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'references' => 'required'
        ));

        if ($request->method == 'Pago con Tarjeta') {
            $this -> validate($request, array(
                'card_number' => 'required|max:255',
                'card-name' => 'required',
                'card-month' => 'required|max:2',
                'card-year' => 'required|max:4',
                'card-cvc' => 'required|max:4',
            ));
        }

        if ($payment_method->supplier == 'Conekta') {
            require_once(base_path() . '/vendor/conekta/conekta-php/lib/Conekta/Conekta.php');
            \Conekta\Conekta::setApiKey($payment_method->private_key);
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
        }

        if ($payment_method->supplier == 'Stripe') {
            Stripe::setApiKey($payment_method->private_key);
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $products = array();
        $count = 0;
        foreach ($cart->items as $product) {
            $products[$count] = array(
                'name' => $product['item']['name'] .' / Talla: ' . $product['variant'],
                'unit_price' => ($product['price'] . '00') / ($product['qty']),
                'quantity' => $product['qty']
            );

            $count ++;
        }

        $client_name = $request->name . ' ' . $request->last_name;

        switch ($payment_method->supplier) {
            case 'Conekta':
                if ($request->method == 'Pago con Oxxo') {
                    try{
                        $charge = \Conekta\Order::create(
                            array(
                                "line_items" => $products, 

                                "shipping_lines" => array(
                                    array(
                                        "amount" => 0 . '00',
                                        "carrier" => "N/A"
                                    )
                                ),

                                "shipping_contact" => array(
                                    "address" => array(
                                        "street1" => $request->input('street'),
                                        "street2" => $request->input('street_num'),
                                        "postal_code" => $request->input('postal_code'),
                                        "city" => $request->input('city'),
                                        "state" => $request->input('state'),
                                        "country" => $request->input('country')
                                    ),
                                    "phone" => $request->phone,
                                    "receiver" => $client_name,
                                ),

                                "currency" => "MXN",
                                "description" => "Pago de Orden",

                                "customer_info" => array(
                                    'name' => $client_name,
                                    'phone' => $request->phone,
                                    'email' => $request->email
                                ),

                                "charges" => array(
                                    array(
                                        "payment_method" => array(
                                            "type" => "oxxo_cash",
                                            "expires_at" => Carbon::now()->addDays(2)->timestamp,
                                        )
                                    ) 
                                ) 
                            )
                        );
                    } 
                    catch(\Excepton $e) {
                        return redirect()->route('checkout')->with('error', $e->getMessage() );
                    }
                    catch(\Conekta\ParameterValidationError $error){
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage() );
                    } catch (\Conekta\Handler $error){
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage() );
                    }
                }else{
                    try {
                        $charge = \Conekta\Order::create(
                            array(
                                "line_items" => $products,

                                "shipping_lines" => array(
                                    array(
                                        "amount" => 0 . '00',
                                        "carrier" => "N/A"
                                    )
                                ), 

                                "shipping_contact" => array(
                                    "address" => array(
                                        "street1" => $request->input('street'),
                                        "street2" => $request->input('street_num'),
                                        "postal_code" => $request->input('postal_code'),
                                        "city" => $request->input('city'),
                                        "state" => $request->input('state'),
                                        "country" => $request->input('country')
                                    ),
                                    "phone" => $request->phone,
                                    "receiver" => $client_name,
                                ), 

                                "currency" => "MXN",
                                "description" => "Pago de Orden",

                                "customer_info" => array(
                                    'name' => $client_name,
                                    'phone' => $request->phone,
                                    'email' => $request->email
                                ),

                                "charges" => array(
                                    array(
                                        "payment_method" => array(
                                            "type" => "card",
                                            "token_id" => $request->conektaTokenId,
                                        )
                                    )
                                ),
                            )
                        );
                    }catch(\Conekta\ParameterValidationError $error){
                        return redirect()->back()->with('error', $error->getMessage() );
                    }catch (\Conekta\Handler $error){
                        return redirect()->back()->with('error', $error->getMessage() );
                    }
                }

                break;
            
            case 'Stripe':
                try {
                    $charge = Charge::create(array(
                        "amount" => $request->final_total * 100,
                        "currency" => "MXN",
                        "source" => $request->input('stripeToken'), 
                        "description" => "Purchase Successful",
                    ));
                } catch(\Stripe\Exception\CardException $e) {
                    // Error de validaciçon de tarjeta
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                }catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user
                    return redirect()->route('checkout')->with('error', $e->getError()->message);
                }

                break;

            case 'OpenPay':
                try {
                    $openpay = $this->getOpenPayInstance();

                    $customer = array(
                        'name' => $request->name,
                        'last_name' => $request->last_name,
                        'phone_number' => $request->phone,
                        'email' => $request->email,
                        'requires_account' => false
                    );

                    $chargeRequest = array(
                        'method' => 'card',
                        'source_id' => $request->input('openPayToken'),
                        'amount' => $request->final_total,
                        'currency' => 'MXN',
                        'description' => 'Orden en Tienda en Línea',
                        'device_session_id' => $request->device_hidden,
                        'customer' => $customer
                    );

                    $charge = $openpay->charges->create($chargeRequest);

                }catch (OpenpayApiTransactionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                }catch (OpenpayApiRequestError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                }catch (OpenpayApiConnectionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                }catch (OpenpayApiAuthError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                }catch (OpenpayApiError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                }catch(Exception $e) {
                    return redirect()->route('checkout')->with('error', 'Hubo un error. Revisa tu información e intenta de nuevo o ponte en contacto con nosotros.');
                }

                break;

            case 'Paypal':
                try {
                    $instance = $this->getPaypalInstance();

                    $payer = new Payer();
                    $payer->setPaymentMethod('paypal');

                    $amount = new Amount();
                    $amount->setTotal($request->final_total);
                    $amount->setCurrency('MXN');

                    $transaction = new Transaction();
                    $transaction->setAmount($amount);
                    $transaction->setDescription('Compra en tu Tienda en Linea');

                    $callbackUrl = url('/paypal/status');

                    $redirectUrls = new RedirectUrls();
                    $redirectUrls->setReturnUrl($callbackUrl)
                        ->setCancelUrl($callbackUrl);

                    $payment = new Payment();
                    $payment->setIntent('sale')
                        ->setPayer($payer)
                        ->setTransactions(array($transaction))
                        ->setRedirectUrls($redirectUrls);

                    try {
                        $payment->create($instance);
                    } catch (Exception $e) {
                        return redirect()->route('checkout.paypal')->with('error', $e->getMessage() );
                    }
                    
                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');
                    }else{
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();

                    $order->cart = serialize($cart);
                    $order->street = $request->input('street');
                    $order->street_num = $request->input('street_num');
                    //$order->between_streets = $request->input('between_streets');
                    $order->country = $request->input('country');
                    $order->state = $request->input('state');
                    $order->postal_code = $request->input('postal_code');
                    $order->city = $request->input('city');
                    $order->country = $request->input('country');
                    $order->phone = $request->input('phone');
                    $order->suburb = $request->input('suburb');
                    $order->references = $request->input('references');

                    /* Money Info */
                    $order->cart_total = $cart->totalPrice;
                    $order->shipping_rate = $request->shipping_rate;
                    $order->sub_total = $request->sub_total;
                    $order->tax_rate = $request->tax_rate;
                    $order->discounts = $request->discounts;
                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;
                    /*------------*/
                        
                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

                    $order->status = 'Expirado';

                    $order->payment_id = Str::lower($payment->id);   
                    
                    $order->payment_method = $payment_method->supplier;
                    
                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // Enviar al usuario a confirmar su compra en el panel de Paypal
                    return redirect()->away($payment->getApprovalLink());

                } catch (PayPalConnectionException $ex) {
                    echo $ex->getData();
                }

                break;

            default:
                // code...
                break;
        }

        if (!Auth::check()) {
            $user = User::create([
                'name' => $client_name,
                'email' => $request->email,
                'password' => bcrypt('wkshop'),
            ]);

            $user->assignRole('customer');
        }else{
            $user = Auth::user();
        }

        // GUARDAR LA ORDEN
        $order = new Order();

        $order->cart = serialize($cart);
        $order->street = $request->input('street');
        $order->street_num = $request->input('street_num');
        $order->country = $request->input('country');
        $order->state = $request->input('state');
        $order->postal_code = $request->input('postal_code');
        $order->city = $request->input('city');
        $order->country = $request->input('country');
        $order->phone = $request->input('phone');
        $order->suburb = $request->input('suburb');
        $order->references = $request->input('references');

        /* Money Info */
        $order->cart_total = $cart->totalPrice;
        $order->shipping_rate = $request->shipping_rate;
        $order->sub_total = $request->sub_total;
        $order->tax_rate = $request->tax_rate;
        $order->discounts = $request->discounts;
        $order->total = $request->final_total;
        $order->payment_total = $request->final_total;
        /*------------*/
            
        $order->card_digits = Str::substr($request->card_number, 15);
        $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

        if ($payment_method->supplier == 'Paypal') {
            $order->payment_id = $payment->id;
            $order->is_completed = false;
            $order->status = 'Pendiente';
        }else{
            $order->payment_id = $charge->id;
            $order->is_completed = true;
            $order->status = 'Pagado';
        }
        $order->payment_method = $payment_method->supplier;

        // Identificar al usuario para guardar sus datos.
        $user->orders()->save($order);

        // Actualizar existencias del producto
        foreach ($cart->items as $product) {
            if ($product['item']['has_variants'] == true) {
                $variant = Variant::where('value', $product['variant'])->first();
                $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
                
                $product_variant->stock = $product_variant->stock - $product['qty'];
                $product_variant->save();
            }else{
                $product_stock = Product::find($product['item']['id']);

                $product_stock->stock = $product_stock->stock - $product['qty'];
                $product_stock->save();
            }
        }

        // GUARDAR LA DIRECCIÓN
        /*
        $check = UserAddress::where('street', $request->street)->count();

        if ($check == NULL || $check == 0) {
            $address = new UserAddress;
            $address->name = 'Compra_' . substr($charge->id, 0, 3);
            $address->user_id = $user->id;
            $address->street = $request->street;
            $address->street_num = $request->street_num;
            $address->postal_code = $request->postal_code;
            $address->city = $request->city;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->phone = $request->phone;
            $address->suburb = $request->suburb;
            $address->references = $request->references;

            $address->save();
        }
        */
        
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $name = $user->name;
        $email = $user->email;

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;
        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');
        //$logo = asset('assets/img/logo-store.jpg');

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);

        $data = array('order_id' => $order->id, 'user_id' => $user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

        try {
            Mail::send('wecommerce::mail.order_completed', $data, function($message) use($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject
                ('¡Gracias por comprar con nosotros!');
                
                $message->from($sender_email, $store_name);
            });
            
            Mail::send('wecommerce::mail.new_order', $data, function($message) use($sender_email, $store_name, $contact_email){
                $message->to($contact_email, $store_name)->subject
                ('¡Nueva Compra en tu Tienda!');
                
                $message->from($sender_email, $store_name);
            });
        }
        catch (Exception $e) {
            Session::flash('error', 'No se pudo enviar el correo con tu confirmación de orden. Aun asi la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento.');
        }

        $purchase_value = number_format($cart->totalPrice,2);

        // Notificación
        $type = 'Orden';
        $by = $user;
        $data = 'hizo una compra por $' . $purchase_value;

        $this->notification->send($type, $by ,$data);

        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $value = $purchase_value;
            $customer_name = $request->name;
            $customer_lastname = $request->last_name;
            $customer_email = $user->email;
            $customer_phone = $user->name;

            $collection = collect();

            foreach($cart->items as $product){
                $collection = $collection->merge($product['item']['sku']);
            }
            $products_sku = $collection->all();

            $event = new FacebookEvents;
            $event->purchase($products_sku, $value, $customer_email, $customer_name, $customer_lastname, $customer_phone);
        }
        
        Session::forget('cart');
        Session::flash('purchase_complete', 'Compra Exitosa.');

        return redirect()->route('purchase.complete')->with('purchase_value', $purchase_value);        
    }

    public function getOpenPayInstance(){
        $openpay_config = PaymentMethod::where('is_active', true)->where('supplier', 'OpenPay')->first();

        $openpayId = $openpay_config->merchant_id;
        $openpayApiKey = $openpay_config->private_key;
        $openpayProductionMode = env('OPENPAY_PRODUCTION_MODE', true);

        try {
            $openpay = Openpay::getInstance($openpayId, $openpayApiKey, 'MX');
            
            Openpay::setProductionMode($openpayProductionMode);

            return $openpay;

        } catch (OpenpayApiTransactionError $e) {
        error('ERROR en la transacción: ' . $e->getMessage() .
        ' [código de error: ' . $e->getErrorCode() .
        ', categoría de error: ' . $e->getCategory() .
        ', código HTTP: '. $e->getHttpCode() .
        ', id petición: ' . $e->getRequestId() . ']');

        } catch (OpenpayApiRequestError $e) {
            error('ERROR en la petición: ' . $e->getMessage());

        } catch (OpenpayApiConnectionError $e) {
            error('ERROR en la conexión al API: ' . $e->getMessage());

        } catch (OpenpayApiAuthError $e) {
            error('ERROR en la autenticación: ' . $e->getMessage());

        } catch (OpenpayApiError $e) {
            error('ERROR en el API: ' . $e->getMessage());

        } catch (\Exception $e) {
            error('Error en el script: ' . $e->getMessage());
        }

        return null;
    }

    public function getPaypalInstance(){
        $paypal_config = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();
        $config = Config::get('werkn-commerce');

        $api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_config->email_access,
                $paypal_config->password_access
            )
        );

        $api_context->setConfig($config['PAYPAL_SETTINGS']);

        return $api_context;
    }

    public function payPalStatus(Request $request)
    {
        $config = $this->getPaypalInstance();

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            Session::flash('error', 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
            return redirect()->route('checkout.paypal');
        }

        $payment = Payment::get($paymentId, $config);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Ejecutar el Pago **/
        $result = $payment->execute($execution, $config);

        if ($result->getState() === 'approved') {
            $order = Order::where('payment_id', Str::lower($payment->id))->first();
            $order->status = 'Pagado';

            $order->save();

            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
                    
                    $product_variant->stock = $product_variant->stock - $product['qty'];
                    $product_variant->save();
                }else{
                    $product_stock = Product::find($product['item']['id']);

                    $product_stock->stock = $product_stock->stock - $product['qty'];
                    $product_stock->save();
                }
            }

            $mail = MailConfig::first();
            $config = StoreConfig::first();

            $name = $order->user->name;
            $email = $order->user->email;

            $sender_email = $config->sender_email;
            $store_name = $config->store_name;
            $contact_email = $config->contact_email;
            $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');
            //$logo = asset('assets/img/logo-store.jpg');

            config(['mail.driver'=> $mail->mail_driver]);
            config(['mail.host'=>$mail->mail_host]);
            config(['mail.port'=>$mail->mail_port]);   
            config(['mail.username'=>$mail->mail_username]);
            config(['mail.password'=>$mail->mail_password]);
            config(['mail.encryption'=>$mail->mail_encryption]);

            $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

            try {
                Mail::send('wecommerce::mail.order_completed', $data, function($message) use($name, $email, $sender_email, $store_name) {
                    $message->to($email, $name)->subject
                    ('¡Gracias por comprar con nosotros!');
                    
                    $message->from($sender_email, $store_name);
                });
                
                Mail::send('wecommerce::mail.new_order', $data, function($message) use($sender_email, $store_name, $contact_email){
                    $message->to($contact_email, $store_name)->subject
                    ('¡Nueva Compra en tu Tienda!');
                    
                    $message->from($sender_email, $store_name);
                });
            }
            catch (Exception $e) {
                Session::flash('error', 'No se pudo enviar el correo con tu confirmación de orden. Aun asi la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento.');
            }

            $purchase_value = number_format($cart->totalPrice,2);

            // Notificación
            $type = 'Orden';
            $by = $order->user;
            $data = 'hizo una compra por $' . $purchase_value;

            $this->notification->send($type, $by ,$data);

            //Facebook Event
            if ($this->store_config->has_pixel() != NULL) {
                $value = $purchase_value;
                $customer_name = $order->user->name;
                $customer_lastname = $order->user->last_name;
                $customer_email = $order->user->email;
                $customer_phone = $order->user->name;

                $collection = collect();

                foreach($cart->items as $product){
                    $collection = $collection->merge($product['item']['sku']);
                }
                $products_sku = $collection->all();

                $event = new FacebookEvents;
                $event->purchase($products_sku, $value, $customer_email, $customer_name, $customer_lastname, $customer_phone);
            }
            
            Session::forget('cart');
            Session::flash('purchase_complete', 'Compra Exitosa.');

            return redirect()->route('purchase.complete');
        }

        if (isset($paymentId)) {
            $order = Order::where('payment_id', Str::lower($paymentId))->first();
            $order->delete();
        }
        
        // Mensaje de session
        Session::flash('error', 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
        return redirect()->route('checkout.paypal')->with(compact('status'));
    }

    /*
    * Autenticación
    * Esta vista maneja el LOGIN/REGISTRO
    */
    public function auth ()
    {
        return view('front.theme.' . $this->theme->get_name() . '.auth');
    }

    /*
    * Información de Usuario
    * Estas son las vistas del perfil de cliente
    */

    public function profile ()
    {
        $total_orders = Order::where('user_id', Auth::user()->id)->get();

        $orders = Order::where('user_id', Auth::user()->id)->paginate(3);

        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

        $addresses = UserAddress::where('user_id', Auth::user()->id)->get();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.profile')
        ->with('total_orders', $total_orders)
        ->with('orders', $orders)
        ->with('addresses', $addresses);
    }

    public function wishlist ()
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.wishlist')->with('wishlist', $wishlist);
    }

    public function shopping ()
    {
        $total_orders = Order::where('user_id', Auth::user()->id)->get();

        $orders = Order::where('user_id', Auth::user()->id)->paginate(6);

        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        
        return view('front.theme.' . $this->theme->get_name() . '.user_profile.shopping')
        ->with('total_orders', $total_orders)
        ->with('orders', $orders);
    }

    public function address ()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->paginate(10);

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.address', compact('addresses'));
    }

    public function createAddress()
    {
        return view ('front.theme.' . $this->theme->get_name() . 'user-profile.addresses.create');
    }

    public function storeAddress(Request $request)
    {
        // Validate
        $this -> validate($request, array(

        ));

        // Save request in database
        $address = new Address;
        $address->name = $request->name;
        $address->user_id = $request->user_id;
        $address->street = $request->street;
        $address->street_num = $request->street_num;
        $address->between_streets = $request->between_streets;
        $address->postal_code = $request->postal_code;
        $address->city = $request->city;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->phone = $request->phone;
        $address->suburb = $request->suburb;
        $address->references = $request->references;

        $address->save();

        return redirect()->route('address');
    }

    public function editAddress($id)
    {
        $address = UserAddress::find($id);

        return view ('front.theme.' . $this->theme->get_name() . '.user_profile.edit_address')->with('address', $address);
    }

    public function updateAddress(Request $request, $id)
    {
        // Validate
        $this -> validate($request, array(

        ));

        // Save request in database
        $address = UserAddress::find($id);
        $address->name = $request->name;
        $address->user_id = $request->user_id;
        $address->street = $request->street;
        $address->street_num = $request->street_num;
        $address->between_streets = $request->between_streets;
        $address->postal_code = $request->postal_code;
        $address->city = $request->city;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->phone = $request->phone;
        $address->suburb = $request->suburb;
        $address->references = $request->references;

        $address->save();

        return redirect()->route('address');
    }

    public function account ()
    {
        $user = Auth::user();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.account')->with('user', $user);
    }

    public function updateAccount(Request $request, $id)
    {
        // Validar los datos
        $this -> validate($request, array(

        ));

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Mensaje de aviso server-side
        Session::flash('success', 'Tu cuenta se actualizó exitosamente.');

        return redirect()->route('profile');
    }

    /*
    * Extras Front
    * Lógica de cupones
    */

    public function applyCuopon(Request $request){

        $shipping_rules = ShipmentMethodRule::where('is_active', true)->where('allow_coupons', true)->first();

        if (!empty($shipping_rules) || $shipping_rules == NULL) {
            // Recuperar codigo del cupon enviado por AJAX
            $cuopon_code = $request->get('cuopon_code');

            // Recuperar el resto de los datos enviados por AJAX
            $subtotal = $request->get('subtotal');
            $shipping = $request->get('shipping');

            // Obteniendo datos desde el Request enviado por Ajax a esta ruta
            $coupon = Coupon::where('code', $cuopon_code)->first();

            if (empty($coupon)) {
                // Regresar Respuesta a la Vista
                return response()->json(['mensaje' => 'Ese cupón no existe o ya no está disponible. Intenta con otro o contacta con nosotros.', 'type' => 'exception'], 200);
            }else{
                /* Definir Usuario usando el sistema 
                $user = Auth::user();
                /* Contar cuopones usados que compartan el codigo 
                $count_coupons = UserCoupon::where('coupon_id', $coupon->id)->count();
                /* Contar los cupones con el codigo que el usuario haya usado anteriormente 
                $count_user_coupons = UserCoupon::where('user_id', $user->id)->where('coupon_id', $coupon->id)->count();

                /* Revisar si el coupon no ha sobrepasado su limite de uso 
                if ($count_user_coupons < $coupon->usage_limit_per_code) {
                    /* Si no se ha alcanzado el limite de uso de cuopon ejecutar el codigo 
                    if ($count_user_coupons < $coupon->usage_limit_per_user) {
                        // Verificar que el cupon es solo de FREE SHIPPING
                        if ($coupon->qty == 0) {
                            if ($coupon->free_shipping == true) {
                                $free_shipping = $shipping * 0;
                                $discount = 0;

                                // Guardar el uso del cupon por el usuario 
                                $used = new UserCoupon;
                                $used->user_id = Auth::user()->id;
                                $used->coupon_id = $coupon->id;
                                $used->save();

                                return response()->json(['mensaje' => 'Aplicado el descuento correctamente... disfruta', 'discount' => $discount, 'free_shipping' => $free_shipping], 200);
                            }
                        }

                        /* Recuperar el tipo de cupon 
                        $coupon_type = $coupon->type;

                        switch($coupon_type){
                            case 'percentage_amount':
                                // Este cupon resta un porcentaje del subtotal en el checkout
                                $qty = $coupon->qty / 100;
                                $discount = $subtotal * $qty;

                                break;
                            
                            case 'fixed_amount':
                                // Este cupon le resta un valor fijo al subtotal en el checkout
                                $qty = $coupon->qty;
                                $discount = $subtotal - $qty;

                                break;

                            case 'free_shipping':

                                break;

                            default:
                                /* EJECUTAR EXCEPCIÓN SI EL CUPÓN NO TIENE UN TIPO DEFINIDO 
                                return response()->json(['mensaje' => 'Este tipo de cupón no existe, revisa con administración.', 'type' => 'exception'], 200);
                                break;
                        }

                        if ($coupon->is_free_shipping == true) {
                            $free_shipping = $shipping * 0;
                        }else{
                            $free_shipping = $shipping;
                        }

                        // Guardar el uso del cupon por el usuario 
                        $used = new UserCoupon;
                        $used->user_id = Auth::user()->id;
                        $used->coupon_id = $coupon->id;
                        $used->save();
                        // Regresar Respuesta a la Vista
                        return response()->json(['mensaje' => 'Aplicado el descuento correctamente... disfruta', 'discount' => $discount, 'free_shipping' => $free_shipping], 200);

                    /* EJECUTAR EXCEPCIÓN SI EL USUARIO YA ALCANZÓ EL LIMITE   
                    }else{
                        return response()->json(['mensaje' => "Alcanzaste el limite de uso para este cupón. Intenta con otro.", 'type' => 'exception'], 200);
                    }
                /* EJECUTAR EXCEPCIÓN SI EL CUPÓN YA ALCANZÓ EL LIMITE         
                }else{
                    return response()->json(['mensaje' => "Ya no quedan existencias de este cupón. Intenta con otro.", 'type' => 'exception'], 200);
                }
                */

                // Revisión de caducidad
                $end_date = Carbon::parse($coupon->end_date);
                $today = Carbon::today();

                if ($today <= $end_date ) {
                    if ($coupon->exclude_discounted_items == true) {
                        $oldCart = Session::get('cart');
                        $cart = new Cart($oldCart);

                        $subtotal = 0;

                        // Encontrar los productos sin descuentos en el carrito
                        foreach ($cart->items as $product) {
                            if ($product['item']['has_discount'] == false) {
                                $subtotal += $product['item']['price'];
                            } 
                        }

                        $subtotal;

                        if ($subtotal == 0) {
                            // No se puede dar descuento a productos que ya tienen descuento
                            return response()->json(['mensaje' => 'Este cupón no aplica para productos con descuento. Intenta con uno diferente.', 'type' => 'exception'], 200);
                        }
                    }

                    /* Recuperar el tipo de cupon */
                    $coupon_type = $coupon->type;

                    switch($coupon_type){
                        case 'percentage_amount':
                            // Este cupon resta un porcentaje del subtotal en el checkout
                            $qty = $coupon->qty / 100;
                            $discount = $subtotal * $qty;

                            break;
                        
                        case 'fixed_amount':
                            // Este cupon le resta un valor fijo al subtotal en el checkout
                            $qty = $coupon->qty;
                            $discount = $subtotal - $qty;

                            break;

                        case 'free_shipping':

                            break;

                        default:
                            /* EJECUTAR EXCEPCIÓN SI EL CUPÓN NO TIENE UN TIPO DEFINIDO */   
                            return response()->json(['mensaje' => 'Este tipo de cupón no existe, revisa con administración.', 'type' => 'exception'], 200);
                            break;
                    }

                    if ($coupon->is_free_shipping == true) {
                        $free_shipping = $shipping * 0;
                    }else{
                        $free_shipping = $shipping;
                    }

                    // Guardar el uso del cupon por el usuario
                    /*
                    $used = new UserCoupon;
                    $used->user_id = Auth::user()->id;
                    $used->coupon_id = $coupon->id;
                    $used->save();
                    */

                    // Regresar Respuesta a la Vista
                    return response()->json(['mensaje' => 'Aplicado el descuento correctamente a los productos participantes. ¡Disfruta!', 'discount' => $discount, 'free_shipping' => $free_shipping], 200);
                }else{
                    return response()->json(['mensaje' => 'Este cupón caducó y no puede ser usado.', 'type' => 'exception'], 200);
                }
            }
        }else{
            $rule = ShipmentMethodRule::where('is_active', true)->first();
           
            return response()->json(['mensaje' => 'La promoción actual de "' . $rule->type . ' cuando ' . $rule->condition . ' ' . $rule->comparison_operator . ' ' .  number_format($rule->value) . '" en la tienda no admite el uso de cupones.', 'type' => 'exception'], 200);
        }

    }

    public function fetchStates(Request $request)
    {
        $value = $request->get('value');

        return response()->json(StoreState::where('country_code', $value)->get());
    }

    /* XML Feed for Facebook */
    public function xmlFeed()
    {   
        $items = Product::all();
        $config = StoreConfig::first();
        
        return view('wecommerce::feeds.xml')->with('items', $items)->with('config', $config);
    }

    public function legalText($type)
    {
        $text = LegalText::where('type', $type)->first();

        return view('front.theme.' . $this->theme->get_name() . '.legal')->with('text', $text);
    }

    public function purchaseComplete()
    {   
        $store_config = $this->store_config;

        return view('front.theme.' . $this->theme->get_name() . '.purchase_complete')->with('store_config', $store_config);
    }

    public function reduceStock()
    {
        $order = Order::find(16);

        $order->cart = unserialize($order->cart);

        // Actualizar existencias del carrito
        foreach ($order->cart->items as $product) {
            $variant = Variant::where('value', $product['variant'])->first();
            $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
            
            $product_variant->stock = $product_variant->stock - $product['qty'];
            $product_variant->save();
        }

        return redirect()->back();
    }

    public function orderTracking()
    {
        return view('front.theme.' . $this->theme->get_name() . '.order_tracking');
    }

    public function orderTrackingStatus(Request $request)
    {
        $order_id = Str::of($request->order_id)->ltrim('0');

        $user = User::where('email', $request->email)->firstOrFail();
        $order = Order::where('id', $order_id)->where('user_id', $user->id)->first();
        
        if($order == NULL){
            Session::flash('error', 'No hay ninguna orden con ese número asociado con ese cliente.');

            return view('front.theme.' . $this->theme->get_name() . '.order_tracking');
        }else{
            $order->cart = unserialize($order->cart);
            
            return view('front.theme.' . $this->theme->get_name() . '.order_tracking')->with('order', $order);
        }
        
    }
}
