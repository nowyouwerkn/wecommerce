@php
    $categories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get(['name', 'slug', 'image']);
@endphp

<header class="bg-dark text-white py-2">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a class="contact_action" href="mailto:{{ $store_config->contact_email }}">{{ $store_config->contact_email }}</a></li>

                    @if($store_config->phone != NULL)
                    <li class="list-inline-item"><a class="contact_action" href="tel:{{ $store_config->phone }}">Tel. {{ $store_config->phone }}</a></li>
                    @endif
                </ul>
            </div>

            <div class="col-md-6 text-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('utilities.tracking.index') }}"><ion-icon name="compass-outline"></ion-icon> Seguimiento de Orden</a></li>

                    <li class="list-inline-item">
                        <select class="form-select form-select-sm" disabled>
                            <option value="">English</option>
                            <option value="" selected>Español</option>
                        </select>
                    </li>
                    <li class="list-inline-item">
                        <select class="form-select form-select-sm" disabled>
                            <option value="">USD</option>
                            <option value="">EUR</option>
                            <option value="" selected="">MXN</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<nav class="pt-3 pb-3">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-5">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="{{ route('index') }}">Inicio</a></li>

                    @foreach($categories as $category)
                        @if($category->children->count() == 0)
                            <li class="list-inline-item mr-4">
                                <a href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a>
                            </li>
                        @else
                            <li class="list-inline-item has-menu-card mr-4" style="display: inline-flex;">
                                <a href="javascript:void(0)">
                                    {{ $category->name }} <ion-icon name="caret-down-outline"></ion-icon>
                                </a>

                                <div class="menu-card card-categories d-flex">
                                    <div class="row col-md-12 p-0">
                                        <div class="col-md-4 p-0">
                                            @if($category->image == NULL)
                                                <img class="img-fluid" src="{{ asset('themes/werkn-backbone-bootstrap/img/front/categories/no-category.jpg') }}" alt="{{ $category->name }}">
                                            @else
                                               <img class="img-fluid" src="{{ asset('img/categories/' . $category->image) }}" alt="Sin imágen">
                                            @endif
                                        </div>
                                        <div class="col-md-6 p-4 bg-light">
                                            <ul class="list-inline pl-4">
                                                <li class="mt-3">
                                                    <a href="{{ route('catalog', $category->slug) }}">Ver todo</a>
                                                </li>
                                                @foreach($category->children as $sub)
                                                    <li class="mt-3">
                                                        <a href="{{ route('catalog', $sub->slug) }}">{{ $sub->name }}</a>
                                                    </li>
                                                @endforeach  
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-2">
                <a href="{{ route('index') }}">
                    @if(!empty($store_config))
                        @if($store_config->store_logo == NULL)
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" width="200">
                        @else
                        <img src="{{ asset('assets/img/' . $store_config->store_logo) }}" alt="Logo" class="img-fluid" width="200">
                        @endif
                    @else
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" width="200">
                    @endif
                </a>    
            </div>
            <div class="col-5 text-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#search-modal"><ion-icon name="search"></ion-icon></a></li>
                    <li class="list-inline-item"><a href="{{ route('login') }}"><ion-icon name="person"></ion-icon></a></li>
                    <li class="list-inline-item"><a href="{{ route('wishlist') }}"><ion-icon name="heart"></ion-icon></a></li>

                    @if(request()->is('checkout'))

                    @else
                    <li class="list-inline-item has-menu-card" style="display: inline-flex;">
                        <a href="javascript:void(0)">
                            <ion-icon name="bag"></ion-icon>
                            <span>{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                        </a>

                        <div class="menu-card mini-cart d-flex">
                            <div>
                                @if(Session::has('cart'))
                                    @php
                                        $oldCart = Session::get('cart');
                                        $cart = new Nowyouwerkn\WeCommerce\Models\Cart($oldCart);

                                        $products = $cart->items;
                                        $totalPrice = $cart->totalPrice;
                                    @endphp
                                    
                                    @foreach($products as $product)
                                    @php
                                        $item_img = $product['item']['image'];
                                        $variant = $product['variant'];
                                    @endphp

                                    <li class="d-flex align-items-start">
                                        <div class="cart-img">
                                            <a href="#"><img src="{{ asset('img/products/' . $item_img ) }}" alt="{{ $product['item']['name'] }}"></a>
                                        </div>
                                        <div class="cart-content">
                                            <h4 class="mb-0"><a href="#">{{ $product['item']['name'] }}</a></h4>
                                            <p class="mb-2">Talla: {{ $variant }}</p>
                                            <div class="cart-price">
                                                @if($product['item']['has_discount'] == true)
                                                <span class="new">${{ number_format($product['item']['discount_price'],2) }}</span>
                                                <span><del>${{ number_format($product['item']['price'],2) }}</del></span>
                                                @else 
                                                <span class="new">${{ number_format($product['item']['price'],2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="del-icon">
                                            <a href="{{ route( 'cart.delete', ['id' => $product['item']['id'], 'variant' => $variant ] ) }}"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                    </li>
                                    @endforeach
                                    <li>
                                        <div class="total-price">
                                            <span class="f-left">Subtotal:</span>
                                            <span class="f-right">${{ number_format($totalPrice, 2) }}</span>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <div class="checkout-link">
                                            <a href="{{ route('cart') }}">Ver tu carrito</a>

                                            <a class="black-color" href="{{ route('checkout') }}">Completar tu compra</a>
                                        </div>
                                    </li>

                                    <li>
                                        @guest
                                        <p class="alert alert-warning" style="display: inline-block;">
                                            <ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Estas comprando como <strong>invitado.</strong> Compra más rápido creando una cuenta <a href="{{ route('register') }}">Regístrate</a>
                                        </p>
                                        @endguest
                                    </li>
                                @else
                                    <p class="mb-0 d-flex align-items-center">
                                        No hay productos en tu carrito. 
                                        <ion-icon name="sad-outline"></ion-icon>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>       
            </div>
        </div>
    </div>
</nav>