@extends('wecommerce::front.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<!-- slider-area -->
<section class="home-five-banner">
    <div class="container-fluid p-0" style="background:#f9f8f5;">
        <!--<div class="banner-five-wrap" data-background="{{ asset('themes/werkn-backbone/img/slider/h5_banner_bg.jpg') }}">-->
        <div class="banner-five-wrap">
            <div class="row">
                <div class="col-12">
                    @if(empty($banner))
                        <h2>No se ha configurado un banner</h2>
                    @else
                    <div class="slider-content">
                        <h3 class="sub-title wow fadeInUp" data-wow-delay=".2s">{{ $banner->subtitle }}</h3>
                        <h2 class="title wow fadeInUp" data-wow-delay=".4s">{{ $banner->title }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ $banner->text }}</p>

                        @if($banner->has_button == true)
                        <a href="{{ $banner->link }}" class="btn wow fadeInUp" data-wow-delay=".8s">{{ $banner->text_button }}</a>
                        @endif
                    </div>
                    @endif

                    <!--
                    <div class="slider-content">
                        <h3 class="sub-title wow fadeInUp" data-wow-delay=".2s">¡Venta <span>Diurna !</span></h3>
                        <h2 class="title wow fadeInUp" data-wow-delay=".4s">Nueva temporada SS-21 - Moda Fashion</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Obtén hasta un 50% de descuento este fin de semana.</p>
                        <a href="{{ route('catalog.all') }}" class="btn wow fadeInUp" data-wow-delay=".8s">Comprar ahora</a>
                    </div>
                    -->
                </div>
            </div>
            <div class="banner-five-img">
                <!--<img src="{{ asset('themes/werkn-backbone/img/slider/h5_banner_img.png') }}" alt="" class="main-img">-->

                @if(empty($banner))
                    <h2>No se ha configurado un banner</h2>
                @else
                <img src="{{ asset('img/banners/' . $banner->image ) }}" alt="" class="main-img">
                @endif
                <div class="product-tooltip" style="left: 48%; top: 41%;">
                    <div class="tooltip-btn"></div>
                    <div class="features-product-item product-tooltip-item">
                        <div class="close-btn"><i class="flaticon-targeting-cross"></i></div>
                        <div class="features-product-thumb">
                            <a href="shop-details.html">
                                <img src="{{ asset('themes/werkn-backbone/img/product/features_product02.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="features-product-content">
                            <div class="rating">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <h5><a href="shop-details.html">Exclusive Handbags</a></h5>
                            <p class="price">$45.00</p>
                            <div class="features-product-bottom">
                                <ul>
                                    <li class="color-option">
                                        <span class="gray"></span>
                                        <span class="cyan"></span>
                                        <span class="orange"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="features-product-cart"><a href="cart.html">agregar al</a></div>
                    </div>
                </div>
                <div class="product-tooltip" style="left: 10%; bottom: 22%">
                    <div class="tooltip-btn"></div>
                    <div class="features-product-item product-tooltip-item bottom">
                        <div class="close-btn"><i class="flaticon-targeting-cross"></i></div>
                        <div class="features-product-thumb">
                            <a href="shop-details.html">
                                <img src="{{ asset('themes/werkn-backbone/img/product/features_product03.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="features-product-content">
                            <div class="rating">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <h5><a href="shop-details.html">Exclusive Handbags</a></h5>
                            <p class="price">$45.00</p>
                            <div class="features-product-bottom">
                                <ul>
                                    <li class="color-option">
                                        <span class="gray"></span>
                                        <span class="cyan"></span>
                                        <span class="orange"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="features-product-cart"><a href="cart.html">agregar al</a></div>
                    </div>
                </div>

                <img src="{{ asset('themes/werkn-backbone/img/slider/h5_banner_shape.png') }}" alt="" class="img-shape">
            </div>
        </div>
    </div>
</section>
<!-- slider-area-end -->


<!-- category-area -->
<div class="category-banner-area mt-4 pt-2">
    <div class="container custom-container-two">            
        <div class="row justify-content-center">
            @foreach($main_categories as $category)
                <div class="col-lg-3 col-md-6 col-sm-8">
                    <div class="cat-banner-item mb-20">
                        <div class="thumb">
                            <a href="{{ route('catalog', $category->slug) }}"><img src="{{ asset('img/categories/' . $category->image) }}" alt=""></a>
                        </div>
                        <div class="content">
                            <span>Colección</span>
                            <h3><a href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a></h3>
                            <a href="{{ route('catalog', $category->slug) }}" class="btn">Comprar Ahora</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!--
            <div class="col-lg-6 col-sm-8">
                <div class="cat-banner-item style-two mb-20">
                    <div class="thumb">
                        <a href="{{ route('catalog.all') }}"><img src="{{ asset('themes/werkn-backbone/img/images/cat_banner_img04.jpg') }}" alt=""></a>
                    </div>
                    <div class="content">
                        <span>Nueva Colección</span>
                        <h3><a href="{{ route('catalog.all') }}">Ropa Deportiva</a></h3>
                        <a href="{{ route('catalog.all') }}" class="btn">Comprar Ahora</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="cat-banner-item mb-20">
                    <div class="thumb">
                        <a href="{{ route('catalog.all') }}"><img src="{{ asset('themes/werkn-backbone/img/images/cat_banner_img02.jpg') }}" alt=""></a>
                    </div>
                    <div class="content">
                        <span>Nueva Colección</span>
                        <h3><a href="{{ route('catalog.all') }}">Hombres</a></h3>
                        <a href="{{ route('catalog.all') }}" class="btn">Comprar Ahora</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="cat-banner-item mb-20">
                    <div class="thumb">
                        <a href="{{ route('catalog.all') }}"><img src="{{ asset('themes/werkn-backbone/img/images/cat_banner_img03.jpg') }}" alt=""></a>
                    </div>
                    <div class="content">
                        <span>Nueva Colección</span>
                        <h3><a href="{{ route('catalog.all') }}">Mujeres</a></h3>
                        <a href="{{ route('catalog.all') }}" class="btn">Comprar Ahora</a>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</div>
<!-- category-area-end -->

<!-- new-arrival-area -->
<section class="new-arrival-area home7-new-arrival pt-95 pb-50">
    <div class="container custom-container-two">
        <div class="row">
            <!--
            <div class="col-xl-5 col-lg-6">
                <div class="section-title text-center text-lg-left mb-45">
                    <h3 class="title">Nuestros Productos</h3>
                </div>
                <div class="discount-end-time-wrap mb-50">
                    <img src="{{ asset('themes/werkn-backbone/img/images/discount_end_img02.jpg') }}" alt="">
                    <div class="content">
                        <div class="icon">
                            <img src="{{ asset('themes/werkn-backbone/img/icon/sidebar_toggle_icon.png') }}" alt="" width="40">
                        </div>
                        <h2 class="text-white">Cyber Monday</h2>
                        <span>Super oferta - hasta 50% de descuento</span>
                        <div class="coming-time" data-countdown="2021/9/21"></div>
                        <a href="{{ route('catalog.all') }}" class="btn">Comprar ahora</a>
                    </div>
                </div>
            </div>
            -->
            <div class="col-xl-12 col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <div class="new-arrival-nav mb-35">
                            <button class="active" data-filter="*">Favoritos</button>
                            <button class="" data-filter=".cat-one">Productos nuevos</button>
                            <button class="" data-filter=".cat-two">Promociones</button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 d-none d-md-block">
                        <div class="new-arrival-all">
                            <a href="shop.html"><i class="fas fa-arrows-alt"></i> Ver todo</a>
                        </div>
                    </div>
                </div>
                <div class="row new-arrival-active">
                    @foreach($products as $product_info)
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-two">
                        @include('front.werkn-backbone.layouts._product_card')
                    </div>
                    @endforeach

                    <!--
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-one">
                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25">
                                <div class="discount-tag">- 20%</div>
                                <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product02.jpg') }}" alt=""></a>
                                <div class="product-overlay-action">
                                    <ul>
                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                        <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h5><a href="shop-details.html">Travelling Bags</a></h5>
                                <span class="price">$25.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-two cat-one">
                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25">
                                <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product03.jpg') }}" alt=""></a>
                                <div class="product-overlay-action">
                                    <ul>
                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                        <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h5><a href="shop-details.html">Exclusive Handbags</a></h5>
                                <span class="price">$19.50</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-two">
                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25">
                                <div class="discount-tag new">Nuevo</div>
                                <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product04.jpg') }}" alt=""></a>
                                <div class="product-overlay-action">
                                    <ul>
                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                        <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h5><a href="shop-details.html">Women Shoes</a></h5>
                                <span class="price">$12.90</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-one">
                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25">
                                <div class="discount-tag">- 20%</div>
                                <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product05.jpg') }}" alt=""></a>
                                <div class="product-overlay-action">
                                    <ul>
                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                        <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h5><a href="shop-details.html">Winter Jackets</a></h5>
                                <span class="price">$49.90</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-two cat-one">
                        <div class="new-arrival-item text-center mb-50">
                            <div class="thumb mb-25">
                                <div class="discount-tag new">Nuevo</div>
                                <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product06.jpg') }}" alt=""></a>
                                <div class="product-overlay-action">
                                    <ul>
                                        <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                        <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="content">
                                <h5><a href="shop-details.html">Fashion Shoes</a></h5>
                                <span class="price">$31.99</span>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- new-arrival-area-end -->

<!-- discount-area -->
{{-- 
<section class="discount-area discount-bg jarallax parallax-img" data-background="{{ asset('themes/werkn-backbone/img/bg/discount_bg.jpg') }}">
    <div class="container">
        <div class="row justify-content-center justify-content-lg-start">
            <div class="col-lg-6 col-md-10">
                <div class="discount-content text-center">
                    <div class="icon mb-15"><img src="{{ asset('themes/werkn-backbone/img/icon/discount_icon.png') }}" alt=""></div>
                    <span>ÚLTIMAS PIEZAS</span>
                    <h2>Ventas de temporada SS-20. Descuentos hasta del 70%</h2>
                    <a href="{{ route('catalog.all') }}" class="btn">Comprar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>
--}}
<!-- discount-area-end -->

<!-- best-selling-area -->
<section class="best-selling-area pt-95 pb-100">
    <div class="container custom-container-two">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-6">
                <div class="section-title title-style-two text-center mb-50">
                    <h3 class="title">Productos más vendidos</h3>
                </div>
            </div>
        </div>
        <div class="row best-selling-active">
            @foreach($products as $product)
            <div class="col">
                @include('front.werkn-backbone.layouts._product_card')
            </div>
            @endforeach

            <!--
            <div class="col">
                <div class="new-arrival-item text-center mb-50">
                    <div class="thumb mb-25">
                        <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product02.jpg') }}" alt=""></a>
                        <div class="product-overlay-action">
                            <ul>
                                <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <h5><a href="shop-details.html">Travelling Bags</a></h5>
                        <span class="price">$29.00</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="new-arrival-item text-center mb-50">
                    <div class="thumb mb-25">
                        <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product03.jpg') }}" alt=""></a>
                        <div class="product-overlay-action">
                            <ul>
                                <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <h5><a href="shop-details.html">Travelling Bags</a></h5>
                        <span class="price">$29.00</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="new-arrival-item text-center mb-50">
                    <div class="thumb mb-25">
                        <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product04.jpg') }}" alt=""></a>
                        <div class="product-overlay-action">
                            <ul>
                                <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <h5><a href="shop-details.html">Travelling Bags</a></h5>
                        <span class="price">$29.00</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="new-arrival-item text-center mb-50">
                    <div class="thumb mb-25">
                        <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product05.jpg') }}" alt=""></a>
                        <div class="product-overlay-action">
                            <ul>
                                <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <h5><a href="shop-details.html">Travelling Bags</a></h5>
                        <span class="price">$29.00</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="new-arrival-item text-center mb-50">
                    <div class="thumb mb-25">
                        <a href="shop-details.html"><img src="{{ asset('themes/werkn-backbone/img/product/n_arrival_product06.jpg') }}" alt=""></a>
                        <div class="product-overlay-action">
                            <ul>
                                <li><a href="cart.html"><i class="far fa-heart"></i></a></li>
                                <li><a href="{{ route('catalog.all') }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content">
                        <h5><a href="shop-details.html">Travelling Bags</a></h5>
                        <span class="price">$29.00</span>
                    </div>
                </div>
            </div>
            -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="best-belling-btn text-center mt-10">
                    <a href="{{ route('catalog.all') }}" class="btn">Comprar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- best-selling-area-end -->
@endsection

@push('scripts')

@endpush