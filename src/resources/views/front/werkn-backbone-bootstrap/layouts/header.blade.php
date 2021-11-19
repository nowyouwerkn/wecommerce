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
    <div class="container">
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
</nav>