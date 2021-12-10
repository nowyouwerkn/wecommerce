@php
    $categories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get(['name', 'slug', 'image']);
@endphp
<style type="text/css">
    /* --- Nav-mobile-wrap --- */
#sidebar-wrapper {
    position: fixed;
    height: 100%;
    z-index: 3000;
    width: 85%;
    overflow-x: hidden;
    overflow-y: scroll;
    transition: all 0.5s ease;
    left: -85%;
    background: #fff;
    /**/
    display: flex;
    flex-direction: column;
    height: 100%;
    margin-top: -90px; 
}

.sidebar-overlay {
    background: rgba(0, 0, 0, 0.3);
    z-index: -1;
    position: fixed;
    width: 100%;
    height: 150%;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s ease;
    transform: translate3d(-260px, 0, 0);
}

.navbar-responsive {
    display: none;
    }

body.toggled #sidebar-wrapper {
    left: 0%;
}

body.toggled {
    overflow-y: hidden;
}

body.toggled .sidebar-overlay {
    opacity: 1;
    transform: translateX(0);
    z-index: 2001;
}
/* user */
.sidebar-user {
    width: 100%;
    height: 50%;
    display: flex;
    align-content: flex-start;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    flex: 1;
}
.sidebar-user .item {
    width: 50%;
    height: 50%;
    background: black;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    font-weight: 100;
}
.sidebar-user .item ion-icon {
    font-size: 1.4rem;
    padding: 0.4rem 0rem;
}

/* menu */
.sidebar-menu {
    flex: 1;
    width: 100%;
    overflow-y: auto;
}
.sidebar-menu ul {
    list-style: none;
    padding: 0rem;
}
.sidebar-menu li {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.8rem;
    padding: 0.85rem 1.4rem;
}
.sidebar-menu li.title {
    background: #f8f8f8 !important;
    font-weight: bold;
    font-size: 0.6rem;
}
.sidebar-menu a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #000000 !important;
    font-size: 0.75rem;
}

.sidebar-content {
    height: 50%;
    overflow-y: auto;
}
.sidebar-image {
    height: 50%;
}
.sidebar-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


/* collapse */
.collapse-item {
    position: absolute;
    top: 0;
    right: -100%;
    width: 100%;
    height: 100%;
    background: white;
    z-index: 5;
    transition: right 0.35s !important;
}
.collapsing {
    height: 100% !important;
    transition: height 0s !important;
    right: -100%;
    transition: right 0.35s !important;
}
.collapse.show {
    right: 0% !important;
    transition: right 0.35s !important;
}
@media (max-width: 760px) {
    .navbar-desktop {
    display: none;
    }

    .navbar-responsive {
    display: block;
    }
}


</style>

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
<nav class="pt-3 pb-3 mb-5">
    <div class="container navbar-desktop">
        <div class="row justify-content-between align-items-center">
            <div class="col-5">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item btn"><a href="{{ route('index') }}">Inicio</a></li>
                     <div class="dropdown list-inline-item">
                      <button class="btn btn-info dropdown-toggle" type="button" id="dropdownCatalog" data-bs-toggle="dropdown" aria-expanded="false">
                        Catalogo
                      </button>
                        <ul class="dropdown-menu justify-content-between list-group-flush" aria-labelledby="dropdownCatalog">
                            <li class="list-group-item"><a href="{{ route('catalog.all') }}">Ver todos</a></li>
                           @foreach($categories as $category)
                           <li class="list-group-item"> <a  href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a></li>
                             @endforeach
                        </ul>
                        <li class="list-inline-item btn"><a href="{{ route('catalog.promo') }}">Promociones</a></li>
                    </div>
               
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
                     <li class="list-inline-item"><a href="{{ route('utilities.tracking.index') }}"><ion-icon name="compass-outline"></ion-icon> </a></li>
                    <li class="list-inline-item"><a href="{{ route('login') }}"><ion-icon name="person"></ion-icon></a></li>
                    <li class="list-inline-item"><a href="{{ route('wishlist') }}"><ion-icon name="heart"></ion-icon></a></li>

                    @if(request()->is('checkout'))

                    @else
                   <div class="dropdown" style="display: inline-flex;">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <ion-icon name="bag"></ion-icon>
                        <span>{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                      </a>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 20rem; padding: 10px;">
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

                        <li>
                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                    <div class="card-body d-flex flex-column align-items-start">
                                      <strong class="d-inline-block mb-2 text-primary">{{ $product['item']['category']['name'] }}</strong>
                                      <h3 class="mb-0">
                                        <a class="text-dark" href="#">{{ $product['item']['name'] }}</a>
                                      </h3>
                                      <p class="card-text mb-auto">{{ $product['item']['description'] }}</p>
                                      <p class="card-text mb-auto">{{ $variant}}</p>
                                        @if($product['item']['has_discount'] == true)
                                                <span class="new">${{ number_format($product['item']['discount_price'],2) }}</span>
                                                <span><del>${{ number_format($product['item']['price'],2) }}</del></span>
                                                @else 
                                                <span class="new">${{ number_format($product['item']['price'],2) }}</span>
                                                @endif
                                    </div>
                                    <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="{{ asset('img/products/' . $item_img ) }}" data-holder-rendered="true">
                                  </div>
                                    <div class="mx-2 d-flex mb-2">
                                        <span class="f-left">Subtotal:</span>
                                        <span class="f-right">${{ number_format($totalPrice, 2) }}</span> 
                                    </div>
                             
                           
                                        <div class="d-flex">

                                            <a class="btn btn-primary mx-2 mb-2" href="{{ route('cart') }}">Ver tu carrito</a>

                                            <a class="btn btn-secondary mx-2 mb-2" href="{{ route('checkout') }}">Completar tu compra</a>
                                        </div>
                                        </li>@endforeach
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
                      </ul>
                    </div>

                    @endif
                </ul>       
            </div>
        </div>
    </div>


        <div class="container navbar-responsive">
        <div class="row justify-content-between align-items-center">
            <div class="col-5">
                   <div class="nav-mobile-icon col-3" onclick="toggleMenu()">
                <a>
                    <ion-icon name="menu-outline"></ion-icon>
                </a>
            </div>
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

                    @if(request()->is('checkout'))

                    @else
                   <div class="dropdown" style="display: inline-flex;">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <ion-icon name="bag"></ion-icon>
                        <span>{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                      </a>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 20rem; padding: 10px;">
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

                        <li>
                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                    <div class="card-body d-flex flex-column align-items-start">
                                      <strong class="d-inline-block mb-2 text-primary">{{ $product['item']['category']['name'] }}</strong>
                                      <h3 class="mb-0">
                                        <a class="text-dark" href="#">{{ $product['item']['name'] }}</a>
                                      </h3>
                                      <p class="card-text mb-auto">{{ $product['item']['description'] }}</p>
                                      <p class="card-text mb-auto">{{ $variant}}</p>
                                        @if($product['item']['has_discount'] == true)
                                                <span class="new">${{ number_format($product['item']['discount_price'],2) }}</span>
                                                <span><del>${{ number_format($product['item']['price'],2) }}</del></span>
                                                @else 
                                                <span class="new">${{ number_format($product['item']['price'],2) }}</span>
                                                @endif
                                    </div>
                                    <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="{{ asset('img/products/' . $item_img ) }}" data-holder-rendered="true">
                                  </div>
                                    <div class="mx-2 d-flex mb-2">
                                        <span class="f-left">Subtotal:</span>
                                        <span class="f-right">${{ number_format($totalPrice, 2) }}</span> 
                                    </div>
                             
                           
                                        <div class="d-flex">

                                            <a class="btn btn-primary mx-2 mb-2" href="{{ route('cart') }}">Ver tu carrito</a>

                                            <a class="btn btn-secondary mx-2 mb-2" href="{{ route('checkout') }}">Completar tu compra</a>
                                        </div>
                                        </li>@endforeach
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
                      </ul>
                    </div>

                    @endif
                </ul>       
            </div>
        </div>
    </div>
<!-- Sidebar Responsive -->
<div class="sidebar-overlay"></div>
<div id="sidebar-wrapper">
    <!-- store -->
    <div class="sidebar-menu">
        <ul>
            <li class="title closed-menu">
                <a>
                    <span>Cerrar</span>
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            </li>
            @php
                $categories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
            @endphp
            @foreach($categories as $category)
                @if($category->children->count() == 0)
                    <li>
                        <a href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('catalog', $category->slug) }}" data-toggle="collapse" data-target="#{{ $category->id }}" aria-expanded="false" aria-controls="{{ $category->id }}">
                            {{ $category->name }} 
                            <ion-icon name="chevron-forward-outline"></ion-icon>
                        </a>
                    </li>
                    <div class="collapse collapse-item" id="{{ $category->id }}" data-parent="#accordion">
                        <!-- items -->
                        <div class="sidebar-content">
                            <!-- title -->
                            <li class="title">
                                <a data-toggle="collapse" data-target="#{{ $category->id }}" aria-expanded="false" aria-controls="{{ $category->id }}">
                                    <ion-icon name="chevron-back-outline"></ion-icon>
                                    {{ $category->name }} 
                                </a>
                            </li>
                            @foreach($category->children as $sub)
                                <li>
                                    <a href="{{ route('catalog', $sub->slug) }}">{{ $sub->name }}</a>
                                </li>
                            @endforeach  
                            <li>
                                <a href="{{ route('catalog', $category->slug) }}">Ver todo</a>
                            </li>
                        </div>

                        <!-- image -->
                        <div class="sidebar-image">
                            @if($category->image == NULL)
                                <img src="{{ asset('themes/arenas/img/front/categories/no-category.jpg') }}" alt="{{ $category->name }}" style="width: 100%; height:100%; object-fit:cover">
                            @else
                                <img src="{{ asset('img/categories/' . $category->image) }}" alt="" style="width: 100%; height:100%; object-fit:cover">
                            @endif
                        </div>
                    </div> 
                @endif
            @endforeach
            <hr>
             <li><a class="link link--metis" href="{{ route('utilities.tracking.index') }}">Seguimiento de Orden</a></li>
        </ul>
    </div>
    <!-- user -->
    <div class="sidebar-user">
        @guest
            <a href="{{ route('login') }}" class="item closed-menu" data-toggle="modal" data-target="#modal-access"><ion-icon name="person-outline"></ion-icon>Login</a>
            <a href="{{ route('catalog.all') }}" class="item"><ion-icon name="storefront-outline"></ion-icon> Catálogo</a>
            <a href="{{ route('cart') }}" class="item"> <ion-icon name="bag-outline"></ion-icon> Bolsa</a>
        @else
            <a href="{{ route('profile') }}" class="item"><ion-icon name="person-outline"></ion-icon> Mi Cuenta</a>
            <a href="{{ route('wishlist') }}" class="item"><ion-icon name="heart-outline"></ion-icon> Wishlist</a>
            <a href="{{ route('cart') }}" class="item"> <ion-icon name="bag-outline"></ion-icon> Bolsa</a>
            <a href="" class="item">
                <ion-icon name="log-out-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></ion-icon> Salir
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        @endguest
    </div>
</div>

</nav>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $("#menu-mobile").on("click", function () {
      toggleMenu();
    });

    $(".sidebar-overlay").on("click", function () {
      $("body").removeClass("toggled");
      $(".clonado").remove();
    });

    $(".closed-menu").on("click", function () {
  $("body").removeClass("toggled");
  $(".clonado").remove();
});

$(".close-btn").on("click", function () {
  $("body").removeClass("toggled");
  $(".clonado").remove();
});

$(".close-sidebar").on("click", function () {
  $("body").removeClass("toggled");
  $(".clonado").remove();
});
    function toggleMenu() {
  $("body").addClass("toggled");
    }
</script>