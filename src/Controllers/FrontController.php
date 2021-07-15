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
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

/* E-commerce Models */
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\Banner;
use Nowyouwerkn\WeCommerce\Models\Cart;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\Category;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Wishlist;

use Nowyouwerkn\WeCommerce\Models\StoreTax;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\UserAddress;

/* Cuopon Models */
use Nowyouwerkn\WeCommerce\Models\Coupon;
use Nowyouwerkn\WeCommerce\Models\UserCoupon;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index ()
    {
        $products = Product::where('in_index', true)->get()->take(6);
        $main_categories = Category::where('parent_id', '0')->orWhere('parent_id', NULL)->get()->take(3);

        $banner = Banner::where('is_active', true)->first();

        return view('wecommerce::front.werkn-backbone.index')
        ->with('products', $products)
        ->with('main_categories', $main_categories)
        ->with('banner', $banner);
    }

    /* Catalog Filters */
    public function dynamicFilter(Request $request)
    {
        $total_products = Product::all()->count();

        $selected_cat_type = $request->cat_type;
        //$selected_variant = $request->variant;
        
        $query = Product::select('*')->where('in_index', true);

        if (isset($selected_cat_type)) {
            $category = Category::where('slug', $selected_cat_type)->first();

            $query->where('category_id', $category->id);
        }

        $products = $query->paginate(30)->withQueryString();

        if($products->count() > 0){
            return view('wecommerce::front.werkn-backbone.catalog_filter')
            ->with('products', $products);
        }else{
            $products = collect([]);

            return view('wecommerce::front.werkn-backbone.catalog_filter')
            ->with('products', $products);
        }
    }

    public function catalogAll()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15);

        return view('wecommerce::front.werkn-backbone.catalog')
        ->with('products', $products);
    }

    /* Normal Category Filter */
    public function catalog($category_slug)
    {
        $catalog = Category::where('slug', $category_slug)->first();
        $products = Product::where('category_id', $catalog->id)->paginate(15);

        return view('wecommerce::front.werkn-backbone.catalog')
        ->with('catalog', $catalog)
        ->with('products', $products);
    }

    public function detail ($category_slug, $slug)
    {
        $catalog = Category::where('slug', $category_slug)->first();
        $product = Product::where('slug', '=', $slug)->first();

        $products_selected = Product::where('category_id', $catalog->id)->where('slug', '!=' , $product->slug)->take(4)->get();

        if (empty($product)) {
            return redirect()->back();
        }else{
            return view('wecommerce::front.werkn-backbone.detail')
            ->with('product', $product)
            ->with('products_selected', $products_selected);
        }

        /*
        $product = Product::where('slug', '=', $slug)->first();
        $products_selected = Product::where('slug', '!=' , $product->slug)->take(4)->get();
        $variants = collect();

        // Regresar a Vista
        //return view('wecommerce::front.werkn-backbone.detail')->with('product', $product)->with('products_selected', $products_selected)->with('variants');
        */

        //return view('wecommerce::front.werkn-backbone.detail', compact('product', 'products_selected', 'variants' ));
    }

    public function cart ()
    {
        if (!Session::has('cart')) {
            return view('checkout.cart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('wecommerce::front.werkn-backbone.cart')->with('products', $cart->items)->with('totalPrice', $cart->totalPrice);
    }

    public function checkout ()
    {
        if (!Session::has('cart')) {
            return view('checkout.cart');
        }
        
        //Facebook Event
        /*
        $event = new FacebookEvents;
        $event->initiateCheckout();
        */

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        
        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();
        $store_tax = StoreTax::take(1)->first();

        if(Auth::check()){
            $user = Auth::user();

            $addresses = UserAddress::where('user_id', Auth::user()->id)->get();

           return view('wecommerce::front.werkn-backbone.checkout')
           ->with('total', $total)
           ->with('user', $user)
           ->with('addresses', $addresses)
           ->with('payment_method', $payment_method)
           ->with('store_tax', $store_tax)
           ->with('products', $cart->items);
        }else{
            // COMPRA DE INVITADO
            $count = 0;
            foreach ($cart->items as $product) {
                $qty = $product['qty'];
                $count += $qty;
            };
            $count;

            $addresses = UserAddress::where('user_id', '000998')->get();

            return view('wecommerce::front.werkn-backbone.checkout')
            ->with('total', $total)
            ->with('addresses', $addresses)
            ->with('payment_method', $payment_method)
            ->with('store_tax', $store_tax)
            ->with('products', $cart->items)
            ->with('cart_count', $count);
        }
    }

    public function getOpenPayInstance(){
        $openpayId = env('OPENPAY_MERCHANT_ID', '');
        $openpayApiKey = env('OPENPAY_PRIVATE_KEY', '');
        $openpaySandboxMode = env('OPENPAY_SANDBOX_MODE', true);
        try {
            Openpay::setId($openpayId);
            Openpay::setApiKey($openpayApiKey);
            Openpay::setSandboxMode($openpaySandboxMode);
            $openpay = Openpay::getInstance();
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
        $paypal_config = Config::get('werkn-commerce');

        $api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_config['PAYPAL_CLIENT_ID'],
                $paypal_config['PAYPAL_SECRET']
            )
        );

        $api_context->setConfig($paypal_config['PAYPAL_SETTINGS']);
    }

    public function payPalStatus(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
            return redirect('/paypal/failed')->with(compact('status'));
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Ejecutar el Pago **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            $status = 'Gracias! El pago a través de PayPal se ha ralizado correctamente.';
            return redirect('/results')->with(compact('status'));
        }

        $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
        return redirect('/results')->with(compact('status'));
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

        $payment_method = PaymentMethod::where('is_active', true)->where('type', 'card')->first();
        $paypal_express_checkout = PaymentMethod::where('is_active', true)->where('supplier', 'Paypal')->first();

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

        if ($payment_method->supplier == 'Conekta') {
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
                                'email' => Auth::user()->email
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
            }
        }

        if ($payment_method->supplier == 'Stripe') {
            try {
                $charge = Charge::create(array(
                    "amount" => $request->final_total * 100,
                    "currency" => "usd",
                    "source" => $request->input('stripeToken'), 
                    "description" => "Purchase Successful",
                ));
            } catch(\Excepton $e) {
                    return redirect()->route('checkout')->with('error', $e->getMessage() );
            }
        }

        if ($payment_method->supplier == 'OpenPay') {
            try {
                $openpay = $this->getOpenPayInstance();

                $customer = array(
                    'name' => $request->client_name,
                    'last_name' => $request->client_name,
                    'phone_number' => $request->phone,
                    'email' => Auth::user()->email,
                    'requires_account' => false
                );

                $chargeRequest = array(
                    'method' => 'card',
                    'source_id' => $request->input('openPayToken'),
                    'amount' => $cart->totalPrice,
                    'currency' => 'MXN',
                    'description' => 'Compra Exitosa',
                    'device_session_id' => $request->device_hidden,
                    'customer' => $customer
                );

                $charge = $openpay->charges->create($chargeRequest);
            } catch(\Excepton $e) {
                return redirect()->route('checkout')->with('error', $e->getMessage() );
            }
        }

        if (!empty($paypal_express_checkout)) {
            try {
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $amount = new Amount();
                $amount->setTotal($cart->totalPrice);
                $amount->setCurrency('MXN');

                $transaction = new Transaction();
                $transaction->setAmount($amount);
                $transaction->setDescription('Compra Exitosa');

                $callbackUrl = url('/paypal/status');

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl($callbackUrl)
                    ->setCancelUrl($callbackUrl);

                $payment = new Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);

                $payment->create($this->apiContext);

                return redirect()->away($payment->getApprovalLink());

            } catch (PayPalConnectionException $ex) {
                echo $ex->getData();
            }
        }

        if (!Auth::check()) {
            $user = User::create([
                'name' => $client_name,
                'email' => $request->email,
                'password' => bcrypt('wkshop'),
            ]);
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
        //$order->suburb = $request->input('suburb');
        $order->references = $request->input('references');

        /* Money Info */
        $order->cart_total = $cart->totalPrice;
        $order->shipping_rate = $request->shipping_rate;
        $order->sub_total = $request->sub_total;
        $order->tax_rate = $request->tax_rate;
        $order->discounts = $request->discounts;
        $order->total = $request->final_total;
        /*------------*/
            
        $order->card_digits = Str::substr($request->card_number, 15);
        $order->client_name = $request->input('name') . ' ' . $request->input('last_name');
        $order->payment_id = $charge->id;
        $order->payment_total = $request->final_total;

        // Identificar al usuario para guardar sus datos.
        $user->orders()->save($order);

        // Actualizar existencias del carrito
        foreach ($cart->items as $product) {
            $get_product = ProductVariant::where('product_id', $product['item']['id'])->get();

            foreach($get_product as $search_variant){
                $get_variant = Variant::find($search_variant->variant_id);

                if($get_variant->name == $product['variant']){
                    $actual_stock = $search_variant->stock;
                    $new_stock = $actual_stock - $product['qty'];
                    $search_variant->stock = $new_stock;

                    $search_variant->save();
                }
            }
        }

        // GUARDAR LA DIRECCIÓN
        $check = UserAddress::where('street', $request->street)->count();

        if ($check == NULL || $check == 0) {
            $address = new UserAddress;
            $address->name = 'Compra_' . substr($charge->id, 0, 3);
            $address->user_id = $user->id;
            $address->street = $request->street;
            $address->street_num = $request->street_num;
            //$address->between_streets = $request->between_streets;
            $address->postal_code = $request->postal_code;
            $address->city = $request->city;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->phone = $request->phone;
            //$address->suburb = $request->suburb;
            //$address->references = $request->references;

            $address->save();
        }

        $name = $user->name;
        $email = $user->email;

        /*
        $data = array('order_id' => $order->id, 'user_id' => $user->id, 'name'=> $user->name, 'email' => $user->email, 'orden'=> $order, 'total'=> $cart->totalPrice, 'num_orden'=> $order->id );

        Mail::send('mail.order_completed', $data, function($message) use($name, $email) {

            $message->to($email, $name)->subject
            ('Gracias por comprar Manfort');
            
            $message->from('noreply@manfort.com.mx','Manfort México');
        });
        
        Mail::send('mail.new_order_notification', $data, function($message) {
            $message->to('atencion@manfort.com.mx', 'Ventas Manfort')->subject
            ('¡Nueva Compra en tu Tienda!');
            
            $message->from('noreply@manfort.com.mx','Manfort México');
        });
        */

        $purchase_value = number_format($cart->totalPrice,2);

        // Notificación
        $type = 'Orden';
        $by = $user;
        $data = 'hizo una compra por $' . $purchase_value;

        $this->notification->send($type, $by ,$data);

        //Facebook Event
        /*
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
        */

        Session::forget('cart');
        Session::flash('purchase_complete', 'Compra Exitosa.');

        return view('wecommerce::front.werkn-backbone.profile')->with('order', $order)->with('purchase_value', $purchase_value);
    }

    public function auth ()
    {
        return view('wecommerce::front.werkn-backbone.auth');
    }

    //Profile
    public function profile ()
    {
        return view('wecommerce::front.werkn-backbone.profile');
    }

    public function wishlist ()
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->get();

        return view('wecommerce::front.werkn-backbone.wishlist')->with('wishlist', $wishlist);
    }

    public function shopping ()
    {
        return view('wecommerce::front.werkn-backbone.shopping');
    }

    public function address ()
    {
        $addresses = UserAddress::paginate(10);
        return view('wecommerce::front.werkn-backbone.address', compact('addresses'));
    }

    public function account ()
    {
        return view('wecommerce::front.werkn-backbone.account');
    }

    public function applyCuopon(Request $request){
        // Recuperar codigo del cupon enviado por AJAX
        $cuopon_code = $request->get('cuopon_code');

        // Recuperar el resto de los datos enviados por AJAX
        $subtotal = $request->get('subtotal');
        $shipping = $request->get('shipping');

        // Obteniendo datos desde el Request enviado por Ajax a esta ruta
        $coupon = Coupon::where('code', $cuopon_code)->first();

        if (empty($coupon)) {
            // Regresar Respuesta a la Vista
            return response()->json(['mensaje' => 'Ese cupón no existe. Intenta con otro.'], 400);
        }else{
            /* Definir Usuario usando el sistema */
            $user = Auth::user();
            /* Contar cuopones usados que compartan el codigo */
            $count_coupons = UserCoupon::where('coupon_id', $coupon->id)->count();
            /* Contar los cupones con el codigo que el usuario haya usado anteriormente */
            $count_user_coupons = UserCoupon::where('user_id', $user->id)->where('coupon_id', $coupon->id)->count();

            /* Revisar si el coupon no ha sobrepasado su limite de uso */
            if ($count_user_coupons < $coupon->usage_limit_per_code) {
                /* Si no se ha alcanzado el limite de uso de cuopon ejecutar el codigo */
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
                    $used = new UserCoupon;
                    $used->user_id = Auth::user()->id;
                    $used->coupon_id = $coupon->id;
                    $used->save();
                    // Regresar Respuesta a la Vista
                    return response()->json(['mensaje' => 'Aplicado el descuento correctamente... disfruta', 'discount' => $discount, 'free_shipping' => $free_shipping], 200);

                /* EJECUTAR EXCEPCIÓN SI EL USUARIO YA ALCANZÓ EL LIMITE */    
                }else{
                    return response()->json(['mensaje' => "Alcanzaste el limite de uso para este cupón. Intenta con otro.", 'type' => 'exception'], 200);
                }
            /* EJECUTAR EXCEPCIÓN SI EL CUPÓN YA ALCANZÓ EL LIMITE */        
            }else{
                return response()->json(['mensaje' => "Ya no quedan existencias de este cupón. Intenta con otro.", 'type' => 'exception'], 200);
            }
            
            /*
            $free_shipping = 'no';
            $discount = 29;

            // Regresar Respuesta a la Vista
            return response()->json(['mensaje' => 'Aplicado el descuento correctamente... disfruta', 'discount' => $discount, 'free_shipping' => $free_shipping], 200);
            */
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
        
        return view('feeds.xml')->with('items', $items);
    }
}
