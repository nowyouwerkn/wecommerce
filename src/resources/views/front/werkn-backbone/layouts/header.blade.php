<header class="header-style-five">
    <div class="header-top-wrap">
        <div class="container custom-container-two">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6">
                    <div class="header-top-link">
                        <ul>
                            <li><a href="mailto:contacto@mail.com">contacto@mail.com</a></li>
                            <li><a href="tel:123456789">Tel. +52 1 477 555 55 55</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header-top-right">
                        <div class="lang">
                            <select name="select">
                                <option value="">English</option>
                                <option value="" selected>Español</option>
                            </select>
                        </div>
                        <div class="currency">
                            <form action="#">
                                <select name="select">
                                    <option value="">USD</option>
                                    <option value="">EUR</option>
                                    <option value="" selected="">MXN</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="main-header menu-area">
        <div class="container custom-container-two">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                    <div class="menu-wrap">
                        <nav class="menu-nav show">
                            <div class="logo d-block d-lg-none">
                                <a href="{{ route('index') }}"><img src="{{ asset('themes/werkn-backbone/img/logo/logo.svg') }}" alt="Logo"></a>
                            </div>
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                @php
                                    $categories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();

                                    $main_categories = Nowyouwerkn\WeCommerce\Models\Category::inRandomOrder()->where('parent_id', 0)->orWhere('parent_id', NULL)->take(2)->get();
                                @endphp

                                <ul class="navigation left">
                                    <li class="active"><a href="{{ route('index') }}">Inicio</a></li>

                                    <li class="has--mega--menu"><a href="#">Catálogo</a>
                                        <ul class="mega-menu">
                                            <li class="mega-menu-wrap">
                                                @foreach($categories as $category)
                                                <ul class="mega-menu-col">
                                                    <li class="mega-title"><a href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a></li>
                                                    @foreach($category->children as $sub)
                                                    <li><a href="{{ route('catalog', $sub->slug) }}">{{ $sub->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                                @endforeach

                                                @foreach($main_categories as $category)
                                                <ul class="mega-menu-col sub-cat-post">
                                                    <li>
                                                        <a href="{{ route('catalog', $category->slug) }}">
                                                            @if($category->image == NULL)
                                                            <img src="{{ asset('img/categories/no_category.jpg') }}" alt="" style="min-height: 250px;">
                                                            @else
                                                            <img src="{{ asset('img/categories/' . $category->image) }}" alt="">
                                                            @endif

                                                            <span class="btn">{{ $category->name }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <div class="logo">
                                    <a href="{{ route('index') }}">
                                        @if(!empty($store_config))
                                            @if($store_config->store_logo == NULL)
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="width: 55%;margin: 0 auto;display: block;">
                                            @else
                                            <img src="{{ asset('assets/img/' . $store_config->store_logo) }}" alt="Logo" style="width: 55%;margin: 0 auto;display: block;">
                                            @endif
                                        @else
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="width: 55%;margin: 0 auto;display: block;">
                                        @endif
                                    </a>
                                </div>

                                <ul class="navigation right">
                                    <!--
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="contact.html">Contáctanos</a></li>
                                    -->
                                </ul>
                            </div>
                            <div class="header-action d-none d-md-block">
                                <ul>
                                    <li class="header-search"><a href="#" data-toggle="modal" data-target="#search-modal"><i class="flaticon-search"></i></a></li>
                                    <li class="header-profile"><a href="{{ route('login') }}"><i class="flaticon-user"></i></a></li>
                                    <li class="header-wishlist"><a href="{{ route('wishlist') }}"><i class="flaticon-heart-shape-outline"></i></a></li>

                                    @if(request()->is('checkout'))

                                    @else
                                    <li class="header-shop-cart"><a href="#"><i class="flaticon-shopping-bag"></i><span>{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span></a>
                                        <ul class="minicart">
                                        @if(Session::has('cart'))
                                        @php
                                            $oldCart = Session::get('cart');
                                            $cart = new Nowyouwerkn\WeCommerce\Models\Cart($oldCart);

                                            $products = $cart->items;
                                            $totalPrice = $cart->totalPrice;

                                            $card_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', '!=','Paypal')->where('type', 'card')->where('is_active', true)->first();
                                            $cash_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
                                            $paypal_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();
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
                                                    @if(!empty($paypal_payment))
                                                    <a class="black-color" href="{{ route('checkout.paypal') }}">Pagar con Paypal</a>
                                                    @endif

                                                    @if(!empty($card_payment))
                                                    <a class="black-color" href="{{ route('checkout') }}">Pagar con Tarjeta</a>
                                                    @endif

                                                    @if(!empty($cash_payment))
                                                    <a class="black-color" href="{{ route('checkout.cash') }}">Pagar en Efectivo</a>
                                                    @endif
                                                </div>
                                            </li>

                                            <li>
                                                @guest
                                                <p class="alert alert-warning" style="display: inline-block;"><ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Estas comprando como <strong>invitado.</strong> Compra más rápido creando una cuenta <a href="{{ route('register') }}">Regístrate</a></p>
                                                @endguest
                                            </li>
                                        @else
                                        <li><h4>No hay productos en tu carrito. <ion-icon name="sad"></ion-icon></h4></li>
                                        
                                        @endif
                                        </ul>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="mobile-menu">
                        <div class="close-btn"><i class="flaticon-targeting-cross"></i></div>
                        <nav class="menu-box">
                            <div class="nav-logo"><a href="{{ route('index') }}"><img src="{{ asset('themes/werkn-backbone/img/logo/logo.svg') }}" alt="" title=""></a>
                            </div>
                            <div class="menu-outer">
                                <ul class="navigation">
                                    <li class="active menu-item-has-children"><a href="{{ route('index') }}">Inicio</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('index') }}">Home One</a></li>
                                            <li><a href="index-2.html">Home Two</a></li>
                                            <li><a href="index-3.html">Home Three</a></li>
                                            <li><a href="index-4.html">Home Four</a></li>
                                            <li><a href="index-5.html">Home Five</a></li>
                                            <li class="active"><a href="index-6.html">Home Six</a></li>
                                            <li><a href="index-7.html">Home Seven</a></li>
                                            <li><a href="index-8.html">Home Eight</a></li>
                                            <li><a href="index-9.html">Home Nine</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="#">Catálogo</a>
                                        <ul class="submenu">
                                            <li><a href="shop.html">Shop Page</a></li>
                                            <li><a href="shop-sidebar.html">Shop Sidebar</a></li>
                                            <li><a href="shop-details.html">Shop Details</a></li>
                                            <li><a href="cart.html">Cart Page</a></li>
                                            <li><a href="cart.html">Checkout Page</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about-us.html">Acerca de</a></li>
                                    <li class="menu-item-has-children"><a href="#">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="blog.html">Our Blog</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contáctanos</a></li>
                                </ul>
                            </div>
                            <div class="social-links">
                                <ul class="clearfix">
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="menu-backdrop"></div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Search -->
    <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form role="search" action="{{ route('search.query') }}">
                    <input type="search" name="query" placeholder="Busca aqui...">
                    <button type="submit"><i class="flaticon-search"></i></button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Search-end -->
</header>