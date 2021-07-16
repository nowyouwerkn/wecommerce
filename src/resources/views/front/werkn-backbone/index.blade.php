@extends('front.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">

    .banner-five-wrap{
        overflow: hidden;
        position: relative;
    }

    .banner-five-img{
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        right: initial !important;
        bottom: initial !important;
        z-index: -1;
        opacity: .5;
    }

    .banner-five-img .main-img{
        width: 100% !important;
        max-width: 100vw;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }
</style>
@endpush

@section('content')
<!-- slider-area -->
<section class="home-five-banner">
    <div class="container-fluid p-0" style="background:#f9f8f5;">
        @if(empty($banner))
        <h2>No se ha configurado un banner</h2>
        @else
        <div class="banner-five-wrap">
            <div class="row">
                <div class="col-12"> 
                    <div class="slider-content">
                        <h3 class="sub-title wow fadeInUp" data-wow-delay=".2s">{{ $banner->subtitle }}</h3>
                        <h2 class="title wow fadeInUp" data-wow-delay=".4s">{{ $banner->title }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ $banner->text }}</p>

                        @if($banner->has_button == true)
                        <a href="{{ $banner->link }}" class="btn wow fadeInUp" data-wow-delay=".8s">{{ $banner->text_button }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="banner-five-img">
                @if($banner->image == NULL)
                @else
                    <img src="{{ asset('img/banners/' . $banner->image ) }}" alt="" class="main-img">
                @endif
            </div>
        </div>
        @endif
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
        </div>
    </div>
</div>
<!-- category-area-end -->

<!-- new-arrival-area -->
<section class="new-arrival-area home7-new-arrival pt-95 pb-50">
    <div class="container custom-container-two">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row new-arrival-active">
                    @foreach($products as $product_info)
                    <div class="col-xl-4 col-sm-6 grid-item grid-sizer cat-two">
                        @include('front.werkn-backbone.layouts._product_card')
                    </div>
                    @endforeach
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