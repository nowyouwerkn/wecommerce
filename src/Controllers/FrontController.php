<?php

namespace Nowyouwerkn\WeCommerce\Controllers;

use App\Http\Controllers\Controller;

use DB;
use Session;
use Auth;
use Image;
use Carbon\Carbon;

/* Stripe Helpers */
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Plan;
use Stripe\Customer;
use Stripe\Subscription;

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

/* Paypal Subscription Models */
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan as PaypalPlan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\ShippingAddress;

/* Openpay Helpers */
use Openpay;
use OpenpayApiError;
use OpenpayApiAuthError;
use OpenpayApiRequestError;
use OpenpayApiConnectionError;
use OpenpayApiTransactionError;

/* MercadoPago Helpers */
use MercadoPago;
use MercadoPago\Payment as MPayment;
use MercadoPago\Annotation\RestMethod;
use MercadoPago\Annotation\RequestParam;
use MercadoPago\Annotation\Attribute;

/* KueskiPay Helpers */
use Illuminate\Support\Facades\Http;

/* E-commerce Models */
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\StoreConfig;
use Nowyouwerkn\WeCommerce\Models\StoreTheme;
use Nowyouwerkn\WeCommerce\Models\MailConfig;
use Nowyouwerkn\WeCommerce\Models\Banner;
use Nowyouwerkn\WeCommerce\Models\Cart;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductRelationship;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Wishlist;
use Nowyouwerkn\WeCommerce\Models\LegalText;
use Nowyouwerkn\WeCommerce\Models\FAQ;
use Nowyouwerkn\WeCommerce\Models\ZipCode;
use Nowyouwerkn\WeCommerce\Models\WatchHistory;

use Nowyouwerkn\WeCommerce\Models\StoreTax;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethod;
use Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule;
use Nowyouwerkn\WeCommerce\Models\ShipmentOption;
use Nowyouwerkn\WeCommerce\Models\SizeChart;
use Nowyouwerkn\WeCommerce\Models\SizeGuide;

/*Newsletter*/
use Nowyouwerkn\WeCommerce\Models\Newsletter;
use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserAddress;
use Nowyouwerkn\WeCommerce\Models\UserInvoice;
use Nowyouwerkn\WeCommerce\Models\UserSubscription;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/* Loyalty system */
use Nowyouwerkn\WeCommerce\Models\UserPoint;
use Nowyouwerkn\WeCommerce\Models\MembershipConfig;

/* Coupon Models */
use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Models\UserCoupon;
use Nowyouwerkn\WeCommerce\Models\CouponExcludedCategory;
use Nowyouwerkn\WeCommerce\Models\CouponExcludedProduct;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/* Facebook Events API Conversion */
use Nowyouwerkn\WeCommerce\Services\FacebookEvents;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    private $notification;
    private $theme;
    private $store_config;

    public function __construct()
    {
        $this->middleware('web');

        $this->notification = new NotificationController;
        $this->theme = new StoreTheme;
        $this->store_config = new StoreConfig;
    }

    public function index()
    {
        $banners = Banner::where('is_active', true)->where('is_promotional', false)->orderBy('priority', 'asc')->orderBy('created_at', 'asc')->get();
        $main_categories = Category::where('parent_id', '0')->orWhere('parent_id', NULL)->orderBy('priority', 'asc')->orderBy('created_at', 'asc')->get(['name', 'slug', 'image'])->take(6);
        $products = Product::where('in_index', true)->where('is_favorite', null)->where('status', 'Publicado')->with('category')->get()->take(8);
        $products_favorites = Product::where('in_index', true)->where('is_favorite', true)->where('status', 'Publicado')->with('category')->get()->take(8);

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

        $selected_gender = $request->gender;
        $selected_brand = $request->brand;
        $selected_materials = $request->materials;
        $selected_color = $request->color;
        $selected_condition = $request->condition;
        $selected_age = $request->age;
        $selected_score = $request->score;

        $query = Product::select('*')->where('status', 'Publicado');

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

        if (isset($selected_gender)) {
            $query->whereIn('gender', $selected_gender);
        }

        if (isset($selected_brand)) {
            $query->whereIn('brand', $selected_brand);
        }

        if (isset($selected_materials)) {
            $query->whereIn('materials', $selected_materials);
        }

        if (isset($selected_color)) {
            $query->whereIn('color', $selected_color);
        }

        if (isset($selected_condition)) {
            $query->whereIn('condition', $selected_condition);
        }

        if (isset($selected_age)) {
            $query->whereIn('age_group', $selected_age);
        }

        if (isset($selected_score)) {
            $query->whereHas('reviews', function ($query) use ($selected_score) {
                $query->whereIn('rating', $selected_score);
            });
        }

        $products = $query->with('category')->paginate(30)->withQueryString();

        /* Opciones para Filtro */
        $popular_products = Product::with('category')->where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = Category::with('productsIndex')->where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        if ($products->count() > 0) {
            return view('front.theme.' . $this->theme->get_name() . '.catalog_filter')
                ->with('products', $products)
                ->with('total_products', $total_products)
                ->with('selected_category', $selected_category)
                ->with('selected_variant', $selected_variant)
                ->with('popular_products', $popular_products)
                ->with('categories', $categories)
                ->with('variants', $variants);
        } else {
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

    public function catalogPromo()
    {
        $today_date = Carbon::today();

        $products = Product::with('category')->orderBy('created_at', 'desc')->where('status', 'Publicado')->where('has_discount', '1')
            ->where('discount_end', '>', $today_date)->paginate(15);

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
        $products_subcategory = Product::with('category')->where('status', 'Publicado')->whereHas('subCategory', function ($q) use ($catalog) {
            $q->where('category_id', $catalog->id);
        })->get();

        $products_merge = $products_category->merge($products_subcategory);
        $products = $products_merge->paginate(15);

        /* Opciones para Filtro */
        $popular_products = Product::with('category')->where('is_favorite', true)->where('status', 'Publicado')->get()->take(9);
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        return view('front.theme.' . $this->theme->get_name() . '.catalog')
            ->with('catalog', $catalog)
            ->with('products', $products)
            ->with('popular_products', $popular_products)
            ->with('categories', $categories)
            ->with('variants', $variants);
    }

    public function catalog_order(Request $request)
    {
        /* Opciones para Filtro */
        $catalog = 'Lo más vendido';

        $filter = $request->filter;

        switch ($request->filter) {
            case 'new':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('created_at', 'desc')->paginate(15);
                $catalog = 'Lo más nuevo';
                break;

            case 'old':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('created_at', 'asc')->paginate(15);
                $catalog = 'Lo más antiguo';
                break;

            case 'price_desc':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('price', 'asc')->paginate(15);
                $catalog = 'Precio menor a mayor';
                break;

            case 'price_asc':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('price', 'desc')->paginate(15);
                $catalog = 'Precio mayor a menor';
                break;

            case 'name_asc':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('name', 'asc')->paginate(15);
                $catalog = 'Alfabéticamente A a Z';
                break;

            case 'name_desc':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('name', 'desc')->paginate(15);
                $catalog = 'Alfabéticamente Z a A';
                break;

            case 'promo':
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('discount_price', 'desc')->paginate(15);
                $catalog = 'Ofertas y descuentos';
                break;

            default:
                $products = Product::with('category')->where('status', 'Publicado')->orderBy('created_at', 'desc')->paginate(15);
                break;
        }

        $categories = Category::with('productsIndex')->where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = Variant::orderBy('value', 'asc')->get(['value']);

        return view('front.theme.' . $this->theme->get_name() . '.catalog_filter')
            ->with('products', $products)
            ->with('categories', $categories)
            ->with('variants', $variants)
            ->with('catalog', $catalog);
    }

    public function detail($category_slug, $slug)
    {
        $catalog = Category::where('slug', $category_slug)->first();
        $product = Product::where('slug', '=', $slug)->where('status', 'Publicado')->with('category')->firstOrFail();

        $products_selected = Product::with('category')->where('category_id', $catalog->id)->where('slug', '!=', $product->slug)->where('status', 'Publicado')->inRandomOrder()->take(6)->get();

        $next_product = Product::where('id', '>', $product->id)->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();
        if ($next_product == null) {
            $next_product = Product::where('id', '<', $product->id)->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();
        }

        $last_product = Product::where('id', '<', $product->id)->orderBy('id', 'desc')->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();
        if ($last_product == null) {
            $last_product = Product::where('id', '>', $product->id)->orderBy('id', 'desc')->where('category_id', $catalog->id)->where('status', 'Publicado')->with('category')->first();
        }

        /* Double Variant System */
        $product_relationships = ProductRelationship::where('base_product_id', $product->id)->orWhere('product_id', $product->id)->get();

        if ($product_relationships->count() == NULL) {
            $base_product = NULL;
            $all_relationships = NULL;
        } else {
            $base_product = $product_relationships->take(1)->first();
            $all_relationships = ProductRelationship::where('base_product_id', $base_product->base_product_id)->get();
        }

        $size_charts = SizeChart::where('category_id', $catalog->id)->get();

        /* Watch History */
        $oldRecommend = Session::has('watch_history') ? Session::get('watch_history') : null;
        $recomendation = new WatchHistory($oldRecommend);
        $recomendation->add($product);
        Session::put('watch_history', $recomendation);

        $store_config = $this->store_config;

        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            if ($product->has_discount == true)
                $value = $product->discount_price;
            else {
                $value = $product->price;
            }
            $product_name = $product->name;
            $product_sku = $product->sku;

            $deduplication_code = md5(rand());

            $event = new FacebookEvents;
            $event->viewContent($value, $product_name, $product_sku, $deduplication_code);
        } else {
            $deduplication_code = NULL;
        }

        $shipment_option = ShipmentOption::where('is_primary', true)->first();

        $kueski_payment = PaymentMethod::where('supplier', 'Kueski')->where('is_active', true)->first();
        $aplazo_payment = PaymentMethod::where('supplier', 'Aplazo')->where('is_active', true)->first();

        if($kueski_payment != NULL){
            $kueski_widget = true;
        }else{
            $kueski_widget = false;
        }

        if($aplazo_payment != NULL){
            $aplazo_widget = true;
        }else{
            $aplazo_widget = false;
        }

        if (empty($product)) {
            return redirect()->back();
        } else {
            return view('front.theme.' . $this->theme->get_name() . '.detail')
                ->with('product', $product)
                ->with('products_selected', $products_selected)
                ->with('store_config', $store_config)
                ->with('next_product', $next_product)
                ->with('size_charts', $size_charts)
                ->with('last_product', $last_product)
                ->with('base_product', $base_product)
                ->with('all_relationships', $all_relationships)
                ->with('deduplication_code', $deduplication_code)
                ->with('shipment_option', $shipment_option)
                ->with('kueski_widget', $kueski_widget)
                ->with('aplazo_widget', $aplazo_widget);
        }
    }

    public function reviewFilter($id, $filter)
    {
        $product = Product::find($id);

        $reviews = $product->approved_reviews()->where('rating', $filter)->get();

        return view('front.theme.' . $this->theme->get_name() . '.review_filter')
            ->with('product', $product)
            ->with('reviews', $reviews);
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
        } else {
            $tax_rate = ($store_tax->tax_rate) / 100;
        }

        // Reglas de Envios
        if (empty($store_shipping)) {
            $shipping = '0';
        } else {
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            } else {
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
                } else {
                    $shipping = $store_shipping->cost;
                }
            }
        }

        $subtotal = ($cart->totalPrice);
        $tax = 0;
        $total = ($cart->totalPrice + $shipping);

        $membership = MembershipConfig::where('is_active', true)->first();

        $points = NULL;
        $available = NULL;
        $used =  NULL;

        if (!empty($membership)) {

            if ($total >= $membership->minimum_purchase) {

                $qty = floor($subtotal / $membership->qty_for_points);

                $points = ($qty * $membership->earned_points);
            } else {
                $points = 0;
            }

            if (!empty(Auth::user())) {
                $available_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
                $used_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'out')->get();

                foreach ($available_points as $a_point) {
                    $available += $a_point->value;
                }

                foreach ($used_points as $u_point) {
                    $used += $u_point->value;
                }

                $valid = $available - $used;
            }
        }

        $shipment_option = ShipmentOption::where('is_primary', true)->first();

        /* SPECIAL PRICE PROMO FUNCTIONALITY */
        $getPromo = Session::get('promo');
        $promo_cta = false;
        $promo_alert = false;

        if($getPromo == 'true'){
            $productCount = 0;

            foreach($cart->items as $cart_product){
                $productCount += $cart_product['qty'];
            }

            /*
            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $subtotal = 1299 * ($productCount / 2);
                    $total = $subtotal;
                } elseif ($productCount % 3 === 0) {
                    // Múltiplo de tres
                    $subtotal = 1799 * ($productCount / 3);
                    $total = $subtotal;
                } else {
                    // No es múltiplo de dos ni de tres
                    $subtotal;
                    $promo_alert = true;
                }
            } else {
                $promo_cta = true;
            }
            */

            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $subtotal = 1299 * ($productCount / 2);
                    $total = $subtotal;
                    $promo_alert = false;
                } else {
                    // No es múltiplo de dos
                    $subtotal;
                    $promo_alert = true;
                }
            } else {
                $promo_cta = true;
            }
        }

        return view('front.theme.' . $this->theme->get_name() . '.cart')
            ->with('products', $cart->items)
            ->with('total', $total)
            ->with('tax', $tax)
            ->with('shipping', $shipping)
            ->with('subtotal', $subtotal)
            ->with('points', $points)
            ->with('promo_cta', $promo_cta)
            ->with('promo_alert', $promo_alert)
            ->with('shipment_option', $shipment_option);
    }

    public function checkout()
    {
        if (!Session::has('cart')) {
            return view('front.theme.' . $this->theme->get_name() . '.cart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $value = $cart->totalPrice;

            $collection = collect();
            $collection_names = collect();

            foreach ($cart->items as $product) {
                $collection = $collection->merge($product['item']['sku']);
            }

            $products_sku = $collection->all();
            $cart_count = count($cart->items);

            //$deduplication_code = md5(rand());

            $event = new FacebookEvents;
            $event->initiateCheckout($value, $products_sku, $cart_count);
        } else {
            //$deduplication_code = NULL;
        }

        $payment_methods = PaymentMethod::where('is_active', true)->get();
        $card_payment = PaymentMethod::where('supplier', '!=', 'Paypal')->where('supplier', '!=', 'MercadoPago')->where('type', 'card')->where('is_active', true)->first();
        $cash_payment = PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
        $paypal_payment = PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();
        $mercado_payment = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();
        $kueski_payment = PaymentMethod::where('supplier', 'Kueski')->where('is_active', true)->first();
        $aplazo_payment = PaymentMethod::where('supplier', 'Aplazo')->where('is_active', true)->first();
        
        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $store_shipping = ShipmentMethod::where('is_active', true)->first();
        $shipment_options = ShipmentOption::where('is_active', true)->orderBy('price', 'asc')->get();

        if (empty($store_tax)) {
            $tax_rate = 0;
            $has_tax = false;
        } else {
            $tax_rate = ($store_tax->tax_rate) / 100 + 1;
            $has_tax = true;
        }

        // Reglas de Envios y Opciones de Envío
        if (empty($store_shipping) or $shipment_options->count() > 0) {
            $shipping = '0';
        } else {
            if ($store_shipping->cost == '0') {
                $shipping = $store_shipping->cost;
            } else {
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
                } else {
                    $shipping = $store_shipping->cost;
                }
            }
        }

        //$shipping = $shipment_option->price;
        $total_cart = $cart->totalPrice;

        $tax = ($total_cart + $shipping) - (($total_cart + $shipping) / $tax_rate);
        $subtotal = ($total_cart + $shipping) - ($tax);
        $total = $subtotal + $tax;

        /*---------------*/
        /*SISTEMA DE LEALTAD*/
        $membership = MembershipConfig::where('is_active', true)->first();

        $points = NULL;
        $available = NULL;
        $point_disc = NULL;
        $valid = NULL;
        if (!empty($membership)) {
            if ($total >= $membership->minimum_purchase) {
                //$points = number_format($total / $membership->qty_for_points);

                $points = floor($total / $membership->qty_for_points) * $membership->earned_points;


                //$points = ($qty * $membership->earned_points);

                //$points = round($total / $membership->qty_for_points, -1, PHP_ROUND_HALF_UP)  * $membership->earned_points;
            } else {
                $points = 0;
            }

            if (!empty(Auth::user())) {

                $available_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
                $used_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'out')->get();

                $used = 0;
                $available = 0;

                foreach ($available_points as $a_points) {
                    $available += $a_points->value;
                }

                foreach ($used_points as $u_point) {
                    $used += $u_point->value;
                }

                $valid = $available - $used;

                $point_disc = $membership->point_value;

                $point_for_order = $total / $point_disc;


                if ($valid >= $membership->max_redeem_points) {

                    $valid = $membership->max_redeem_points;
                } else {
                    $valid = $available - $used;
                }
            }
        }

        $store_config = $this->store_config;
        $legals = LegalText::all();

        /* SPECIAL PRICE PROMO FUNCTIONALITY */
        $getPromo = Session::get('promo');
        $promo_cta = false;
        $promo_alert = false;

        if($getPromo == 'true'){
            $productCount = 0;

            foreach($cart->items as $cart_product){
                $productCount += $cart_product['qty'];
            }

            /*
            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $subtotal = (1299 * ($productCount / 2))  - ($tax);
                    $total =  $subtotal + $tax;
                } elseif ($productCount % 3 === 0) {
                    // Múltiplo de tres
                    $subtotal = (1799 * ($productCount / 3))  - ($tax);;
                    $total =  $subtotal + $tax;
                } else {
                    // No es múltiplo de dos ni de tres
                    $subtotal;
                    $promo_alert = true;
                }
            } else {
                $promo_cta = true;
            }
            */

            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $subtotal = (1299 * ($productCount / 2))  - ($tax);
                    $total = $subtotal + $tax;
                    $promo_alert = false;
                } else {
                    // No es múltiplo de dos
                    $subtotal;
                    $promo_alert = true;
                }
            } else {
                $promo_cta = true;
            }
        }

        if (empty($mercado_payment)) {
            $preference = NULL;
        } else {
            if ($mercado_payment->sandbox_mode == true) {
                $private_key_mercadopago = $mercado_payment->sandbox_private_key;
            } else {
                $private_key_mercadopago = $mercado_payment->private_key;
            }
            MercadoPago\SDK::setAccessToken($private_key_mercadopago);

            // Crear el elemento a pagar
            $item = new MercadoPago\Item();
            $item->title = 'Tu compra desde tu tienda en Linea';
            $item->quantity = 1;
            $item->unit_price = $total;

            // Crear el perfil del comprador
            if (!empty(Auth::user())) {
                $payer = new MercadoPago\Payer();
                $payer->name = Auth::user()->name;
                $payer->email = Auth::user()->email;
            }

            // Crear la preferencia de pago
            $preference = new MercadoPago\Preference();
            $preference->items = array($item);
            if (!empty(Auth::user())) {
                $preference->payer = $payer;
            }

            $preference->back_urls = array(
                "success" => route('purchase.complete'),
                "failure" => route('checkout'),
            );
            $preference->external_reference = "mp_" . Str::random(30);
            $preference->notification_url = route('webhook.order.mercadopago');

            $mercadopago_oxxo = array("id" => $mercado_payment->mercadopago_oxxo);
            $mercadopago_paypal = array("id" => $mercado_payment->mercadopago_paypal);

            $preference->payment_methods = array(
                "excluded_payment_methods" => array(
                    $mercadopago_paypal,
                    $mercadopago_oxxo
                ),
                "excluded_payment_types" => array(
                    array("id" => "ticket", "id" => "atm")
                ),
            );

            $preference->auto_return = "approved";
            $preference->binary_mode = true;

            $preference->save();
        }

        /* Check for physical products in Cart */
        $has_digital_product = false;
        $digital = 0;
        $physical = 0;

        foreach ($cart->items as $product) {
            if ($product['item']['type'] == 'digital') {
                $digital += 1;
            }

            if ($product['item']['type'] == 'physical') {
                $physical += 1;
            }
        }

        if ($digital >= 1 && $physical == 0) {
            $has_digital_product = true;
        }

        if (count($payment_methods) != 0) {
            return view('front.theme.' . $this->theme->get_name() . '.checkout.index')
                ->with('total', $total)
                ->with('points', $points)
                ->with('valid', $valid)
                ->with('point_disc', $point_disc)
                ->with('final_total', $total)
                ->with('payment_methods', $payment_methods)
                ->with('card_payment', $card_payment)
                ->with('cash_payment', $cash_payment)
                ->with('paypal_payment', $paypal_payment)
                ->with('mercado_payment', $mercado_payment)
                ->with('kueski_payment', $kueski_payment)
                ->with('aplazo_payment', $aplazo_payment)
                ->with('shipment_options', $shipment_options)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('shipping', $shipping)
                ->with('store_tax', $store_tax)
                ->with('products', $cart->items)
                ->with('store_config', $store_config)
                ->with('legals', $legals)
                ->with('preference', $preference)
                ->with('promo_cta', $promo_cta)
                ->with('promo_alert', $promo_alert)
                ->with('has_digital_product', $has_digital_product);
        } else {
            //Session message
            Session::flash('info', 'No se han configurado métodos de pago en esta tienda. Contacta con un administrador de sistema.');

            return redirect()->route('index');
        }
    }

    public function checkoutSubscription($subscription_id)
    {
        $subscription = Product::find($subscription_id);
        $membership = MembershipConfig::where('is_active', true)->first();

        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            if ($subscription->has_discount == true) {
                $value = $subscription->discount_price;
            } else {
                $value = $subscription->price;
            }

            $products_sku = $subscription->name;
            $cart_count = 1;

            //$deduplication_code = md5(rand());

            $event = new FacebookEvents;
            $event->initiateCheckout($value, $products_sku, $cart_count);
        } else {
            //$deduplication_code = NULL;
        }

        $payment_methods = PaymentMethod::where('is_active', true)->get();
        $card_payment = PaymentMethod::where('supplier', '!=', 'Paypal')->where('supplier', '!=', 'MercadoPago')->where('type', 'card')->where('is_active', true)->first();
        $cash_payment = PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
        $paypal_payment = PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();
        $mercado_payment = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();

        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();

        if (empty($store_tax)) {
            $tax_rate = 0;
            $has_tax = false;
        } else {
            $tax_rate = ($store_tax->tax_rate) / 100 + 1;
            $has_tax = true;
        }

        if ($subscription->has_discount == true) {
            $total_cart = $subscription->discount_price;
        } else {
            $total_cart = $subscription->price;
        }

        if (empty($store_tax)) {
            $tax = 0;
        } else {
            $tax = ($total_cart) - ($total_cart / $tax_rate);
        }
        $subtotal = ($total_cart) - ($tax);
        $total = $subtotal + $tax;
        /*---------------*/

        /*---------------*/
        /*SISTEMA DE LEALTAD*/
        $membership = MembershipConfig::where('is_active', true)->first();

        $points = NULL;
        $available = NULL;
        $point_disc = NULL;
        $valid = NULL;
        if (!empty($membership)) {
            if ($total >= $membership->minimum_purchase) {
                $points = floor($total / $membership->qty_for_points) * $membership->earned_points;
            } else {
                $points = 0;
            }

            if (!empty(Auth::user())) {

                $available_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
                $used_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'out')->get();

                $used = 0;
                $available = 0;

                foreach ($available_points as $a_points) {
                    $available += $a_points->value;
                }

                foreach ($used_points as $u_point) {
                    $used += $u_point->value;
                }

                $valid = $available - $used;

                $point_disc = $membership->point_value;

                $point_for_order = $total / $point_disc;

                if ($valid >= $membership->max_redeem_points) {

                    $valid = $membership->max_redeem_points;
                } else {
                    $valid = $available - $used;
                }
            }
        }

        $store_config = $this->store_config;
        $legals = LegalText::all();

        /* Variable proviene de API MercadoPago */
        $preference = NULL;

        if (count($payment_methods) != 0) {
            return view('front.theme.' . $this->theme->get_name() . '.checkout.subscription')
                ->with('subscription', $subscription)
                ->with('total', $total)
                ->with('points', $points)
                ->with('valid', $valid)
                ->with('point_disc', $point_disc)
                ->with('final_total', $total)
                ->with('payment_methods', $payment_methods)
                ->with('card_payment', $card_payment)
                ->with('cash_payment', $cash_payment)
                ->with('paypal_payment', $paypal_payment)
                ->with('mercado_payment', $mercado_payment)
                ->with('subtotal', $subtotal)
                ->with('tax', $tax)
                ->with('store_tax', $store_tax)
                ->with('store_config', $store_config)
                ->with('legals', $legals)
                ->with('preference', $preference);
        } else {
            /* Mensaje de Sesión */
            Session::flash('info', 'No se han configurado métodos de pago en esta tienda. Contacta con un administrador de sistema.');
            return redirect()->route('index');
        }
    }

    public function postCheckout(Request $request)
    {
        $currency_value = $this->store_config->get_currency_code();

        $membership = MembershipConfig::where('is_active', true)->first();

        if ($currency_value == '1') {
            $currency_value = 'USD';
        }
        if ($currency_value == '2') {
            $currency_value = 'MXN';
        }

        if (!Auth::check()) {
            $rules = [
                'email' => 'unique:users|required|max:255',
            ];

            $customMessages = [
                'unique' => 'Este correo ya esta registrado en el sistema. ¿Eres tu? Inicia sesión.'
            ];

            //Validar
            $this->validate($request, $rules, $customMessages);
        }

        if (!Session::has('cart')) {
            return redirect()->view('checkout.cart');
        }

        // Validar existencias y estado de producto del carrito
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        foreach ($cart->items as $pr) {
            $product = Product::find($pr['item']['id']);

            if ($product->status == 'Borrador') {
                $cart->deleteItem($pr['item']['id'], $pr['variant']);

                if (count($cart->items) > 0) {
                    Session::put('cart', $cart);
                } else {
                    Session::forget('cart');
                }

                Session::flash('info', 'Disculpa, uno de los productos que querías comprar ya no se encuentra disponible en nuestro sistema. ¡Contacta con nosotros para ayudarte!');

                return redirect()->route('index');
            }

            if ($product->stock == 0) {
                $cart->deleteItem($pr['item']['id'], $pr['variant']);

                if (count($cart->items) > 0) {
                    Session::put('cart', $cart);
                } else {
                    Session::forget('cart');
                }

                Session::flash('info', 'Disculpa, uno de los productos que querías comprar ya no se encuentra disponible en nuestro sistema. ¡Contacta con nosotros para ayudarte!');
                return redirect()->route('index');
            }
        }

        // Selector de métodos de pago
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

            case 'Pago con MercadoPago':
                $payment_method = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->where('type', 'card')->first();

                break;

            case 'Pago con Kueski':
                $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Kueski')->first();

                break;

            case 'Pago con Aplazo':
                $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Aplazo')->first();

                break;
                
            default:
                $payment_method = PaymentMethod::where('supplier', '!=', 'Paypal')->where('is_active', true)->where('type', 'card')->first();
                break;
        }

        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'last_name' => 'required',
            'phone' => 'required',
        ));

        if ($request->method == 'Pago con Tarjeta') {
            if (isset($request->street_billing)) {
                $this->validate($request, array(
                    'card_number' => 'required|max:255',
                    'card-name' => 'required',
                    'card-month' => 'required|max:2',
                    'card-year' => 'required|max:4',
                    'card-cvc' => 'required|max:4',

                    'street_billing' => 'required',
                    'street_num_billing' => 'required',
                    'suburb_billing' => 'required',
                    'postal_code_billing' => 'required',
                    'country_billing' => 'required',
                    'state_billing' => 'required',
                    'city_billing' => 'required',
                ));
            } else {
                $this->validate($request, array(
                    'card_number' => 'required|max:255',
                    'card-name' => 'required',
                    'card-month' => 'required|max:2',
                    'card-year' => 'required|max:4',
                    'card-cvc' => 'required|max:4',
                ));
            }
        }

        if ($payment_method->supplier == 'Conekta') {
            require_once(base_path() . '/vendor/conekta/conekta-php/lib/Conekta/Conekta.php');
            if ($payment_method->sandbox_mode == '1') {
                $private_key_conekta = $payment_method->sandbox_private_key;
            } else {
                $private_key_conekta = $payment_method->private_key;
            }
            \Conekta\Conekta::setApiKey($private_key_conekta);
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
        }

        if ($payment_method->supplier == 'Stripe') {
            if ($payment_method->sandbox_mode == '1') {
                $private_key_stripe = $payment_method->sandbox_private_key;
            } else {
                $private_key_stripe = $payment_method->private_key;
            }
            Stripe::setApiKey($private_key_stripe);
        }

        if ($payment_method->supplier == 'MercadoPago') {
            if ($payment_method->sandbox_mode == '1') {
                $private_key_mercadopago = $payment_method->sandbox_private_key;
            } else {
                $private_key_mercadopago = $payment_method->private_key;
            }
            MercadoPago\SDK::setAccessToken($private_key_mercadopago);
        }

        /* Definición de Opción de Envío */
        $shipment_option = ShipmentOption::where('type', 'pickup')->where('id', $request->shipping_option)->first();

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $products = array();

        /*
        $count = 0;
        foreach ($cart->items as $product) {
            $products[$count] = array(
                'name' => $product['item']['name'] . ' / Talla: ' . $product['variant'],
                'unit_price' => ($product['price'] . '00') / ($product['qty']),
                'quantity' => $product['qty']
            );

            $count++;
        }

        $products[$count++] = array(
            'name' => 'Tarifa de envío',
            'unit_price' => ($request->shipping_rate . '00') ?? '0.00',
            'quantity' => '1'
        );
        */

        $products[0] = array(
            'name' => 'Orden en tu Tienda en Línea',
            'unit_price' => ($request->final_total . '00'),
            'quantity' => '1'
        );

        $client_name = $request->name . ' ' . $request->last_name;

        if (!empty($shipment_option)) {
            // Si el método de envio es de Recolección (pickup)
            $street = 'Tienda';
            $street_num = 'Tienda';
            $country = 'Tienda';
            $state = 'Tienda';
            $postal_code = '37000';
            $city = 'Tienda';
            $phone = 'Tienda';
            $suburb = 'Tienda';
            $references = $shipment_option->name;
        } else {
            //Validar
            $customMessages = [
                'unique' => 'Verifica que tu dirección de envío sea correcta y que esté completa. Puedes crear una nueva directamente desde este formulario.'
            ];

            $this->validate($request, [
                'street' => 'required',
                'street_num' => 'required',
                'suburb' => 'required',
                'postal_code' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'references' => 'required',
            ], [], 
            [
                'street' => 'Nombre de la calle',
                'street_num' => 'Número',
                'suburb' => 'Colonia',
                'postal_code' => 'Código Postal',
                'country' => 'País',
                'state' => 'Estado',
                'city' => 'Ciudad',
                'references' => 'Referencias en Dirección de Envío',
            ]);

            $street = $request->input('street');
            $street_num = $request->input('street_num');
            $country = $request->input('country');
            $state = $request->input('state');
            $postal_code = $request->input('postal_code');
            $city = $request->input('city');
            $phone = $request->input('phone');
            $suburb = $request->input('suburb');
            $references = $request->input('references');
        }

        switch ($payment_method->supplier) {
            case 'Conekta':
                if ($request->method == 'Pago con Oxxo') {
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
                                        "street1" => $street,
                                        "street2" => $street_num,
                                        "postal_code" => $postal_code,
                                        "city" => $city,
                                        "state" => $state,
                                        "country" => $country
                                    ),
                                    "phone" => $request->phone,
                                    "receiver" => $client_name,
                                ),

                                "currency" => $currency_value,
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
                    } catch (\Exception $e) {
                        return redirect()->route('checkout')->with('error', $e->getMessage());
                    } catch (\Conekta\ParameterValidationError $error) {
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage());
                    } catch (\Conekta\Handler $error) {
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage());
                    }
                } else {
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
                                        "street1" => $street,
                                        "street2" => $street_num,
                                        "postal_code" => $postal_code,
                                        "city" => $city,
                                        "state" => $state,
                                        "country" => $country
                                    ),
                                    "phone" => $request->phone,
                                    "receiver" => $client_name,
                                ),

                                "currency" => $currency_value,
                                "description" => "Pago de Orden de tu Tienda en Línea",

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
                    } catch (\Conekta\ParameterValidationError $error) {
                        return redirect()->back()->with('error', $error->getMessage());
                    } catch (\Conekta\Handler $error) {
                        return redirect()->back()->with('error', $error->getMessage());
                    }
                }

                break;

            case 'Stripe':
                try {
                    $charge = Charge::create(array(
                        "amount" => $request->final_total * 100,
                        "currency" => $currency_value,
                        "source" => $request->input('stripeToken'),
                        "description" => "Purchase Successful",
                    ));
                } catch (\Stripe\Exception\CardException $e) {
                    // Error de validaciçon de tarjeta
                    return redirect()->route('checkout')->with('error', $e->getError());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
                    return redirect()->route('checkout')->with('error', $e->getError());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    return redirect()->route('checkout')->with('error', $e->getError());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    return redirect()->route('checkout')->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    return redirect()->route('checkout')->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user
                    return redirect()->route('checkout')->with('error', $e->getError());
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
                        'currency' => $currency_value,
                        'description' => 'Orden en Tienda en Línea',
                        'device_session_id' => $request->device_hidden,
                        'customer' => $customer
                    );

                    $charge = $openpay->charges->create($chargeRequest);
                } catch (OpenpayApiTransactionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiRequestError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiConnectionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiAuthError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (\Exception $e) {
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
                    $amount->setCurrency($currency_value);

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
                    } catch (\Exception $e) {
                        return redirect()->route('checkout')->with('error', $e->getMessage());
                    }

                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'last_name' => $request->last_name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');
                    } else {
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();

                    $order->cart = serialize($cart);
                    $order->street = $street;
                    $order->street_num = $street_num;
                    $order->country = $country;
                    $order->state = $state;
                    $order->postal_code = $postal_code;
                    $order->city = $city;
                    $order->phone = $phone;
                    $order->suburb = $suburb;
                    $order->references = $references;
                    $order->shipping_option = $request->shipping_option;

                    /* Money Info */
                    $order->cart_total = $cart->totalPrice;
                    $order->shipping_rate = str_replace(',', '', $request->shipping_rate);
                    $order->sub_total = str_replace(',', '', $request->sub_total);
                    $order->tax_rate = str_replace(',', '', $request->tax_rate);
                    if (isset($request->discounts)) {
                        $order->discounts = str_replace(',', '', $request->discounts);
                    }


                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;
                    /*------------*/

                    if (isset($billing_shipping_id)) {
                        $order->billing_shipping_id = $billing_shipping_id->id;
                    }

                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

                    $order->status = 'Sin Completar';

                    $order->payment_id = Str::lower($payment->id);
                    $order->payment_method = $payment_method->supplier;

                    //Guadar puntos de salida
                    if (isset($request->points)) {
                        $order->points = $request->points;
                    }

                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // GUARDAR LA DIRECCIÓN
                    if ($request->save_address == 'true') {
                        $check = UserAddress::where('street', $street)->count();

                        if ($check == NULL || $check == 0) {
                            $address = new UserAddress;
                            $address->name = 'Compra_Paypal_' . $order->id;
                            $address->user_id = $user->id;
                            $address->street = $street;
                            $address->street_num = $street_num;
                            $address->postal_code = $postal_code;
                            $address->city = $city;
                            $address->country = $country;
                            $address->state = $state;
                            $address->phone = $phone;
                            $address->suburb = $suburb;
                            $address->references = $references;
                            $address->is_billing = false;

                            $address->save();
                        }
                    }

                    // Enviar al usuario a confirmar su compra en el panel de Paypal
                    return redirect()->away($payment->getApprovalLink());
                } catch (PayPalConnectionException $ex) {
                    echo $ex->getData();
                }

                break;

            case 'MercadoPago':
                try {
                    // PROCESAMIENTO DE ORDEN
                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'last_name' => $request->last_name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');

                        Auth::login($user);
                    } else {
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();

                    $order->cart = serialize($cart);
                    $order->street = $street;
                    $order->street_num = $street_num;
                    $order->country = $country;
                    $order->state = $state;
                    $order->postal_code = $postal_code;
                    $order->city = $city;
                    $order->phone = $phone;
                    $order->suburb = $suburb;
                    $order->references = $references;
                    $order->shipping_option = $request->shipping_option;

                    if (isset($billing_shipping_id)) {
                        $order->billing_shipping_id = $billing_shipping_id->id;
                    }

                    /* Money Info */
                    $order->cart_total = $cart->totalPrice;
                    $order->shipping_rate = str_replace(',', '', $request->shipping_rate);
                    $order->sub_total = str_replace(',', '', $request->sub_total);
                    $order->tax_rate = str_replace(',', '', $request->tax_rate);
                    if (isset($request->discounts)) {
                        $order->discounts = str_replace(',', '', $request->discounts);
                    }
                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;

                    /*------------*/

                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

                    $order->status = 'Sin Completar';

                    $order->payment_id = $request->mp_preference_id;

                    $order->payment_method = $payment_method->supplier;

                    //Guadar puntos de salida
                    if (isset($request->points)) {
                        $order->points = $request->points;
                    }

                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // Enviar al usuario a confirmar su compra en el panel de Mercadopago
                    return redirect()->away($request->mp_preference);
                } catch (\Exception $e) {

                }

                break;

            case 'Kueski':
                $get_order_id = Order::all()->count() + 1;

                /* Formato de Orden */

                $products = array();

                $products[0] = array(
                    'name' => 'Compra desde tu tienda en linea',
                    'description' => 'Sumatoria total de la orden',
                    'price' => $request->final_total,
                    'quantity' => '1',
                    "currency" => "MXN"
                );

                if ($payment_method->sandbox_mode == '1') {
                    $private_key_kueski = $payment_method->sandbox_public_key;
                    $url = "https://testing.kueskipay.com/v1/payments";
                } else {
                    $private_key_kueski = $payment_method->public_key;
                    $url = "https://api.kueskipay.com/v1/payments";
                }

                $api_key = $private_key_kueski;

                $ch = curl_init();

                $fields = array(
                    "order_id" => 'Orden #' . $get_order_id,
                    "description" => "Compra desde tu tienda en linea.",
                    "amount" => array(
                        "total" => $request->final_total,
                        "currency" => "MXN",
                        "details" => array(
                            "subtotal" => str_replace(',', '', $request->sub_total),
                            "shipping" => str_replace(',', '', $request->shipping_rate),
                            "tax" => str_replace(',', '', $request->tax_rate),
                        )
                    ),
                    "items" => $products,
                    "billing" => array(
                        "business" => array(
                            "name" => $client_name . ' ' . $request->last_name,
                        ),
                        "address" => array(
                            "address" => $street,
                            "neighborhood" => $suburb,
                            "city" => $city,
                            "state" => $state,
                            "zipcode" => $postal_code,
                            "country" => "MX"
                        ),
                        "phone_number" => $phone,
                        "email" => $request->email
                    ),
                    "shipping" => array(
                        "name" => array(
                            "name" => $client_name,
                            "last" => $request->last_name
                        ),
                        "address" => array(
                            "address" => $street,
                            "interior" => $street_num,
                            "neighborhood" => $suburb,
                            "city" => $city,
                            "state" => $state,
                            "zipcode" => $postal_code,
                            "country" => "MX"
                        ),
                        "phone_number" => $phone,
                        "email" => $request->email
                    ),
                    "callbacks" => array(
                        "on_success" => route('purchase.complete'),
                        "on_reject" => route('checkout'),
                        "on_canceled" => route('checkout'),
                        "on_failed" => route('checkout')
                    )
                );

                $fields_string = json_encode($fields);
                $header = array();

                $header[] = "Authorization: Bearer " . $api_key;
                $header[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                $result = curl_exec($ch);
                curl_close($ch);

                $kueski_payment = json_decode($result, true);
                //dd($kueski_payment);

                if ($kueski_payment['status'] == "success") {
                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'last_name' => $request->last_name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');
                    } else {
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();

                    $order->cart = serialize($cart);
                    $order->street = $street;
                    $order->street_num = $street_num;
                    $order->country = $country;
                    $order->state = $state;
                    $order->postal_code = $postal_code;
                    $order->city = $city;
                    $order->phone = $phone;
                    $order->suburb = $suburb;
                    $order->references = $references;
                    $order->shipping_option = $request->shipping_option;

                    /* Money Info */
                    $order->cart_total = $cart->totalPrice;
                    $order->shipping_rate = str_replace(',', '', $request->shipping_rate);
                    $order->sub_total = str_replace(',', '', $request->sub_total);
                    $order->tax_rate = str_replace(',', '', $request->tax_rate);
                    if (isset($request->discounts)) {
                        $order->discounts = str_replace(',', '', $request->discounts);
                    }

                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;
                    /*------------*/

                    if (isset($billing_shipping_id)) {
                        $order->billing_shipping_id = $billing_shipping_id->id;
                    }

                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

                    $order->status = 'Sin Completar';

                    $order->payment_id = $kueski_payment['data']['payment_id'];
                    $order->payment_method = $payment_method->supplier;

                    //Guadar puntos de salida
                    if (isset($request->points)) {
                        $order->points = $request->points;
                    }

                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // GUARDAR LA DIRECCIÓN
                    if ($request->save_address == 'true') {
                        $check = UserAddress::where('street', $street)->count();

                        if ($check == NULL || $check == 0) {
                            $address = new UserAddress;
                            $address->name = 'Compra_Kueski' . $order->id;
                            $address->user_id = $user->id;
                            $address->street = $street;
                            $address->street_num = $street_num;
                            $address->postal_code = $postal_code;
                            $address->city = $city;
                            $address->country = $country;
                            $address->state = $state;
                            $address->phone = $phone;
                            $address->suburb = $suburb;
                            $address->references = $references;
                            $address->is_billing = false;

                            $address->save();
                        }
                    }

                    // Enviar al usuario a confirmar su compra en el panel de Kueski
                    return redirect()->away($kueski_payment['data']['callback_url']);
                } else {
                    Session::flash('error', '¡Lo sentimos! El pago a través de Kueski no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
                    return redirect()->route('index');
                }
                break;
            
            case 'Aplazo':
                $order_id = Order::latest()->first();
                $get_order_id = $order_id->id + 1;

                /* Formato de Orden */
                $products = array();

                $products[0] = array(
                    'count' => 1,
                    'description' => "Total de la orden",
                    'id' => 0,
                    'imageUrl' => "",
                    'price' => $request->final_total,
                    'title' => "Compra desde tu tienda en linea."
                );

                if ($payment_method->sandbox_mode == '1') {
                    $private_key_aplazo = $payment_method->sandbox_private_key;
                    $merchant_id = $payment_method->sandbox_merchant_id;
                    $url = "https://api.aplazo.net/api/loan";
                } else {
                    $private_key_aplazo = $payment_method->private_key;
                    $merchant_id = $payment_method->merchant_id;
                    $url = "https://api.aplazo.mx/api/loan";
                }
                
                // Get the Bearer token (you can reuse the function from before)
                $bearerToken = $this->getAplazoToken();

                if ($bearerToken) {
                    // Define the data for the loan request
                    $webHookUrl = route('webhook.aplazo');

                    $fields = array(
                        "buyer" => array(
                            "addressLine" => $street . ' ' . $street_num . ' ' . $suburb . ' ' . $city,
                            "email" => $request->email,
                            "firstName" => $client_name,
                            "lastName" => $request->last_name,
                            "phone" => $phone,
                            "postalCode" => $postal_code
                        ),
                        "cartId" => $get_order_id,
                        "cartUrl" => route('cart'),
                        "discount" => array(
                            "price" => 0,
                            "title" => ""
                        ),
                        "errorUrl" => route('index'),
                        "products" => $products,
                        "shipping" => array(
                            "price" => 0,
                            "title" => ""
                        ),
                        "shopId" => $merchant_id,
                        "successUrl" => route('purchase.complete'),
                        "taxes" => array(
                            "price" => 0,
                            "title" => ""
                        ),
                        "totalPrice" => $request->final_total,
                        "webHookUrl" => $webHookUrl
                    );

                    // Encode the data to JSON
                    $fields_string = json_encode($fields);
                    
                    $ch = curl_init();

                    $header = array();

                    $header[] = "Authorization: " . $bearerToken;
                    $header[] = 'Content-Type: application/json';
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

                    $result = curl_exec($ch);
                    curl_close($ch);
                }else{
                    Session::flash('error', '¡Lo sentimos! El pago a través de Aplazo no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
                    return redirect()->route('index');
                }
                
                $aplazo_payment = json_decode($result, true);

                if (!empty($aplazo_payment)) {
                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'last_name' => $request->last_name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');
                    } else {
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();

                    $order->cart = serialize($cart);
                    $order->street = $street;
                    $order->street_num = $street_num;
                    $order->country = $country;
                    $order->state = $state;
                    $order->postal_code = $postal_code;
                    $order->city = $city;
                    $order->phone = $phone;
                    $order->suburb = $suburb;
                    $order->references = $references;
                    $order->shipping_option = $request->shipping_option;

                    /* Money Info */
                    $order->cart_total = $cart->totalPrice;
                    $order->shipping_rate = str_replace(',', '', $request->shipping_rate);
                    $order->sub_total = str_replace(',', '', $request->sub_total);
                    $order->tax_rate = str_replace(',', '', $request->tax_rate);
                    if (isset($request->discounts)) {
                        $order->discounts = str_replace(',', '', $request->discounts);
                    }

                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;
                    /*------------*/

                    if (isset($billing_shipping_id)) {
                        $order->billing_shipping_id = $billing_shipping_id->id;
                    }

                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');

                    $order->status = 'Prestamo Pendiente';

                    $order->payment_id = $aplazo_payment['loanId'];
                    $order->payment_method = $payment_method->supplier;

                    //Guadar puntos de salida
                    if (isset($request->points)) {
                        $order->points = $request->points;
                    }

                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // GUARDAR LA DIRECCIÓN
                    if ($request->save_address == 'true') {
                        $check = UserAddress::where('street', $street)->count();

                        if ($check == NULL || $check == 0) {
                            $address = new UserAddress;
                            $address->name = 'Compra_Aplazo' . $order->id;
                            $address->user_id = $user->id;
                            $address->street = $street;
                            $address->street_num = $street_num;
                            $address->postal_code = $postal_code;
                            $address->city = $city;
                            $address->country = $country;
                            $address->state = $state;
                            $address->phone = $phone;
                            $address->suburb = $suburb;
                            $address->references = $references;
                            $address->is_billing = false;

                            $address->save();
                        }
                    }

                    // Enviar al usuario a confirmar su compra en el panel de Aplazo
                    return redirect()->away($aplazo_payment['url']);
                } else {
                    Session::flash('error', '¡Lo sentimos! El pago a través de Aplazo no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
                    return redirect()->route('index');
                }
                break;
            default:
                // code...
                break;
        }

        if (!Auth::check()) {
            $user = User::create([
                'name' => $client_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt('wkshop'),
            ]);

            $user->assignRole('customer');
        } else {
            $user = Auth::user();
        }

        // GUARDAR LA DIRECCIÓN
        if ($request->save_address == 'true') {

            $check = UserAddress::where('street', $street)->count();

            if ($check == NULL || $check == 0) {
                $address = new UserAddress;
                $address->name = 'Compra_' . Str::substr($request->card_number, 15);
                $address->user_id = $user->id;
                $address->street = $street;
                $address->street_num = $street_num;
                $address->postal_code = $postal_code;
                $address->city = $city;
                $address->country = $country;
                $address->state = $state;
                $address->phone = $phone;
                $address->suburb = $suburb;
                $address->references = $references;
                $address->is_billing = false;

                $address->save();
            }
        }

        // GUARDAR LA DIRECCIÓN DE FACTURACIÓN
        /*
        if ($request->billing_shipping == 'true') {
            $address = new UserAddress;
            $address->name = 'Compra_tajeta_' . Str::substr($request->card_number, 15);
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
            $address->is_billing = true;
            $address->save();
            $billing_shipping_id = UserAddress::where('street', $request->street)->where('is_billing', true)->where('user_id', $user->id)->first();
        }else{
            $address_billing = new UserAddress;
            $address_billing->name = 'Compra_tajeta_' . Str::substr($request->card_number, 15);
            $address_billing->user_id = $user->id;
            $address_billing->street = $request->street_billing;
            $address_billing->street_num = $request->street_num_billing;
            $address_billing->postal_code = $request->postal_code_billing;
            $address_billing->city = $request->city_billing;
            $address_billing->country = $request->country_billing;
            $address_billing->state = $request->state_billing;
            $address_billing->phone = $request->phone;
            $address_billing->suburb = $request->suburb_billing;
            $address_billing->is_billing = true;
            $address_billing->save();
            $billing_shipping_id = UserAddress::where('street', $request->street_billing)->where('is_billing', true)->where('user_id', $user->id)->first();
        }
        */

        // GUARDAR LA ORDEN
        $order = new Order();

        $order->cart = serialize($cart);
        $order->street = $street;
        $order->street_num = $street_num;
        $order->country = $country;
        $order->state = $state;
        $order->postal_code = $postal_code;
        $order->city = $city;
        $order->phone = $phone;
        $order->suburb = $suburb;
        $order->references = $references;
        $order->shipping_option = $request->shipping_option;

        if (isset($billing_shipping_id)) {
            $order->billing_shipping_id = $billing_shipping_id->id;
        }

        /* Money Info */
        $order->cart_total = $cart->totalPrice;
        $order->shipping_rate = str_replace(',', '', $request->shipping_rate);
        $order->sub_total = str_replace(',', '', $request->sub_total);
        $order->tax_rate = str_replace(',', '', $request->tax_rate);
        if (isset($request->discounts)) {
            $order->discounts = str_replace(',', '', $request->discounts);
        }

        $order->coupon_id = 0;
        $order->total = $request->final_total;
        $order->payment_total = $request->final_total;
        /*------------*/
        $order->card_digits = Str::substr($request->card_number, 15);
        $order->client_name = $request->input('name') . ' ' . $request->input('last_name');
        $order->payment_id = $charge->id;
        $order->is_completed = true;
        $order->status = 'Pagado';
        $order->payment_method = $payment_method->supplier;

        if (isset($request->coupon_code)) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->orderBy('created_at', 'desc')->first();

            if (!empty($coupon)) {
                $order->coupon_id = $coupon->id;

                // Guardar Uso de cupón para el usuario
                $used = new UserCoupon;
                $used->user_id = $user->id;
                $used->coupon_id = $coupon->id;
                $used->save();
            }
        }

        //Guadar puntos de salida
        if (isset($request->points)) {
            $order->points = $request->points;
        }

        // Identificar al usuario para guardar sus datos.
        $user->orders()->save($order);

        //Guadar puntos de salida

        if (!empty($membership)) {
            if (isset($request->points)) {
                $points = new UserPoint();
                $points->type = 'out';
                $points->value = $request->points_to_apply;
                $points->order_id = $order->id;
                $points->user_id = $user->id;

                if ($membership->has_expiration_time == true) {
                    $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                }

                $points->save();
            }
        }

        
        // Actualizar existencias del producto
        foreach ($cart->items as $product) {
            if ($product['item']['has_variants'] == true) {
                // Obtén la variante del producto
                $variant = Variant::where('value', $product['variant'])->first();

                if($variant != NULL){
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

                    /* Proceso de Reducción de Stock */
                    $values = array(
                        'action_by' => $user->id,
                        'initial_value' => $product_variant->stock, 
                        'final_value' => $product_variant->stock - $product['qty'], 
                        'product_id' => $product_variant->id,
                        'created_at' => Carbon::now(),
                    );
    
                    DB::table('inventory_record')->insert($values);
    
                    /* Guardado completo de existencias */
                    $product_variant->stock = $product_variant->stock - $product['qty'];
                    $product_variant->save();
                }else{
                    Log::error('No se encontró la variante de un producto para actualizar las existencias.');
                }
            } else {
                // Para productos sin variantes
                $product_stock = Product::find($product['item']['id']);

                $product_stock->stock = $product_stock->stock - $product['qty'];
                $product_stock->save();
            }
        }

        // Guardar solicitud de factura si es que existe
        if (isset($request->rfc_num)) {
            $invoice = new UserInvoice;

            $invoice->invoice_request_num = Str::slug(substr($request->rfc_num, 0, 4)) . '_' . Str::random(10);
            $invoice->rfc_num = $request->rfc_num;
            $invoice->cfdi_use = $request->cfdi_use;
            $invoice->order_id = $order->id;
            $invoice->user_id = $user->id;
            $invoice->email = $request->email;

            $invoice->save();

            // Notificación
            $type = 'Invoice';
            $by = $user;
            $data = 'Solicitó una factura para la orden: ' . $order->id;
            $model_action = "create";
            $model_id = $invoice->id;

            $this->notification->send($type, $by, $data, $model_action, $model_id);
        }

        // Correo de confirmación de compra
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $name = $user->name;
        $email = $user->email;

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;
        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');

        if (isset($request->shipping_option)) {
            $shipping_id = $request->shipping_option;
        } else {
            $shipping_id = 0;
        }

        //$logo = asset('assets/img/logo-store.jpg');

        config(['mail.driver' => $mail->mail_driver]);
        config(['mail.host' => $mail->mail_host]);
        config(['mail.port' => $mail->mail_port]);
        config(['mail.username' => $mail->mail_username]);
        config(['mail.password' => $mail->mail_password]);
        config(['mail.encryption' => $mail->mail_encryption]);

        $data = array('order_id' => $order->id, 'user_id' => $user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at, 'shipping_id' => $shipping_id);

        try {
            Mail::send('wecommerce::mail.order_completed', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject('¡Gracias por comprar con nosotros!');

                $message->from($sender_email, $store_name);
            });

            Mail::send('wecommerce::mail.new_order', $data, function ($message) use ($sender_email, $store_name, $contact_email) {
                $message->to($contact_email, $store_name)->subject('¡Nueva Compra en tu Tienda!');

                $message->from($sender_email, $store_name);
            });
        } catch (\Exception $e) {
            Session::flash('info', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
        } catch (\Swift_TransportException $e) {
            Session::flash('info', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
        }

        $purchase_value = $cart->totalPrice ?? $request->final_total;

        // Notificación
        $type = 'Orden';
        $by = $user;
        $data = 'hizo una compra por $' . $purchase_value;
        $model_action = "create";
        $model_id = $order->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        //Facebook Event
        if ($this->store_config->has_pixel() != NULL) {
            $value = $purchase_value;
            $customer_name = $request->name;
            $customer_lastname = $request->last_name;
            $customer_email = $user->email;
            $customer_phone = $user->name;

            $collection = collect();

            foreach ($cart->items as $product) {
                $collection = $collection->merge($product['item']['sku']);
            }
            $products_sku = $collection->all();

            $deduplication_code = md5(rand());

            $event = new FacebookEvents;
            $event->purchase($products_sku, $value, $customer_email, $customer_name, $customer_lastname, $customer_phone, $deduplication_code);
        } else {
            $deduplication_code = NULL;
        }

        Session::forget('cart');
        Session::flash('purchase_complete', 'Compra Exitosa.');

        return redirect()->route('purchase.complete')
            ->with('purchase_value', $purchase_value)
            ->with('deduplication_code', $deduplication_code);
    }

    public function postCheckoutSubscription(Request $request, $subscription_id)
    {
        $currency_value = $this->store_config->get_currency_code();

        if ($currency_value == '1') {
            $currency_value = 'USD';
        }
        if ($currency_value == '2') {
            $currency_value = 'MXN';
        }

        if (!Auth::check()) {
            $rules = [
                'email' => 'unique:users|required|max:255',
            ];

            $customMessages = [
                'unique' => 'Este correo ya esta registrado en el sistema. ¿Eres tu? Inicia sesión.'
            ];

            //Validar
            $this->validate($request, $rules, $customMessages);
        }

        // Selector de métodos de pago
        switch ($request->method) {
            case 'Pago con Paypal':
                $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();

                break;

            case 'Pago con Tarjeta':
                $payment_method = PaymentMethod::where('supplier', '!=', 'Paypal')->where('is_active', true)->where('type', 'card')->first();
                break;

            default:
                $payment_method = NULL;
                break;
        }

        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'last_name' => 'required',
            'phone' => 'required',
        ));

        if ($request->method == 'Pago con Tarjeta') {
            if (isset($request->street_billing)) {
                $this->validate($request, array(
                    'card_number' => 'required|max:255',
                    'card-name' => 'required',
                    'card-month' => 'required|max:2',
                    'card-year' => 'required|max:4',
                    'card-cvc' => 'required|max:4',

                    'street_billing' => 'required',
                    'street_num_billing' => 'required',
                    'suburb_billing' => 'required',
                    'postal_code_billing' => 'required',
                    'country_billing' => 'required',
                    'state_billing' => 'required',
                    'city_billing' => 'required',
                ));
            } else {
                $this->validate($request, array(
                    'card_number' => 'required|max:255',
                    'card-name' => 'required',
                    'card-month' => 'required|max:2',
                    'card-year' => 'required|max:4',
                    'card-cvc' => 'required|max:4',
                ));
            }
        }

        if ($payment_method->supplier == 'Conekta') {
            require_once(base_path() . '/vendor/conekta/conekta-php/lib/Conekta/Conekta.php');
            if ($payment_method->sandbox_mode == true) {
                $private_key_conekta = $payment_method->sandbox_private_key;
            } else {
                $private_key_conekta = $payment_method->private_key;
            }
            \Conekta\Conekta::setApiKey($private_key_conekta);
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
        }

        if ($payment_method->supplier == 'Stripe') {
            if ($payment_method->sandbox_mode == true) {
                $private_key_stripe = $payment_method->sandbox_private_key;
            } else {
                $private_key_stripe = $payment_method->private_key;
            }
            Stripe::setApiKey($private_key_stripe);
        }

        /* Información de Compra */
        $product = Product::find($subscription_id);
        $client_name = $request->name . ' ' . $request->last_name;

        switch ($product->payment_frequency) {
            case 'daily':
                $interval = 'day';

                if ($product->time_for_cancellation != NULL) {
                    $cancel_at = Carbon::now()->addDays($product->time_for_cancellation)->getTimestamp();
                }

                break;

            case 'weekly':
                $interval = 'week';
                if ($product->time_for_cancellation != NULL) {
                    $cancel_at = Carbon::now()->addWeeks($product->time_for_cancellation)->getTimestamp();
                }

                break;

            case 'monthly':
                $interval = 'month';
                if ($product->time_for_cancellation != NULL) {
                    $cancel_at = Carbon::now()->addMonths($product->time_for_cancellation)->getTimestamp();
                }

                break;

            case 'annual':
                $interval = 'year';
                if ($product->time_for_cancellation != NULL) {
                    $cancel_at = Carbon::now()->addYears($product->time_for_cancellation)->getTimestamp();
                }

                break;
        }

        switch ($payment_method->supplier) {
            case 'Conekta':
                if ($request->method == 'Pago con Oxxo') {
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
                                        "street1" => $street,
                                        "street2" => $street_num,
                                        "postal_code" => $postal_code,
                                        "city" => $city,
                                        "state" => $state,
                                        "country" => $country
                                    ),
                                    "phone" => $request->phone,
                                    "receiver" => $client_name,
                                ),

                                "currency" => $currency_value,
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
                    } catch (\Exception $e) {
                        return redirect()->route('checkout')->with('error', $e->getMessage());
                    } catch (\Conekta\ParameterValidationError $error) {
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage());
                    } catch (\Conekta\Handler $error) {
                        echo $error->getMessage();
                        return redirect()->back()->with('error', $error->getMessage());
                    }
                } else {
                    try {

                        $plan = \Conekta\Plan::create(
                            array(
                                "name" => $product->name,
                                "amount" => ($product->price * 100),
                                "currency" => "MXN",
                                "interval" => $interval,
                                "frequency" => $product->payment_frequency_qty,
                            )
                        );

                        $client = \Conekta\Customer::create(
                            array(
                                "email" => $request->email,
                                "name" => $client_name,
                                "phone" => $request->phone,
                                "subscription" => array(
                                    array(
                                        "plan" => $plan->name,
                                    )
                                )
                            )
                        );

                        $customer = \Conekta\Customer::find($client->id);

                        $source = $customer->createPaymentSource([
                            "type" => "card",
                            "token_id" => $request->conektaTokenId,
                        ]);

                        $subscription = $customer->createSubscription([
                            "plan_id" => $plan->id,
                            "card_id" => $customer->payment_sources[0]->id,
                        ]);
                    } catch (\Conekta\ParameterValidationError $error) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $error->getMessage());
                    } catch (\Conekta\Handler $error) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $error->getMessage());
                    }
                }

                break;

            case 'Stripe':
                try {
                    $customer = Customer::create(array(
                        "email" => $request->email,
                        "name" => $client_name,
                        'source' => $request->input('stripeToken'),
                    ));

                    $plan = Plan::create(array(
                        "product" => [
                            "name" => $product->name
                        ],
                        "amount" => round($product->price * 100),
                        "currency" => $currency_value,
                        "interval" => $interval,
                        "interval_count" => $product->payment_frequency_qty,
                    ));

                    $subscription = Subscription::create(array(
                        "customer" => $customer->id,
                        "items" => array(
                            array(
                                "plan" => $plan->id,
                            ),
                        ),
                        "cancel_at" => $cancel_at ?? NULL,
                    ));
                } catch (\Stripe\Exception\CardException $e) {
                    // Error de validaciçon de tarjeta
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getError());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getError());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getError());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getError());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user
                    return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getMessage());
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
                        'currency' => $currency_value,
                        'description' => 'Orden en Tienda en Línea',
                        'device_session_id' => $request->device_hidden,
                        'customer' => $customer
                    );

                    $charge = $openpay->charges->create($chargeRequest);
                } catch (OpenpayApiTransactionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiRequestError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiConnectionError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiAuthError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (OpenpayApiError $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage());
                } catch (\Exception $e) {
                    return redirect()->route('checkout')->with('error', 'Hubo un error. Revisa tu información e intenta de nuevo o ponte en contacto con nosotros.');
                }

                break;

            case 'Paypal':
                try {
                    $instance = $this->getPaypalInstance();

                    $plan = new PaypalPlan();

                    $plan
                        ->setName($product->name)
                        ->setDescription($product->description)
                        ->setType('FIXED');

                    // Set billing plan definitions
                    $transaction = new PaymentDefinition();
                    $transaction
                        ->setName($product->name)
                        ->setType('REGULAR')
                        ->setFrequency($interval)
                        ->setFrequencyInterval($product->payment_frequency_qty)
                        ->setCycles($product->time_for_cancellation)
                        ->setAmount(new Currency(array(
                            'value' => $request->final_total,
                            'currency' => $currency_value
                        )));

                    // Set charge models
                    $chargeModel = new ChargeModel();
                    $chargeModel->setType('SHIPPING')->setAmount(new Currency(array(
                        'value' => $request->final_total,
                        'currency' => $currency_value,
                    )));
                    $transaction->setChargeModels(array(
                        $chargeModel
                    ));

                    $callbackUrl = url('/paypal/status');

                    // Set merchant preferences
                    $merchantPreferences = new MerchantPreferences();
                    $merchantPreferences->setReturnUrl($callbackUrl)
                        ->setCancelUrl($callbackUrl)
                        ->setAutoBillAmount('yes')
                        ->setInitialFailAmountAction('CONTINUE')
                        ->setMaxFailAttempts('0')
                        ->setSetupFee(new Currency(array(
                            'value' => $request->final_total,
                            'currency' => $currency_value,
                        )));

                    $plan->setPaymentDefinitions(array(
                        $transaction
                    ));
                    $plan->setMerchantPreferences($merchantPreferences);

                    try {
                        $createdPlan = $plan->create($instance);
                    } catch (PayPal\Exception\PayPalConnectionException $ex) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getData());
                    } catch (\Exception $e) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getData());
                    }

                    try {
                        $patch = new Patch();
                        $value = new PayPalModel('{"state":"ACTIVE"}');
                        $patch->setOp('replace')
                            ->setPath('/')
                            ->setValue($value);
                        $patchRequest = new PatchRequest();
                        $patchRequest->addPatch($patch);
                        $createdPlan->update($patchRequest, $instance);
                        $patchedPlan = PaypalPlan::get($createdPlan->getId(), $instance);

                        // Create new agreement
                        $startDate = date('c', time() + 3600);
                        $agreement = new Agreement();
                        $agreement->setName('Contratación de Suscripción: ' . $product->name)
                            ->setDescription('Esta suscripción se contrató desde tu tienda en linea.')
                            ->setStartDate($startDate);

                        // Set plan id
                        $plan = new PaypalPlan();
                        $plan->setId($patchedPlan->getId());
                        $agreement->setPlan($plan);

                        // Add payer type
                        $payer = new Payer();
                        $payer->setPaymentMethod('paypal');
                        $agreement->setPayer($payer);

                        // Adding shipping details
                        /*
                        $shippingAddress = new ShippingAddress();
                        $shippingAddress->setLine1('111 First Street')
                            ->setCity('Saratoga')
                            ->setState('CA')
                            ->setPostalCode('95070')
                            ->setCountryCode('US');
                        $agreement->setShippingAddress($shippingAddress);
                        */
                        // Create agreement
                        $agreement = $agreement->create($instance);
                    } catch (PayPal\Exception\PayPalConnectionException $ex) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getData());
                    } catch (\Exception $e) {
                        return redirect()->route('checkout.subscription', $product->id)->with('error', $e->getData());
                    }

                    if (!Auth::check()) {
                        $user = User::create([
                            'name' => $client_name,
                            'last_name' => $request->last_name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => bcrypt('wkshop'),
                        ]);

                        $user->assignRole('customer');
                    } else {
                        $user = Auth::user();
                    }

                    // GUARDAR LA ORDEN
                    $order = new Order();
                    $order->type = 'recurring_payment';

                    $order->cart = 'N/A';
                    $order->street = 'N/A';
                    $order->street_num = 'N/A';
                    $order->country = 'N/A';
                    $order->state = 'N/A';
                    $order->postal_code = 'N/A';
                    $order->city = 'N/A';
                    $order->phone = 'N/A';
                    $order->suburb = 'N/A';
                    $order->references = 'N/A';

                    if (isset($billing_shipping_id)) {
                        $order->billing_shipping_id = $billing_shipping_id->id;
                    }

                    /* Money Info */
                    $order->cart_total = $product->price;
                    $order->shipping_rate = '0';
                    $order->sub_total = str_replace(',', '', $request->sub_total);
                    $order->tax_rate = str_replace(',', '', $request->tax_rate);

                    if (isset($request->discounts)) {
                        $order->discounts = str_replace(',', '', $request->discounts);
                    }

                    $order->coupon_id = 0;
                    $order->total = $request->final_total;
                    $order->payment_total = $request->final_total;
                    $order->shipping_option = 0;

                    /*------------*/
                    $order->card_digits = Str::substr($request->card_number, 15);
                    $order->client_name = $request->input('name') . ' ' . $request->input('last_name');
                    $order->payment_id = Str::lower($plan->id);
                    $order->is_completed = true;
                    $order->status = 'Sin Completar';
                    $order->payment_method = $payment_method->supplier;

                    $order->subscription_id = $product->id;
                    $order->subscription_status = false;
                    $order->stripe_subscription_id = Str::lower($plan->id);
                    $order->subscription_period_start = Carbon::now();

                    if (isset($request->coupon_code)) {
                        $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->orderBy('created_at', 'desc')->first();

                        if (!empty($coupon)) {
                            $order->coupon_id = $coupon->id;

                            // Guardar Uso de cupón para el usuario
                            $used = new UserCoupon;
                            $used->user_id = $user->id;
                            $used->coupon_id = $coupon->id;
                            $used->save();
                        }
                    }

                    // Identificar al usuario para guardar sus datos.
                    $user->orders()->save($order);

                    // Enviar al usuario a confirmar su compra en el panel de Paypal
                    return redirect()->away($agreement->getApprovalLink());
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
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt('wkshop'),
            ]);

            $user->assignRole('customer');
        } else {
            $user = Auth::user();
        }

        // Retrieve subscription data
        if ($payment_method->supplier == 'Conekta') {
            if ($subscription->status != 'active') {
                Session::flash('info', 'No se pudo completar tu compra, contacta con tu entidad financiera o intenta con otra tarjeta.');
                return redirect()->back();
            }
        } else {
            $subscription_data = $subscription->jsonSerialize();

            if ($subscription_data['status'] != 'active') {
                Session::flash('info', 'No se pudo completar tu compra, contacta con tu entidad financiera o intenta con otra tarjeta.');
                return redirect()->back();
            }
        }

        // GUARDAR LA ORDEN
        $order = new Order();
        $order->type = 'recurring_payment';

        $order->cart = 'N/A';
        $order->street = 'N/A';
        $order->street_num = 'N/A';
        $order->country = 'N/A';
        $order->state = 'N/A';
        $order->postal_code = 'N/A';
        $order->city = 'N/A';
        $order->phone = 'N/A';
        $order->suburb = 'N/A';
        $order->references = 'N/A';

        if (isset($billing_shipping_id)) {
            $order->billing_shipping_id = $billing_shipping_id->id;
        }

        /* Money Info */
        $order->cart_total = $product->price;
        $order->shipping_rate = '0';
        $order->sub_total = str_replace(',', '', $request->sub_total);
        $order->tax_rate = str_replace(',', '', $request->tax_rate);

        if (isset($request->discounts)) {
            $order->discounts = str_replace(',', '', $request->discounts);
        }

        $order->coupon_id = 0;
        $order->total = $request->final_total;
        $order->payment_total = $request->final_total;
        $order->shipping_option = 0;

        /*------------*/
        $order->card_digits = Str::substr($request->card_number, 15);
        $order->client_name = $request->input('name') . ' ' . $request->input('last_name');
        $order->payment_id = $charge->id ?? $subscription_data['id'] ?? $subscription->id;
        $order->is_completed = true;
        $order->status = 'Pagado';
        $order->payment_method = $payment_method->supplier;

        $order->subscription_id = $product->id;

        /* Stripe Subscription */
        if ($payment_method->supplier == 'Stripe') {
            if ($subscription_data['status'] == 'active') {
                $order->subscription_status = true;
            } else {
                $order->subscription_status = false;
            }

            $order->stripe_subscription_id = $subscription_data['id'];
            $order->stripe_customer_id = $subscription_data['customer'];
            $order->stripe_plan_id = $subscription_data['plan']['id'];
            $order->subscription_period_start = Carbon::createFromTimestamp($subscription_data['current_period_start'])->toDateTimeString();
            $order->subscription_period_end = Carbon::createFromTimestamp($subscription_data['current_period_end'])->toDateTimeString();
        }

        /*Conekta Subscription */
        if ($payment_method->supplier == 'Conekta') {
            if ($subscription->status == 'active') {
                $order->subscription_status = true;
            } else {
                $order->subscription_status = false;
            }

            $order->conekta_subscription_id = $subscription->id;
            $order->customer_id = $subscription->customer->id;
            $order->plan_id = $subscription->plan_id;

            $product->plan_id = $subscription->plan_id;

            $product->save();

            $order->subscription_period_start = Carbon::createFromTimestamp($subscription->billing_cycle_start)->toDateTimeString();
            $order->subscription_period_end = Carbon::createFromTimestamp($subscription->billing_cycle_end)->toDateTimeString();
        }

        if (isset($request->coupon_code)) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->orderBy('created_at', 'desc')->first();

            if (!empty($coupon)) {
                $order->coupon_id = $coupon->id;

                // Guardar Uso de cupón para el usuario
                $used = new UserCoupon;
                $used->user_id = $user->id;
                $used->coupon_id = $coupon->id;
                $used->save();
            }
        }

        // Identificar al usuario para guardar sus datos.
        $user->orders()->save($order);

        // Guardar puntos
        $membership = MembershipConfig::where('is_active', true)->first();
        $available = NULL;
        $used =  NULL;
        if (!empty($membership)) {
            $points = new UserPoint;

            $points->user_id = $order->user_id;
            $points->order_id = $order->id;
            $points->type = 'in';

            //PUNTOS PARA VIP//
            $available_points = UserPoint::where('user_id', $order->user->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
            $used_points = UserPoint::where('user_id', $order->user->id)->where('type', 'out')->get();
            $total_orders = Order::where('user_id', $order->user->id)->get();


            foreach ($available_points as $a_point) {
                $available += $a_point->value;
            }

            foreach ($used_points as $u_point) {
                $used += $u_point->value;
            }

            $valid = $available - $used;

            $type = 'normal';

            if ($membership->on_vip_account == true) {
                if ($membership->has_vip_minimum_points == true && $valid >= $membership->vip_minimum_points) {
                    $type = 'vip_normal';
                }

                if ($membership->has_vip_minimum_orders == true && $total_orders->count() >= $membership->vip_minimum_orders) {
                    $type = 'vip_cool';
                }
            }

            switch ($type) {
                case 'vip_normal':
                    $points->value = floor(($order->total / $membership->qty_for_points) * $membership->points_vip_accounts);
                    break;

                case 'vip_cool':
                    $points->value = floor(($order->total / $membership->qty_for_points) * $membership->points_vip_accounts);
                    break;

                default:
                    $points->value = floor(($order->total / $membership->qty_for_points) * $membership->earned_points);
                    break;
            }


            if ($membership->has_expiration_time == true) {
                $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
            }

            $points->save();
        }

        // Guardar solicitud de factura si es que existe
        if (isset($request->rfc_num)) {
            if ($order != NULL && $user != NULL){
                try {
                    $invoice = new UserInvoice;
    
                    $invoice->invoice_request_num = Str::slug(substr($request->rfc_num, 0, 4)) . '_' . Str::random(10);
                    $invoice->rfc_num = $request->rfc_num;
                    $invoice->cfdi_use = $request->cfdi_use;
                    $invoice->order_id = $order->id;
                    $invoice->user_id = $user->id;
                    $invoice->email = $request->email;
    
                    $invoice->save();
    
                    // Notificación
                    $type = 'Invoice';
                    $by = $user;
                    $data = 'Solicitó una factura para la orden: ' . $order->id;
                    $model_action = "create";
                    $model_id = $invoice->id;
    
                    $this->notification->send($type, $by, $data, $model_action, $model_id);
                } catch (\Exception $e) {
                    Session::flash('info', 'Tu solicitud de factura no pudo ser procesada. Contacta con un agente de soporte para dar seguimiento y solicitar tu factura.');
                }
            }else{
                Session::flash('info', 'Tu solicitud de factura no pudo ser procesada. Contacta con un agente de soporte para dar seguimiento y solicitar tu factura.');
            }
        }

        // Correo de confirmación de compra
        $mail = MailConfig::first();
        $config = StoreConfig::first();

        $name = $user->name;
        $email = $user->email;

        $sender_email = $config->sender_email;
        $store_name = $config->store_name;
        $contact_email = $config->contact_email;
        $logo = asset('themes/' . $this->theme->get_name() . '/img/logo.svg');

        //$logo = asset('assets/img/logo-store.jpg');

        config(['mail.driver' => $mail->mail_driver]);
        config(['mail.host' => $mail->mail_host]);
        config(['mail.port' => $mail->mail_port]);
        config(['mail.username' => $mail->mail_username]);
        config(['mail.password' => $mail->mail_password]);
        config(['mail.encryption' => $mail->mail_encryption]);

        $data = array('order_id' => $order->id, 'user_id' => $user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

        try {
            Mail::send('wecommerce::mail.order_completed', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                $message->to($email, $name)->subject('¡Gracias por comprar con nosotros!');

                $message->from($sender_email, $store_name);
            });

            Mail::send('wecommerce::mail.new_order', $data, function ($message) use ($sender_email, $store_name, $contact_email) {
                $message->to($contact_email, $store_name)->subject('¡Nueva Compra en tu Tienda!');

                $message->from($sender_email, $store_name);
            });
        } catch (\Exception $e) {
            Session::flash('info', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
        } catch (\Swift_TransportException $e) {
            Session::flash('info', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
        }

        $purchase_value = $product->price;

        // Notificación
        $type = 'Orden';
        $by = $user;
        $data = 'hizo una compra por $' . $purchase_value;
        $model_action = "create";
        $model_id = $order->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        //Facebook Event
        $deduplication_code = NULL;

        Session::forget('cart');
        Session::flash('purchase_complete', 'Compra Exitosa.');

        return redirect()->route('purchase.complete')
            ->with('purchase_value', $purchase_value)
            ->with('deduplication_code', $deduplication_code);
    }

    public function getOpenPayInstance()
    {
        $openpay_config = PaymentMethod::where('is_active', true)->where('supplier', 'OpenPay')->first();

        $openpayId = $openpay_config->merchant_id;

        if ($openpay_config->sandbox_mode == '1') {
            $private_key_openpay = $openpay_config->sandbox_private_key;
            $productionmode = false;
        } elseif ($openpay_config->sandbox_mode == '0') {
            $private_key_openpay = $openpay_config->private_key;
            $productionmode = true;
        }

        $openpayApiKey = $private_key_openpay;
        $openpayProductionMode = env('OPENPAY_PRODUCTION_MODE', $productionmode);

        try {
            $openpay = Openpay::getInstance($openpayId, $openpayApiKey, 'MX');

            Openpay::setProductionMode($openpayProductionMode);

            return $openpay;
        } catch (OpenpayApiTransactionError $e) {
            error('ERROR en la transacción: ' . $e->getMessage() .
                ' [código de error: ' . $e->getErrorCode() .
                ', categoría de error: ' . $e->getCategory() .
                ', código HTTP: ' . $e->getHttpCode() .
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

    public function getPaypalInstance()
    {
        $paypal_config = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();
        $config = Config::get('werkn-commerce');

        if ($paypal_config->sandbox_mode == '1') {
            $paypal_email_access = $paypal_config->sandbox_email_access;
            $paypal_password_access = $paypal_config->sandbox_password_access;
        } elseif ($paypal_config->sandbox_mode == '0') {
            $paypal_email_access = $paypal_config->email_access;
            $paypal_password_access = $paypal_config->password_access;
        }

        $api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_email_access,
                $paypal_password_access
            )
        );

        $api_context->setConfig($config['PAYPAL_SETTINGS']);

        return $api_context;
    }

    public function payPalStatus(Request $request)
    {
        $membership = MembershipConfig::where('is_active', true)->first();

        $config = $this->getPaypalInstance();

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            Session::flash('error', 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
            return redirect()->route('index');
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

            if (!empty($membership)) {
                if (!empty($order->points)) {
                    $points = new UserPoint();
                    $points->type = 'out';
                    $points->value = $order->points;
                    $points->order_id = $order->id;
                    $points->user_id = $order->user_id;

                    if ($membership->has_expiration_time == true) {
                        $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                    }

                    $points->save();
                }
            }

            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            // Actualizar existencias del producto
            foreach ($cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

                    /* Proceso de Reducción de Stock */
                    $values = array(
                        'action_by' => $order->user_id,
                        'initial_value' => $product_variant->stock, 
                        'final_value' => $product_variant->stock - $product['qty'], 
                        'product_id' => $product_variant->id,
                        'created_at' => Carbon::now(),
                    );

                    DB::table('inventory_record')->insert($values);

                    /* Guardado completo de existencias */
                    $product_variant->stock = $product_variant->stock - $product['qty'];
                    $product_variant->save();
                } else {
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

            config(['mail.driver' => $mail->mail_driver]);
            config(['mail.host' => $mail->mail_host]);
            config(['mail.port' => $mail->mail_port]);
            config(['mail.username' => $mail->mail_username]);
            config(['mail.password' => $mail->mail_password]);
            config(['mail.encryption' => $mail->mail_encryption]);

            $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at);

            try {
                Mail::send('wecommerce::mail.order_completed', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                    $message->to($email, $name)->subject('¡Gracias por comprar con nosotros!');

                    $message->from($sender_email, $store_name);
                });

                Mail::send('wecommerce::mail.new_order', $data, function ($message) use ($sender_email, $store_name, $contact_email) {
                    $message->to($contact_email, $store_name)->subject('¡Nueva Compra en tu Tienda!');

                    $message->from($sender_email, $store_name);
                });
            } catch (\Exception $e) {
                Session::flash('error', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
            } catch (\Swift_TransportException $e) {
                Session::flash('info', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
            }

            $purchase_value = $cart->totalPrice;

            // Notificación
            $type = 'Orden';
            $by = $order->user;
            $data = 'hizo una compra por $' . $purchase_value;
            $model_action = "create";
            $model_id = "";

            $this->notification->send($type, $by, $data, $model_action, $model_id);

            //Facebook Event
            if ($this->store_config->has_pixel() != NULL) {
                $value = $purchase_value;
                $customer_name = $request->name;
                $customer_lastname = $request->last_name;
                $customer_email = $order->user->email;
                $customer_phone = $order->user->name;

                $collection = collect();

                foreach ($cart->items as $product) {
                    $collection = $collection->merge($product['item']['sku']);
                }
                $products_sku = $collection->all();

                $deduplication_code = md5(rand());

                $event = new FacebookEvents;
                $event->purchase($products_sku, $value, $customer_email, $customer_name, $customer_lastname, $customer_phone, $deduplication_code);
            } else {
                $deduplication_code = NULL;
            }

            Session::forget('cart');
            Session::flash('purchase_complete', 'Compra Exitosa.');

            return redirect()->route('purchase.complete')
                ->with('deduplication_code', $deduplication_code);
        }

        if (isset($paymentId)) {
            $order = Order::where('payment_id', Str::lower($paymentId))->first();
            $order->delete();
        }

        // Mensaje de session
        Session::flash('error', 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Inténtalo nuevamente o usa otro método de pago. Contacta con nosotros si tienes alguna pregunta.');
        return redirect()->route('checkout.paypal')->with(compact('status'));
    }

    public function getAplazoToken()
    {
        $payment_method = PaymentMethod::where('is_active', true)->where('supplier', 'Aplazo')->first();

        if ($payment_method->sandbox_mode == '1') {
            $private_key_aplazo = $payment_method->sandbox_private_key;
            $merchant_id = $payment_method->sandbox_merchant_id;
            $url = "https://api.aplazo.net/api/auth";
        } else {
            $private_key_aplazo = $payment_method->private_key;
            $merchant_id = $payment_method->merchant_id;
            $url = "https://api.aplazo.mx/api/auth";
        }

        // Fields that will be sent in the body of the request
        $fields = [
            'apiToken' => $private_key_aplazo,
            'merchantId' => $merchant_id             
        ];
        
        // Encoding the data to JSON
        $fields_string = json_encode($fields);
        
        // Initialize cURL
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        
        // Execute cURL
        $result = curl_exec($ch);
        
        // Close cURL
        curl_close($ch);
        
        // Decode the result to get the bearer token
        $response = json_decode($result, true);
        
        if (isset($response['Authorization'])) {
            // Return the token or save it for future use
            return $response['Authorization'];
        }
        
        return null; // Handle the error case
    }

    /*
    * Autenticación
    * Esta vista maneja el LOGIN/REGISTRO
    */
    public function auth()
    {
        return view('front.theme.' . $this->theme->get_name() . '.auth');
    }

    /*
    * Información de Usuario
    * Estas son las vistas del perfil de cliente
    */
    public function profile()
    {
        $total_orders = Order::where('user_id', Auth::user()->id)->get();

        $orders = Order::where('user_id', Auth::user()->id)->paginate(4);
        /*
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        */

        /*SISTEMA DE LEALTAD*/
        $membership = MembershipConfig::where('is_active', true)->first();

        $available_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
        $used_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'out')->get();

        $addresses = UserAddress::where('user_id', Auth::user()->id)->where('is_billing', false)->get();

        $valid = NULL;
        $vip_status = NULL;
        $last_points = NULL;

        if (!empty($membership)) {

            $last_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->get()->last();
            $used = 0;
            $available = 0;

            foreach ($available_points as $a_point) {
                $available += $a_point->value;
            }

            foreach ($used_points as $u_point) {
                $used += $u_point->value;
            }

            $valid = $available - $used;
            $vip_status = false;

            if ($membership->vip_clients == true && $valid >= $membership->vip_minimum_points) {
                $vip_status = true;
            }

            if ($membership->vip_clients == true && $orders->count() >= $membership->vip_minimum_orders) {
                $vip_status = true;
            }
        }

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.profile')
            ->with('total_orders', $total_orders)
            ->with('orders', $orders)
            ->with('last_points', $last_points)
            ->with('valid', $valid)
            ->with('vip_status', $vip_status)
            ->with('addresses', $addresses);
    }

    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.wishlist')->with('wishlist', $wishlist);
    }

    public function shopping()
    {
        $total_orders = Order::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->paginate(6);

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.shopping')
            ->with('total_orders', $total_orders)
            ->with('orders', $orders);
    }

    public function points()
    {
        /*SISTEMA DE LEALTAD*/
        $membership = MembershipConfig::where('is_active', true)->first();

        $all_points = NULL;
        $pending = NULL;
        $pending_orders = NULL;
        $available = NULL;
        $used =  NULL;
        $used_points =  NULL;
        $last_points =  NULL;

        if (!empty($membership)) {
            $available_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->where('valid_until', '>=', Carbon::now())->get();
            $used_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'out')->get();
            $orders = Order::where('user_id', Auth::user()->id)->paginate(6);
            $all_points = UserPoint::where('user_id', Auth::user()->id)->get();

            $last_points = UserPoint::where('user_id', Auth::user()->id)->where('type', 'in')->get()->last();

            $minimum = $membership->minimum_purchase;

            $pending_orders = Order::where('user_id', Auth::user()->id)
                ->where('payment_total', '>=', $minimum)
                ->where(function ($query) {
                    $query->where('status', 'Pagado')
                        ->orWhere('status', 'Empaquetado')
                        ->orWhere('status', 'Enviado');
                })
                ->get();

            foreach ($available_points as $a_point) {
                $available += $a_point->value;
            }

            foreach ($used_points as $u_point) {
                $used += $u_point->value;
            }

            $valid = $available - $used;

            $pending = 0;

            foreach ($pending_orders as $p_points) {
                $pending += floor(($p_points->total / $membership->qty_for_points) * $membership->earned_points);
            }
        }

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.points')
            ->with('all_points', $all_points)
            ->with('available', $available)
            ->with('membership', $membership)
            ->with('used_points', $used_points)
            ->with('last_points', $last_points)
            ->with('pending', $pending)
            ->with('pending_orders', $pending_orders);
    }

    public function invoiceRequest(Request $request, $order_id, $user_id)
    {
        //Validation
        $this->validate($request, array(
            'rfc_num' => 'required|max:255',
            'cfdi_use' => 'required|max:255',
        ));

        // Guardar solicitud de factura si es que existe
        $invoice = new UserInvoice;

        $invoice->invoice_request_num = Str::slug(substr($request->rfc_num, 0, 4)) . '_' . Str::random(10);
        $invoice->rfc_num = $request->rfc_num;
        $invoice->cfdi_use = $request->cfdi_use;

        $invoice->order_id = $order_id;
        $invoice->user_id = $user_id;
        $invoice->email = $request->email;

        $invoice->save();

        // Notificación
        $type = 'Invoice';
        $by = Auth::user();
        $data = 'Solicitó una factura para la orden: ' . $invoice->order->id;
        $model_action = "create";
        $model_id = $invoice->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        //Session message
        Session::flash('success', 'Tu solicitud de factura fue guardada exitosamente. La procesaremos y te enviaremos los archivos a tu correo electrónico.');

        return redirect()->back();
    }

    public function address()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->where('is_billing', false)->paginate(10);

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.address', compact('addresses'));
    }

    public function createAddress()
    {
        return view('front.theme.' . $this->theme->get_name() . 'user-profile.addresses.create');
    }

    public function storeAddress(Request $request)
    {
        // Validate
        $this->validate($request, array(
            'user_id' => 'required',
            'street' => 'required',
            'street_num' => 'required',
            'postal_code' => 'required',
            'suburb' => 'required',
        ));

        // Save request in database
        $address = new UserAddress;
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
        $address->is_billing = false;
        $address->save();

        return redirect()->back();
    }

    public function editAddress($id)
    {
        $address = UserAddress::find($id);

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.edit_address')->with('address', $address);
    }

    public function updateAddress(Request $request, $id)
    {
        // Validate
        $this->validate($request, array(
            'user_id' => 'required',
            'street' => 'required',
            'street_num' => 'required',
            'postal_code' => 'required',
            'suburb' => 'required',
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

    public function destroyAddress($id)
    {
        // Save request in database
        $address = UserAddress::find($id);
        $address->delete();

        return redirect()->route('address');
    }

    public function account()
    {
        $user = Auth::user();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.account')->with('user', $user);
    }

    public function updateAccount(Request $request, $id)
    {
        // Validar los datos
        $this->validate($request, array(
            'name' => 'required',
        ));

        $user = User::find($id);

        $user->name = $request->input('name');

        $user->last_name = $request->lastname;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;

        if (isset($request->password)) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Mensaje de aviso server-side
        Session::flash('success', 'Tu cuenta se actualizó exitosamente.');

        return redirect()->route('profile');
    }

    public function editImage()
    {
        $user = Auth::user();

        return view('front.theme.' . $this->theme->get_name() . '.user_profile.image')->with('user', $user);
    }

    public function updateImage(Request $request, $id)
    {
        $this->validate($request, array());

        $user = User::find($id);
        //$user->image = $request->user_imagen;

        if ($request->hasFile('user_image')) {
            $user_image = $request->file('user_image');
            $filename = 'user_img' . time() . '.' . $user_image->getClientOriginalExtension();
            $location = public_path('img/users/' . $filename);

            Image::make($user_image)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);

            $user->image = $filename;
        }

        $user->save();

        Session::flash('success', 'Tu imagen de perfil se actualizó exitosamente.');

        return redirect()->route('profile');
    }

    /*
    * Extras Front
    * Lógica de cupones
    */
    public function applyCuopon(Request $request)
    {
        $shipping_rules = ShipmentMethodRule::where('is_active', true)->where('allow_coupons', true)->first();

        if (!empty($shipping_rules) || $shipping_rules == NULL) {
            // Recuperar codigo del cupon enviado por AJAX
            $coupon_code = $request->get('coupon_code');

            // Recuperar el resto de los datos enviados por AJAX
            $subtotal = floatval(preg_replace("/[^-0-9\.]/", "", $request->get('subtotal')));

            if ($request->get('shipping') != NULL) {
                $shipping = floatval(preg_replace("/[^-0-9\.]/", "", $request->get('shipping')));
            } else {
                $shipping = 0;
            }

            // Obteniendo datos desde el Request enviado por Ajax a esta ruta
            $coupon = Coupon::where('code', $coupon_code)->first();

            if (empty($coupon)) {
                // Regresar Respuesta a la Vista
                return response()->json(['mensaje' => 'Ese cupón no existe o ya no está disponible. Intenta con otro o contacta con nosotros.', 'type' => 'exception'], 200);
            } else {
                /* Definir Usuario usando el sistema */
                $user = User::where('email', $request->user_email)->first();

                if (!empty($user)) {
                    /* Contar cuopones usados que compartan el codigo */
                    $count_coupons = UserCoupon::where('coupon_id', $coupon->id)->count();

                    /* Contar los cupones con el codigo que el usuario haya usado anteriormente */
                    $count_user_coupons = UserCoupon::where('user_id', $user->id)->where('coupon_id', $coupon->id)->count();

                    /* Revisar si el coupon ha sobrepasado su limite de uso */
                    if ($count_coupons >= $coupon->usage_limit_per_code) {
                        return response()->json(['mensaje' => "Ya no quedan existencias de este cupón. Intenta con otro.", 'type' => 'exception'], 200);
                    }

                    if ($count_user_coupons >= $coupon->usage_limit_per_user) {
                        return response()->json(['mensaje' => "Alcanzaste el limite de uso para este cupón. Intenta con otro.", 'type' => 'exception'], 200);
                    }
                }

                // Revisión de caducidad
                if ($coupon->end_date == null) {
                    $end_date = 0;
                } else {
                    $end_date = Carbon::parse($coupon->end_date);
                }

                $today = Carbon::today();

                if ($today <= $end_date || $end_date == 0) {
                    /* Si está activa la opcion; revisar si existen productos con descuento en el carrito */
                    if ($coupon->exclude_discounted_items == true) {
                        $oldCart = Session::get('cart');
                        $cart = new Cart($oldCart);

                        $disc_subtotal = 0;

                        // Encontrar los productos sin descuentos en el carrito
                        foreach ($cart->items as $product) {
                            if ($product['item']['has_discount'] == false) {
                                $disc_subtotal += $product['item']['price'];
                            }
                        }

                        $disc_subtotal;

                        if ($disc_subtotal == 0) {
                            // No se puede dar descuento a productos que ya tienen descuento
                            return response()->json(['mensaje' => 'Este cupón no aplica para productos con descuento. Intenta con uno diferente.', 'type' => 'exception'], 200);
                        }
                    }

                    /* Si existen exclusiones de categoría; revisar si existen productos con esa categoría en el carrito */
                    $excluded_categories = CouponExcludedCategory::where('coupon_id', $coupon->id)->get();
                    if ($excluded_categories->count() != 0) {
                        $oldCart = Session::get('cart');
                        $cart = new Cart($oldCart);

                        $exc_categories = 0;

                        foreach ($excluded_categories as $exc_cat) {
                            if ($cart->items != NULL) {
                                // Encontrar los productos con la misma categoria excluida en el carrito
                                foreach ($cart->items as $product) {
                                    if ($product['item']['category_id'] == $exc_cat->category_id) {
                                        $exc_categories++;
                                    }
                                }
                            }
                        }

                        if ($exc_categories != 0) {
                            // No se puede dar descuento a productos que ya tienen descuento
                            return response()->json(['mensaje' => 'Este cupón no aplica para esta categoría de productos. Revisa las condiciones de tu cupón e intenta nuevamente.', 'type' => 'exception'], 200);
                        }
                    }

                    /* Si existen exclusiones de producto; revisar si existen productos con esa nombre en el carrito */
                    $excluded_products = CouponExcludedProduct::where('coupon_id', $coupon->id)->get();
                    if ($excluded_products->count() != 0) {
                        $oldCart = Session::get('cart');
                        $cart = new Cart($oldCart);

                        $exc_products = 0;

                        foreach ($excluded_products as $exc_pro) {
                            if ($cart->items != NULL) {
                                // Encontrar los productos excluidos en el carrito
                                foreach ($cart->items as $product) {
                                    if ($product['item']['id'] == $exc_pro->id) {
                                        $exc_products++;
                                    }
                                }
                            }
                        }

                        $exc_products;

                        if ($exc_products == 0) {
                            // No se puede dar descuento a productos que ya tienen descuento
                            return response()->json(['mensaje' => 'Este cupón no aplica para algunos productos en tu carrito. Revisa las condiciones de tu cupón e intenta nuevamente.', 'type' => 'exception'], 200);
                        }
                    }

                    /* Recuperar el tipo de cupon */
                    $coupon_type = $coupon->type;

                    switch ($coupon_type) {
                        case 'percentage_amount':
                            // Este cupon resta un porcentaje del subtotal en el checkout
                            $qty = $coupon->qty / 100;
                            $discount = $subtotal * $qty;

                            break;

                        case 'fixed_amount':
                            // Este cupon le resta un valor fijo al subtotal en el checkout
                            $qty = $coupon->qty;
                            $discount = $qty;

                            break;

                        case 'free_shipping':
                            $qty = 0;
                            $discount = 0;

                            break;

                        default:
                            /* EJECUTAR EXCEPCIÓN SI EL CUPÓN NO TIENE UN TIPO DEFINIDO */
                            return response()->json(['mensaje' => 'Este tipo de cupón no existe, revisa con administración.', 'type' => 'exception'], 200);
                            break;
                    }

                    // Si cantidad menor al minimo requerido mandar response de error.
                    if ($shipping_rules != NULL) {
                        if ($shipping_rules->condition == 'Cantidad Comprada' && $shipping_rules->comparison_operator == '>') {
                            if ($discount <= $shipping_rules->value) {
                                return response()->json(['mensaje' => 'Este cupon no puede ser aplicado debido a que el cupon reduce ', 'type' => 'exception'], 200);
                            }
                        }
                    }

                    if ($coupon->is_free_shipping == true) {
                        $free_shipping = $shipping * 0;
                    } else {
                        $free_shipping = $shipping;
                    }

                    /* Renovar Preferencia de Pago de Mercado Pago */
                    $mercado_payment = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();

                    if (empty($mercado_payment)) {
                        $mp_preference = NULL;
                        $mp_preference_id =  NULL;
                    } else {
                        if ($mercado_payment->sandbox_mode == '1') {
                            $private_key_mercadopago = $mercado_payment->sandbox_private_key;
                        } elseif ($mercado_payment->sandbox_mode == '0') {
                            $private_key_mercadopago = $mercado_payment->private_key;
                        }
                        MercadoPago\SDK::setAccessToken($private_key_mercadopago);

                        // Create a Item to Pay
                        $item = new MercadoPago\Item();
                        $item->title = 'Tu compra desde tu tienda en Linea.';
                        $item->quantity = 1;
                        $item->unit_price = $subtotal - $discount + $free_shipping;

                        // Create Payer
                        if (!empty(Auth::user())) {
                            $payer = new MercadoPago\Payer();
                            $payer->name = Auth::user()->name;
                            $payer->email = Auth::user()->email;
                        }

                        // Create Preference
                        $preference = new MercadoPago\Preference();
                        $preference->items = array($item);
                        if (!empty(Auth::user())) {
                            $preference->payer = $payer;
                        }

                        $preference->back_urls = array(
                            "success" => route('purchase.complete'),
                            "failure" => route('checkout'),
                            "pending" => route('checkout')
                        );

                        $mercadopago_oxxo = array("id" => $mercado_payment->mercadopago_oxxo);
                        $mercadopago_paypal = array("id" => $mercado_payment->mercadopago_paypal);

                        $preference->payment_methods = array(
                            "excluded_payment_methods" => array(
                                $mercadopago_paypal,
                                $mercadopago_oxxo
                            ),
                            "excluded_payment_types" => array(
                                array("id" => "ticket", "id" => "atm")
                            ),
                        );

                        $preference->auto_return = "approved";
                        $preference->binary_mode = true;

                        $preference->save();

                        $mp_preference = $preference->init_point;
                        $mp_preference_id = $preference->id;
                    }

                    // Regresar Respuesta a la Vista
                    return response()->json(['mensaje' => 'Aplicado el descuento correctamente a los productos participantes. ¡Disfruta!', 'discount' => $discount, 'free_shipping' => $free_shipping, 'mp_preference_id' => $mp_preference_id, 'mp_preference' => $mp_preference], 200);
                } else {
                    return response()->json(['mensaje' => 'Este cupón caducó y no puede ser usado.', 'type' => 'exception'], 200);
                }
            }
        } else {
            $rule = ShipmentMethodRule::where('is_active', true)->first();

            return response()->json(['mensaje' => 'La promoción actual de "' . $rule->type . ' cuando ' . $rule->condition . ' ' . $rule->comparison_operator . ' ' .  number_format($rule->value) . '" en la tienda no admite el uso de cupones.', 'type' => 'exception'], 200);
        }
    }

    public function paymentPreference(Request $request)
    {
        $unit_price = $request->unit_price;

        /* Renovar Preferencia de Pago de Mercado Pago */
        $mercado_payment = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();

        if (empty($mercado_payment)) {
            $mp_preference = NULL;
            $mp_preference_id =  NULL;
        } else {
            if ($mercado_payment->sandbox_mode == '1') {
                $private_key_mercadopago = $mercado_payment->sandbox_private_key;
            } elseif ($mercado_payment->sandbox_mode == '0') {
                $private_key_mercadopago = $mercado_payment->private_key;
            }   
            MercadoPago\SDK::setAccessToken($private_key_mercadopago);

            // Create a Item to Pay
            $item = new MercadoPago\Item();
            $item->title = 'Tu compra desde tu tienda en Linea.';
            $item->quantity = 1;
            $item->unit_price = $unit_price;

            // Create Payer
            if (!empty(Auth::user())) {
                $payer = new MercadoPago\Payer();
                $payer->name = Auth::user()->name;
                $payer->email = Auth::user()->email;
            }

            // Create Preference
            $preference = new MercadoPago\Preference();
            $preference->items = array($item);
            if (!empty(Auth::user())) {
                $preference->payer = $payer;
            }

            $preference->back_urls = array(
                "success" => route('purchase.complete'),
                "failure" => route('checkout'),
                "pending" => route('checkout')
            );

            $mercadopago_oxxo = array("id" => $mercado_payment->mercadopago_oxxo);
            $mercadopago_paypal = array("id" => $mercado_payment->mercadopago_paypal);

            $preference->payment_methods = array(
                "excluded_payment_methods" => array(
                    $mercadopago_paypal,
                    $mercadopago_oxxo
                ),
                "excluded_payment_types" => array(
                    array("id" => "ticket", "id" => "atm")
                ),
            );

            $preference->auto_return = "approved";
            $preference->binary_mode = true;

            $preference->save();

            $mp_preference = $preference->init_point;
            $mp_preference_id = $preference->id;
        }

        // Regresar Respuesta a la Vista
        return response()->json(['mensaje' => 'Preferencia de Pago Actualizada', 'mp_preference_id' => $mp_preference_id, 'mp_preference' => $mp_preference], 200);
    }

    public function zipCodeGet(Request $request)
    {
        $value = $request->get('value');

        return response()->json(ZipCode::where('zip_code', $value)->get());
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

    public function legalText($slug)
    {
        $text = LegalText::where('slug', $slug)->first();

        return view('front.theme.' . $this->theme->get_name() . '.legal')->with('text', $text);
    }

    public function faqs()
    {
        $faqs = FAQ::all();

        return view('front.theme.' . $this->theme->get_name() . '.faqs')->with('faqs', $faqs);
    }

    public function purchaseComplete(Request $request)
    {
        $membership = MembershipConfig::where('is_active', true)->first();

        $store_config = $this->store_config;

        if (!empty($request->preference_id)) {
            $order = Order::where('payment_id', $request->preference_id)->first();
            $shipping_option_selected = ShipmentOption::where('id', $order->shipping_option)->first();
            $order->status = 'Pagado';

            $order->save();

            if (!empty($membership)) {
                if (!empty($order->points)) {
                    $points = new UserPoint();
                    $points->type = 'out';
                    $points->value = $order->points;
                    $points->order_id = $order->id;
                    $points->user_id = $order->user_id;

                    if ($membership->has_expiration_time == true) {
                        $points->valid_until = Carbon::now()->addMonths($membership->point_expiration_time)->format('Y-m-d');
                    }

                    $points->save();
                }
            }

            //$oldCart = Session::get('cart');
            //$cart = new Cart($oldCart);
            $order->cart = unserialize($order->cart);
            
            // Actualizar existencias del producto
            foreach ($order->cart->items as $product) {

                if ($product['item']['has_variants'] == true) {
                    $variant = Variant::where('value', $product['variant'])->first();
                    $product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

                    /* Proceso de Reducción de Stock */
                    $values = array(
                        'action_by' => $order->user_id,
                        'initial_value' => $product_variant->stock, 
                        'final_value' => $product_variant->stock - $product['qty'], 
                        'product_id' => $product_variant->id,
                        'created_at' => Carbon::now(),
                    );

                    DB::table('inventory_record')->insert($values);

                    /* Guardado completo de existencias */
                    $product_variant->stock = $product_variant->stock - $product['qty'];
                    $product_variant->save();
                } else {
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

            config(['mail.driver' => $mail->mail_driver]);
            config(['mail.host' => $mail->mail_host]);
            config(['mail.port' => $mail->mail_port]);
            config(['mail.username' => $mail->mail_username]);
            config(['mail.password' => $mail->mail_password]);
            config(['mail.encryption' => $mail->mail_encryption]);

            $data = array('order_id' => $order->id, 'user_id' => $order->user->id, 'logo' => $logo, 'store_name' => $store_name, 'order_date' => $order->created_at, 'shipping_option' => $shipping_option_selected);

            try {
                Mail::send('wecommerce::mail.order_completed', $data, function ($message) use ($name, $email, $sender_email, $store_name) {
                    $message->to($email, $name)->subject('¡Gracias por comprar con nosotros!');

                    $message->from($sender_email, $store_name);
                });

                Mail::send('wecommerce::mail.new_order', $data, function ($message) use ($sender_email, $store_name, $contact_email) {
                    $message->to($contact_email, $store_name)->subject('¡Nueva Compra en tu Tienda!');

                    $message->from($sender_email, $store_name);
                });
            } catch (Exception $e) {
                Session::flash('error', 'No se pudo enviar el correo con tu confirmación de orden. Aún así la orden está guardada en nuestros sistema. Contacta con un agente de soporte para dar seguimiento o accede a tu perfil para ver la orden.');
            }

            $purchase_value = $cart->totalPrice ?? 0;

            // Notificación
            $type = 'Orden';
            $by = $user;
            $data = 'hizo una compra por $' . $purchase_value;
            $model_action = "create";
            $model_id = "";

            $this->notification->send($type, $by, $data, $model_action, $model_id);

            //Facebook Event
            if ($this->store_config->has_pixel() != NULL) {
                $value = $purchase_value;
                $customer_name = $request->name;
                $customer_lastname = $request->last_name;
                $customer_email = $user->email;
                $customer_phone = $user->name;

                $collection = collect();

                foreach ($cart->items as $product) {
                    $collection = $collection->merge($product['item']['sku']);
                }
                $products_sku = $collection->all();

                $deduplication_code = md5(rand());

                $event = new FacebookEvents;
                $event->purchase($products_sku, $value, $customer_email, $customer_name, $customer_lastname, $customer_phone, $deduplication_code);
            } else {
                $deduplication_code = NULL;
            }

            Session::forget('cart');

            

            return view('front.theme.' . $this->theme->get_name() . '.purchase_complete')
                ->with('purchase_value', $purchase_value)
                ->with('store_config', $store_config)
                ->with('deduplication_code', $deduplication_code);
        }

        $deduplication_code = NULL;
        $purchase_value = 0;

        return view('front.theme.' . $this->theme->get_name() . '.purchase_complete')
            ->with('purchase_value', $purchase_value)    
            ->with('store_config', $store_config)
            ->with('deduplication_code', $deduplication_code);
    }

    public function purchasePending(Request $request)
    {
        $store_config = $this->store_config;

        if (!empty($request->preference_id)) {
            $order = Order::where('payment_id', $request->preference_id)->first();
            $order->status = 'Pago Pendiente';

            $order->save();

            Session::forget('cart');
        }

        return view('front.theme.' . $this->theme->get_name() . '.purchase_complete')->with('store_config', $store_config);
    }

    /*
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
    */

    public function orderTracking()
    {
        return view('front.theme.' . $this->theme->get_name() . '.order_tracking');
    }

    public function orderTrackingStatus(Request $request)
    {
        $order_id = Str::of($request->order_id)->ltrim('0');

        $user = User::where('email', $request->email)->first();

        if ($user != NULL) {
            $order = Order::where('id', $order_id)->where('user_id', $user->id)->first();

            if ($order == NULL) {
                Session::flash('error', 'No hay ninguna orden con ese número asociado con ese cliente.');

                return view('front.theme.' . $this->theme->get_name() . '.order_tracking');
            } else {
                $order->cart = unserialize($order->cart);

                return view('front.theme.' . $this->theme->get_name() . '.order_tracking')->with('order', $order);
            }
        } else {
            Session::flash('error', 'No hay ninguna orden con ese número asociado con ese cliente.');

            return view('front.theme.' . $this->theme->get_name() . '.order_tracking');
        }
    }

    //NEWSLETTER
    public function newsletter(Request $request)
    {
        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();
    }

    public function calculateTotalWithOptions(Request $request)
    {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $store_tax = StoreTax::where('country_id', $this->store_config->get_country())->first();
        $shipment_option = ShipmentOption::where('id', $request->shipping_option_id)->first();

        if (empty($store_tax)) {
            $tax_rate = 0;
            $has_tax = false;
        } else {
            $tax_rate = ($store_tax->tax_rate) / 100 + 1;
            $has_tax = true;
        }
        // Reglas de Envios y Opciones de Envío
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
                    $shipping = $shipment_option->price;

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
                                    $shipping = $shipment_option->price;
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
                                    $shipping = $shipment_option->price;
                                    break;
                            }
                            break;

                        default:
                            $shipping = $shipment_option->price;
                            break;
                    }
                    //
                    break;

                default:
                    $shipping = $shipment_option->price;
                    break;
            }
        } else {
            $shipping = $shipment_option->price;
        }

        $total_cart = $cart->totalPrice;
        
        /* SPECIAL PRICE PROMO FUNCTIONALITY */
        $getPromo = Session::get('promo');

        if($getPromo == 'true'){
            $productCount = 0;

            foreach($cart->items as $cart_product){
                $productCount += $cart_product['qty'];
            }

            /*
            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $total_cart = 1299 * ($productCount / 2);
                } elseif ($productCount % 3 === 0) {
                    // Múltiplo de tres
                    $total_cart = 1799 * ($productCount / 3);
                } else {
                    // No es múltiplo de dos ni de tres
                    $total_cart = $cart->totalPrice;
                }
            } else {
                $total_cart = $cart->totalPrice;
            }
            */

            if ($productCount >= 2) {
                if ($productCount % 2 === 0) {
                    // Múltiplo de dos
                    $total_cart = 1299 * ($productCount / 2);
                } else {
                    // No es múltiplo de dos
                    $total_cart = $cart->totalPrice;
                }
            } else {
                $total_cart = $cart->totalPrice;
            }
        }

        //$total_cart = $cart->totalPrice;

        $tax = ($total_cart + $shipping) - (($total_cart + $shipping) / $tax_rate);
        $subtotal = ($total_cart + $shipping) - ($tax);
        $total = $subtotal + $tax;

        /* Renovar Preferencia de Pago de Mercado Pago */
        $mercado_payment = PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();

        if (empty($mercado_payment)) {
            $mp_preference = NULL;
            $mp_preference_id =  NULL;
        } else {
            if ($mercado_payment->sandbox_mode == '1') {
                $private_key_mercadopago = $mercado_payment->sandbox_private_key;
            } elseif ($mercado_payment->sandbox_mode == '0') {
                $private_key_mercadopago = $mercado_payment->private_key;
            }
            MercadoPago\SDK::setAccessToken($private_key_mercadopago);

            // Create a Item to Pay
            $item = new MercadoPago\Item();
            $item->title = 'Tu compra desde tu tienda en Linea';
            $item->quantity = 1;
            $item->unit_price = $total;

            // Create Payer
            if (!empty(Auth::user())) {
                $payer = new MercadoPago\Payer();
                $payer->name = Auth::user()->name;
                $payer->email = Auth::user()->email;
            }

            // Create Preference
            $preference = new MercadoPago\Preference();
            $preference->items = array($item);
            if (!empty(Auth::user())) {
                $preference->payer = $payer;
            }

            $preference->back_urls = array(
                "success" => route('purchase.complete'),
                "failure" => route('checkout'),
                "pending" => route('checkout')
            );

            $mercadopago_oxxo = array("id" => $mercado_payment->mercadopago_oxxo);
            $mercadopago_paypal = array("id" => $mercado_payment->mercadopago_paypal);

            $preference->payment_methods = array(
                "excluded_payment_methods" => array(
                    $mercadopago_paypal,
                    $mercadopago_oxxo
                ),
                "excluded_payment_types" => array(
                    array("id" => "ticket", "id" => "atm")
                ),
            );

            $preference->auto_return = "approved";
            $preference->binary_mode = true;

            $preference->save();

            $mp_preference = $preference->init_point;
            $mp_preference_id = $preference->id;
        }

        // Regresar Respuesta a la Vista
        return response()->json([
            'mensaje' => $tax,
            'shipping' => number_format($shipping, 2),
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2),
            'final_total' => $total,
            'mp_preference_id' => $mp_preference_id,
            'mp_preference' => $mp_preference
        ], 200);
    }
}
