<?php

use Illuminate\Support\Facades\Route;

// Authentication Views
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Back-End Views
Route::group(['prefix' => 'admin','middleware' => 'auth'], function(){
    //Dashboard
    Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@index')->name('dashboard'); //
    Route::resource('banners', 'Nowyouwerkn\WeCommerce\Controllers\BannerController');

    Route::post('/banners/status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\BannerController@status',
        'as' => 'banners.status',
    ]);

    //Configuration
    Route::get('/configuration', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configuration')->name('configuration'); //

    Route::get('/bienvenido/paso-1',[
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configStep1',
        'as' => 'config.step1',
    ]);

    Route::get('/bienvenido/paso-2/{id}',[
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configStep2',
        'as' => 'config.step2',
    ]);

    //Catalog
    Route::resource('products', Nowyouwerkn\WeCommerce\Controllers\ProductController::class); //
    Route::resource('stocks', Nowyouwerkn\WeCommerce\Controllers\StockController::class); //
    Route::resource('categories', Nowyouwerkn\WeCommerce\Controllers\CategoryController::class); //
    /*
    Route::post('variants/storeStock', 'Nowyouwerkn\WeCommerce\Controllers\VariantTypeController@storeStock')->name('variants.storeStock');
    Route::post('variants/updateStock', 'Nowyouwerkn\WeCommerce\Controllers\VariantTypeController@updateStock')->name('variants.updateStock');
    */

    Route::post('/variants/stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@store',
        'as' => 'stock.store',
    ]);
    
    Route::put('/variants/update-stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@update',
        'as' => 'stock.update',
    ]);

    Route::resource('clients', Nowyouwerkn\WeCommerce\Controllers\ClientController::class); //
    Route::resource('orders', Nowyouwerkn\WeCommerce\Controllers\OrderController::class); //

    Route::post('/orders/{id}/cambiar-estado', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@changeStatus',
        'as' => 'order.status',
    ]);

    Route::resource('orders/notes', Nowyouwerkn\WeCommerce\Controllers\OrderNoteController::class); //

    Route::resource('coupons', Nowyouwerkn\WeCommerce\Controllers\CouponController::class); //
    Route::resource('reviews', Nowyouwerkn\WeCommerce\Controllers\ReviewController::class); //  
   
    //Administration
    Route::resource('seo', Nowyouwerkn\WeCommerce\Controllers\SEOController::class); //
    Route::resource('legals', Nowyouwerkn\WeCommerce\Controllers\LegalTextController::class);
    Route::resource('taxes', Nowyouwerkn\WeCommerce\Controllers\StoreTaxController::class); //

    Route::get('/taxes/create/{country_id}',[
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StoreTaxController@create',
        'as' => 'taxes.create',
    ]);

    Route::resource('users', Nowyouwerkn\WeCommerce\Controllers\UserController::class); //
    Route::get('user/config', 'Nowyouwerkn\WeCommerce\Controllers\UserController@config')->name('user.config');  //
    Route::get('user/help', 'Nowyouwerkn\WeCommerce\Controllers\UserController@help')->name('user.help');  //
    Route::resource('notifications', Nowyouwerkn\WeCommerce\Controllers\NotificationController::class); //
    Route::resource('payments', Nowyouwerkn\WeCommerce\Controllers\PaymentMethodController::class);  //
    Route::resource('shipments', Nowyouwerkn\WeCommerce\Controllers\ShipmentMethodController::class);
    Route::resource('log', Nowyouwerkn\WeCommerce\Controllers\LogController::class); 

    //Country
    Route::resource('countries', Nowyouwerkn\WeCommerce\Controllers\CountryController::class); 
    Route::resource('states', Nowyouwerkn\WeCommerce\Controllers\StateController::class); 
    Route::resource('cities', Nowyouwerkn\WeCommerce\Controllers\CityController::class); 
    Route::resource('config', Nowyouwerkn\WeCommerce\Controllers\StoreConfigController::class); 

    // Sección Soporte
    Route::get('support', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@shipping')->name('support.help');

    /* Rutas de Correo */
    Route::get('send_order_email','Nowyouwerkn\WeCommerce\Controllers\MailController@order_email');

    Route::post('/resend-mail/{order_id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\MailController@resendOrder',
        'as' => 'resend.order.mail',
    ]);
});

// Shopping Cart
Route::get('/cart/{id}/{variant}',[
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@addCart',
	'as' => 'add-cart',
]);

Route::get('/cart',[
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@cart',
	'as' => 'cart',
]);

Route::get('/substract/{id}/{variant}',[
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@substractOne',
	'as' => 'cart.substract',
]);

Route::get('/add/{id}/{variant}',[
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@addMore',
	'as' => 'cart.add-more',
]);

Route::get('/delete/{id}/{variant}',[
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@deleteItem',
	'as' => 'cart.delete',
]);

// Wishlist
Route::get('/wishlist/add/{id}', [
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WishlistController@add',
	'as' => 'wishlist.add',
]);

Route::get('/wishlist/remove/{id}', [
	'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WishlistController@destroy',
	'as' => 'wishlist.remove',
]);

// XML Feed para Catálogo Facebook
Route::get('/xml-feed', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@xmlFeed',
    'as' => 'xml.feed',
]);


// FRONT VIEWS
Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@index')->name('index');
Route::get('catalog', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@catalogAll')->name('catalog.all');

Route::get('/catalog/{category_slug}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@catalog',
    'as' => 'catalog',
]);

Route::get('/catalog/{category_slug}/{slug}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@detail',
    'as' => 'detail',
])->where('slug', '[\w\d\-\_]+');

Route::get('/catalog-filters', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@dynamicFilter',
    'as' => 'dynamic.filter.front',
]);

/* Search Functions */
Route::get('/busqueda-general', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\SearchController@query',
    'as' => 'search.query',
]);

Route::get('cart', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@cart')->name('cart');
Route::get('/checkout', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@checkout')->name('checkout');

Route::post('/checkout',[
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@postCheckout',
    'as' => 'checkout',
]);

/* Cuopon Validation on Checkout */
Route::post('/apply-cuopon', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@applyCuopon',
    'as' => 'apply.cuopon',
]);

Route::get('blog', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@blog')->name('blog');
Route::get('contact', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@contact')->name('contact');

//Profile
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function(){
    Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@profile')->name('profile');
    Route::get('wishlist', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@wishlist')->name('wishlist');
    Route::get('orders', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@shopping')->name('shopping');
    Route::get('address', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@address')->name('address');
    Route::get('address/create', 'Nowyouwerkn\WeCommerce\Controllers\ClientController@addAddress')->name('address.create');
    Route::get('account', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@account')->name('account');
});

// INSTALADOR 
Route::prefix('/instalador')->group(function () {
    Route::get('/', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@index',
        'as' => 'install.index',
    ]);

    Route::post('/vistas', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@views',
        'as' => 'install.views',
    ]);

    Route::post('/migraciones', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@migrations',
        'as' => 'install.migrations',
    ]);

    Route::post('/seeders', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@seeders',
        'as' => 'install.seeders',
    ]);

    Route::get('/registro', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@auth',
        'as' => 'install.auth',
    ]);

    Route::post('/registro', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\InstallController@authPost',
        'as' => 'install.store',
    ]);
});

