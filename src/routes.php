<?php

use Illuminate\Support\Facades\Route;

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

// Back-End Views
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'can:admin_access']], function () {
    //Dashboard
    Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@index')->name('dashboard'); //
    Route::get('/kpis-analitica', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@analytics')->name('analytics.index');

    Route::get('/change-color', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@changeColor',
        'as' => 'change.color',
    ]);

    Route::get('/mensajes-actualizaciones', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@messages',
        'as' => 'update.messages',
    ]);

    Route::resource('banners', 'Nowyouwerkn\WeCommerce\Controllers\BannerController');

    Route::post('/banners/status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\BannerController@status',
        'as' => 'banners.status',
    ]);

    Route::resource('popups', Nowyouwerkn\WeCommerce\Controllers\PopupController::class);

    Route::post('/popups/status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\PopupController@status',
        'as' => 'popups.status',
    ]);

    Route::resource('band', Nowyouwerkn\WeCommerce\Controllers\HeaderbandController::class);
    Route::post('/band/status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\HeaderbandController@status',
        'as' => 'band.status',
    ]);

    //Configuration
    Route::get('/configuration', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configuration')->name('configuration'); //

    Route::get('/bienvenido/paso-1', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configStep1',
        'as' => 'config.step1',
    ]);

    Route::get('/bienvenido/paso-2/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@configStep2',
        'as' => 'config.step2',
    ]);

    //Catalog
    Route::resource('products', Nowyouwerkn\WeCommerce\Controllers\ProductController::class); //

    Route::get('products/create/digital', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@createDigital',
        'as' => 'products.create.digital',
    ]);

    /* Multimedia del Producto */
    Route::post('dropzone/upload/{id}', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@uploadImage')->name('dropzone.upload');
    Route::get('dropzone/fetch/{id}', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@fetchImage')->name('dropzone.fetch');
    Route::get('dropzone/delete/{id}', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@deleteImage')->name('dropzone.delete');

    Route::post('products/duplicate/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@duplicate',
        'as' => 'products.duplicate',
    ]);

    Route::get('products/preview/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@preview',
        'as' => 'products.show.preview',
    ]);

    Route::get('products/create/subscription', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@createSubscription',
        'as' => 'products.create.subscription',
    ]);

    Route::get('productsquery', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@search',
        'as' => 'products.query',
    ]);

    Route::get('productsfilter/{filter}/{order}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@filter',
        'as' => 'filter.products',
    ]);

    Route::get('productspromotions', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@promotions',
        'as' => 'products.promotions',
    ]);
    Route::get('exportar-productos', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@export')->name('export.products');
    Route::post('importar-productos', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@import')->name('import.products');
    Route::get('exportar-inventario', 'Nowyouwerkn\WeCommerce\Controllers\ProductController@export_inventory_changes')->name('inventory.clients');

    Route::post('/get-subcategories', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@fetchSubcategory',
        'as' => 'dynamic.subcategory',
    ]);

    // Get Functions
    Route::get('/characteristic-inputs', function () {
        return view('wecommerce::back.products.includes._characteristic_inputs');
    })->name('subscription.inputs');

    Route::get('/characteristic-inputs-update', function () {
        return view('wecommerce::back.products.includes._characteristic_inputs_update');
    })->name('subscription.inputs.update');

    Route::post('products/new-characteristic', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@storeCharacteristic',
        'as' => 'characteristic.store'
    ]);

    Route::put('products/update-characteristic/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@updateCharacteristic',
        'as' => 'characteristic.update'
    ]);

    Route::delete('products/delete-characteristic/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@destroyCharacteristic',
        'as' => 'characteristic.destroy'
    ]);

    Route::post('products/new-image', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@storeImage',
        'as' => 'image.store',
    ]);

    Route::post('products/update-image', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@updateImage',
        'as' => 'image.update',
    ]);

    Route::delete('products/delete-image/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@destroyImage',
        'as' => 'image.destroy',
    ]);

    Route::post('/products/create-dynamic', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@storeDynamic',
        'as' => 'products.store.dynamic',
    ]);

    Route::put('/products/update-stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductController@stockUpdate',
        'as' => 'product.stock.update',
    ]);

    //Route::resource('product-relationships', Nowyouwerkn\WeCommerce\Controllers\ProductRelationshipController::class);

    Route::post('/obtener-color-de-producto', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductRelationshipController@fetchColor',
        'as' => 'fetch.color',
    ]);

    Route::post('/product-relationships/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductRelationshipController@store',
        'as' => 'relationship.store',
    ]);

    Route::delete('/product-relationships/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ProductRelationshipController@destroy',
        'as' => 'relationship.destroy',
    ]);

    Route::resource('stocks', Nowyouwerkn\WeCommerce\Controllers\StockController::class); //
    Route::resource('variants', Nowyouwerkn\WeCommerce\Controllers\VariantController::class); //
    Route::resource('categories', Nowyouwerkn\WeCommerce\Controllers\CategoryController::class); //
    Route::resource('size_chart', Nowyouwerkn\WeCommerce\Controllers\SizeChartController::class);

    Route::resource('channels', Nowyouwerkn\WeCommerce\Controllers\ChannelController::class);
    Route::resource('branches', Nowyouwerkn\WeCommerce\Controllers\BranchController::class);

    Route::put('/branches/update-stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\BranchController@stockUpdate',
        'as' => 'branch.stock.update',
    ]);

    Route::post('size/add', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\SizeChartController@createsize',
        'as' => 'size.add',
    ]); //
    Route::post('size/update', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\SizeChartController@update_value',
        'as' => 'size_value.update',
    ]);

    Route::get('stocksquery', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@search',
        'as' => 'stocks.query',
    ]);

    Route::get('stocks/filter/{filter}/{order}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@filter',
        'as' => 'filter.stock',
    ]);

    Route::post('/variants/stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@store',
        'as' => 'stock.store',
    ]);

    Route::post('/variants/stock-dynamic', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@storeDynamic',
        'as' => 'stock.store.dynamic',
    ]);

    Route::put('/variants/update-stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@update',
        'as' => 'stock.update',
    ]);

    Route::delete('/variants/delete-stock/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StockController@destroy',
        'as' => 'stock.destroy',
    ]);

    Route::resource('clients', Nowyouwerkn\WeCommerce\Controllers\ClientController::class);
    Route::resource('invoices', Nowyouwerkn\WeCommerce\Controllers\UserInvoiceController::class);

    Route::get('filter/invoices/{invoice}/{filter}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\UserInvoiceController@filter',
        'as' => 'filter.invoices',
    ]);

    Route::resource('user-rules', Nowyouwerkn\WeCommerce\Controllers\UserRuleController::class);

    Route::get('/user-rules/change-status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\UserRuleController@changeStatus',
        'as' => 'user-rules.status',
    ]);

    Route::get('exportar-clientes', 'Nowyouwerkn\WeCommerce\Controllers\ClientController@export')->name('export.clients');
    Route::post('importar-clientes', 'Nowyouwerkn\WeCommerce\Controllers\ClientController@import')->name('import.clients');
    Route::get('filter/clients/{order}/{filter}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ClientController@filter',
        'as' => 'filter.clients',
    ]);
    Route::get('clientsquery', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ClientController@query',
        'as' => 'clients.search',
    ]);

    Route::resource('newsletter', Nowyouwerkn\WeCommerce\Controllers\NewsletterController::class); //

    Route::resource('orders', Nowyouwerkn\WeCommerce\Controllers\OrderController::class); //

    Route::get('orders-subscriptions', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@subscriptions',
        'as' => 'order.subscriptions.index',
    ]);

    Route::get('exportar-ordenes', 'Nowyouwerkn\WeCommerce\Controllers\OrderController@export')->name('export.orders');

    Route::get('/orders/{id}/packing-list', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@packingList',
        'as' => 'order.packing.list',
    ]);

    Route::put('/orders/{id}/cambiar-estado', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@changeStatus',
        'as' => 'order.status',
    ]);

    Route::get('/cambiar-estado-orden/{id}/{status_string}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@changeStatusStatic',
        'as' => 'order.status.static',
    ]);

    Route::resource('orders/notes', Nowyouwerkn\WeCommerce\Controllers\OrderNoteController::class); //

    Route::resource('/orders/tracking',  Nowyouwerkn\WeCommerce\Controllers\OrderTrackingController::class);

    Route::get('/orders/tracking/complete/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderTrackingController@updateComplete',
        'as' => 'tracking.complete',
    ]);

    Route::get('filter/orders/{order}/{filter}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@filter',
        'as' => 'filter.orders',
    ]);
    Route::get('ordersquery', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@query',
        'as' => 'orders.search',
    ]);

    Route::get('/orders/{id}/cancelar-suscripcion', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@cancelSubscription',
        'as' => 'order.cancel.subscription',
    ]);

    Route::get('/orders/{id}/refund', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\OrderController@refundOrder',
        'as' => 'order.refund',
    ]);

    Route::resource('promos', Nowyouwerkn\WeCommerce\Controllers\PromoController::class); //

    Route::post('/get-promo-products', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\PromoController@fetchProducts',
        'as' => 'dynamic.promo.filter',
    ]);

    Route::resource('coupons', Nowyouwerkn\WeCommerce\Controllers\CouponController::class); //
    Route::resource('reviews', Nowyouwerkn\WeCommerce\Controllers\ReviewController::class)->except(['store']); //

    Route::get('/reviews/aprobar/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ReviewController@approve',
        'as' => 'review.approve',
    ]);

    /*Membresias*/
    Route::resource('membership', Nowyouwerkn\WeCommerce\Controllers\MembershipController::class);

    Route::put('/membership-status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\MembershipController@statusUpdate',
        'as' => 'mem-status.update',
    ]);

    //Administration
    Route::resource('seo', Nowyouwerkn\WeCommerce\Controllers\SEOController::class); //
    Route::resource('legals', Nowyouwerkn\WeCommerce\Controllers\LegalTextController::class);
    Route::resource('faq', Nowyouwerkn\WeCommerce\Controllers\FAQController::class);
    Route::resource('taxes', Nowyouwerkn\WeCommerce\Controllers\StoreTaxController::class)->except(['create']); //

    Route::get('/taxes/create/{country_id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StoreTaxController@create',
        'as' => 'taxes.create',
    ]);

    Route::resource('users', Nowyouwerkn\WeCommerce\Controllers\UserController::class); //
    Route::get('user/config', 'Nowyouwerkn\WeCommerce\Controllers\UserController@config')->name('user.config');  //
    Route::get('user/help', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@help')->name('user.help');  //

    Route::resource('template', Nowyouwerkn\WeCommerce\Controllers\MailThemeController::class); //
    Route::resource('mail', Nowyouwerkn\WeCommerce\Controllers\MailController::class)->except(['show, create, index']);
    Route::resource('notifications', Nowyouwerkn\WeCommerce\Controllers\NotificationController::class)->except(['show']); //

    Route::get('/notifications/all', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\NotificationController@all',
        'as' => 'notifications.all',
    ]);

    Route::get('/notifications/all/mark-as-read', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\NotificationController@markAsRead',
        'as' => 'notifications.mark.read',
    ]);

    Route::resource('payments', Nowyouwerkn\WeCommerce\Controllers\PaymentMethodController::class);
    Route::get('/payments/change-status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\PaymentMethodController@changeStatus',
        'as' => 'payments.status',
    ]);
    Route::resource('shipments', Nowyouwerkn\WeCommerce\Controllers\ShipmentMethodController::class);
    Route::resource('shipments-rules', Nowyouwerkn\WeCommerce\Controllers\ShipmentMethodRuleController::class);
    Route::resource('shipping-options', Nowyouwerkn\WeCommerce\Controllers\ShipmentOptionsController::class);

    Route::get('/shipments-rule/change-status/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ShipmentMethodRuleController@changeStatus',
        'as' => 'shipments-rules.status',
    ]);

    //Country
    //Route::resource('countries', Nowyouwerkn\WeCommerce\Controllers\CountryController::class);
    Route::resource('states', Nowyouwerkn\WeCommerce\Controllers\StateController::class);
    Route::resource('cities', Nowyouwerkn\WeCommerce\Controllers\CityController::class);
    Route::resource('config', Nowyouwerkn\WeCommerce\Controllers\StoreConfigController::class);

    Route::post('config-api-token', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StoreConfigController@apiToken',
        'as' => 'api.token.store',
    ]);

    Route::resource('integrations', Nowyouwerkn\WeCommerce\Controllers\IntegrationController::class);
    Route::get('general-preferences', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\IntegrationController@index',
        'as' => 'general.config',
    ]);

    Route::resource('themes', Nowyouwerkn\WeCommerce\Controllers\StoreThemeController::class);
    Route::get('/themes/{id}/cambiar-estado', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\StoreThemeController@changeStatus',
        'as' => 'themes.status',
    ]);

    Route::post('store-logo', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\IntegrationController@storeLogo',
        'as' => 'store.logo',
    ]);

    // Sección Soporte
    Route::get('support', 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@shipping')->name('support.help');

    /* Rutas de Correo */
    Route::post('/resend-order-mail/{order_id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\NotificationController@resendOrder',
        'as' => 'resend.order.mail',
    ]);

    Route::post('/resend-invoice-mail/{invoice_id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\NotificationController@resendInvoice',
        'as' => 'resend.invoice.mail',
    ]);

    // Búsqueda
    Route::get('/busqueda-general', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\DashboardController@generalSearch',
        'as' => 'back.search.query',
    ]);
});

// Shopping Cart
Route::get('/cart/{id}/{variant}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@addCart',
    'as' => 'add-cart',
]);

Route::get('/cart', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@cart',
    'as' => 'cart',
]);

Route::get('/substract/{id}/{variant}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@substractOne',
    'as' => 'cart.substract',
]);

Route::get('/add/{id}/{variant}/{qty}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\CartController@addMore',
    'as' => 'cart.add-more',
]);

Route::get('/delete/{id}/{variant}', [
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

/*
*
*
*
*
*/

// XML Feed para Catálogo Facebook
Route::get('/xml-feed', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@xmlFeed',
    'as' => 'xml.feed',
]);

/*
*
*
*
*
*/

/*
 * FRONT VIEWS
 *
 *
 *
*/
Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@index')->name('index');

Route::get('catalog', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@catalogAll')->name('catalog.all');
Route::get('catalog_promo', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@catalogPromo')->name('catalog.promo');
Route::post('catalog_order', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@catalog_order')->name('catalog.orderby');

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

/* Reseñas */
Route::post('/catalog/{id}/review', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\ReviewController@store',
    'as' => 'reviews.store',
]);

Route::get('/catalog/{id}/review/{filter}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@reviewFilter',
    'as' => 'reviews.filter',
]);

/* Newsletter */
Route::post('registro-newsletter', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@newsletter')->name('newsletter_front.store');

/* Search Functions */
Route::get('/busqueda-general', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\SearchController@query',
    'as' => 'search.query',
]);

/* Carrito */
Route::get('cart', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@cart')->name('cart');

/* Checkout */
Route::get('/checkout', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@checkout')->name('checkout');

Route::get('/checkout/subscription/{subscription_id}', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@checkoutSubscription')->name('checkout.subscription');

Route::post('/checkout', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@postCheckout',
    'as' => 'checkout.store',
]);

Route::post('/checkout/subscription/{subscription_id}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@postCheckoutSubscription',
    'as' => 'checkout.subscription.store',
]);

Route::get('/zip_codes/get', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@zipCodeGet',
    'as' => 'zipcode.get',
]);

Route::get('/paypal/status', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@payPalStatus',
    'as' => 'paypal.status',
]);

/* Cuopon Validation on Checkout */
Route::post('/apply-cuopon', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@applyCuopon',
    'as' => 'apply.cuopon',
]);

/* Recalcular puntos */
// Esta funcion solo aplica para los pagos con mercadopago
Route::post('/payment-preference', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@paymentPreference',
    'as' => 'payment.preference',
]);

/* Recalculate Shipping Options on Checkout */
Route::post('/calculate-shipment-options', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@calculateTotalWithOptions',
    'as' => 'calculate.shipment',
]);

//Profile
Route::group(['prefix' => 'profile', 'middleware' => ['web', 'can:customer_access']], function () {
    Route::get('/', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@profile')->name('profile');
    Route::get('wishlist', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@wishlist')->name('wishlist');
    Route::get('orders', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@shopping')->name('shopping');
    Route::get('points', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@points')->name('points');

    Route::post('orders/{order_id}/request-invoice/{user_id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@invoiceRequest',
        'as' => 'invoice.request',
    ]);

    Route::get('address', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@address')->name('address');
    Route::get('address/{id}/edit', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@editAddress')->name('address.edit');
    Route::get('account', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@account')->name('account');

    Route::put('/account/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@updateAccount',
        'as' => 'profile.update',
    ]);

    Route::put('/address/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@updateAddress',
        'as' => 'address.update',
    ]);

    Route::post('/address-store', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@storeAddress',
        'as' => 'address.store',
    ]);

    Route::delete('/address/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@destroyAddress',
        'as' => 'address.destroy',
    ]);

    Route::get('/user/change-image', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@editImage',
        'as' => 'profile.image',
    ]);

    Route::put('/user/change-image/{id}', [
        'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@updateImage',
        'as' => 'profile.image.update',
    ]);
});

Route::get('/legales/{slug}', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@legalText',
    'as' => 'legal.text',
])->where('slug', '[\w\d\-\_]+');


Route::get('preguntas_frecuentes', 'Nowyouwerkn\WeCommerce\Controllers\FrontController@faqs')->name('faqs.text');

// Orden Completa
Route::get('/compra-exitosa', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@purchaseComplete',
    'as' => 'purchase.complete',
]);

// Seguimiento de Compra
Route::get('/order-tracking', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@orderTracking',
    'as' => 'utilities.tracking.index',
]);

Route::post('/order-tracking', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@orderTrackingStatus',
    'as' => 'utilities.tracking.status',
]);

Route::get('reducir-stock', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\FrontController@reduceStock',
    'as' => 'reduce.stock.test',
]);

/* Webhooks */
Route::get('/webhook', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WebhookController@testJson',
    'as' => 'webhook.test',
]);

Route::post('/webhook/orden_action', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WebhookController@order',
    'as' => 'webhook.order.oxxo',
]);

Route::get('/webhook/mercadopago_status', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WebhookController@orderMercadoPago',
    'as' => 'webhook.order.mercadopago',
]);

Route::get('/webhook/kueski_status', [
    'uses' => 'Nowyouwerkn\WeCommerce\Controllers\WebhookController@orderKueski',
    'as' => 'webhook.kueski',
]);
