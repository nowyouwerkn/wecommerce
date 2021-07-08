@extends('front.layouts.main')

@section('seo')
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ $product->description }}">
<meta property="og:url" content="{{ route('detail', [$product->category->slug , $product->slug])}}">
<meta property="og:image" content="{{ asset('img/products/' . $product->image) }}">
<meta property="product:brand" content="{{ $product->brand->name ?? 'Gearcom'}}">
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="product:gender" content="{{ $product->gender->name ?? 'Men'}}">
<meta property="product:price:amount" content="{{ number_format($product->price,2) }}">
<meta property="product:price:currency" content="USD">

<meta property="product:sale_price:amount" content="{{ number_format($product->discount_price,2) }}">
<meta property="product:sale_price:currency" content="USD">
<meta property="product:sale_price_dates:start" content="{{  Carbon\Carbon::parse($product->discount_start)->format('Y-m-d') .'T00:00-07:00' . '/' . Carbon\Carbon::parse($product->discount_end)->format('Y-m-d') .'T00:00-07:00' }}">
<meta property="product:sale_price_dates:end" content="{{  Carbon\Carbon::parse($product->discount_start)->format('Y-m-d') .'T00:00-07:00' . '/' . Carbon\Carbon::parse($product->discount_end)->format('Y-m-d') .'T00:00-07:00' }}">

<meta property="product:retailer_item_id" content="{{ $product->sku }}">
<meta property="product:item_group_id" content="gm_shoes_{{ $product->sku }}">
<meta property="product:category" content="Apparel &amp; Accessories &gt; Shoes"/>
@endsection

@section('content')
    <!-- Product Detail -->
    <section>
        <div class="container detail mt-5 pt-5 mb-5 pt-5">
            <div class="row">
                <!-- Information -->
                <div class="col-md-4">
                    <!-- Description  -->
                    <p>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                    </p>

                    <h3>{{ $product->name }}</h3>
                    <p>$1500</p>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#">Descripcion</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Materiales</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Envío</a>
                        </li>
                    </ul>
                    <p>{{ $product->description }}</p>

                    <!-- Functions -->
                    @if($variants->count() != 0)            
                    <div class="d-flex">
                        <div>
                            <p>Color: </p>
                        </div>
                        <div>
                            @foreach($variants as $pr)
                            <a class="variant-box" data-toggle="tooltip" data-placement="top" title="{{ $pr->name }}" href="{{ route('product_detail', [$pr->category->slug ?? 'Men', $pr->slug]) }}">
                                @if($pr->image == NULL)
                                <img class="img-fluid mb-3" src="{{ asset('products/' . $pr->style->base_image ) }}">
                                @else
                                <img class="img-fluid mb-3" src="{{ asset('img/front/products/' . $pr->image ) }}">
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="d-flex">
                        <div>
                            <p>Talla: </p>
                        </div>
                        <div>
                            <form action="" method="POST">
                                <input class="form-check-input ms-2" type="radio" name="flexRadioDefault">S
                                <input class="form-check-input ms-2" type="radio" name="flexRadioDefault">M
                                <input class="form-check-input ms-2" type="radio" name="flexRadioDefault" checked>L
                            </form>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('add-cart', ['id' => $product->id]) }}" class="btn btn-primary" role="button">
                            <ion-icon name="cart-outline"></ion-icon> <span>Add to cart</span>
                        </a>

                        @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product->id))
                            <a href="{{ route('wishlist.remove', $product->id) }}" class="btn btn-secondary">
                                <ion-icon name="star-outline"></ion-icon> Remove from Wishlist
                            </a>
                        @else
                            @if(Auth::guest())
                            <a href="{{ route('login') }}" class="btn btn-secondary">
                                <ion-icon name="star"></ion-icon> Add to wishlist
                            </a>
                            @else
                            <a href="{{ route('wishlist.add', $product->id) }}" class="btn btn-secondary">
                                <ion-icon name="star"></ion-icon> Add to wishlist
                            </a>
                            @endif
                        @endif
                      </div>
                </div>

                <!-- Images -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-10">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                        </div>
                        <div class="col-md-2">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information -->
    <section>
        <div class="container px-4 py-5">
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                    <ion-icon name="cart-outline"></ion-icon>
                    </div>
                    <h2>Compra Segura</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis.</p>
                </div>
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                    <h2>Sitio Seguro</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis fugiat quis ipsam eius vitae.</p>
                </div>
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                    <ion-icon name="shield-checkmark-outline"></ion-icon>
                    </div>
                    <h2>Información Protegida</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis, fugiat quis ipsam eius vitae</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Discount -->
    <section>
        <div class="container mt-5 recommend">
            <div class="row">
                <div class="col-md-3">
                    <p>Recomendado</p>
                    <h3>Te podrian gustar</h3>
                    <p>Gran calidad a mejores precios</p>
                    <a href="#" class="btn btn-primary">Comprar ahora</a>
                </div>

                <div class="col-md-9">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection