@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<section class="banner-main" style="background:#f9f8f5;">
    @if(empty($banners))
    <h2 class="text-center p-5">No se ha configurado un banner</h2>
    @else
        @foreach($banners as $banner)
        <div class="banner-wrap" style="position: relative;">
            @if(empty($banners->video_background))
            @else
                <iframe frameborder="0" height="100%" width="100%" src="https://youtube.com/{{$banner->video_background}}?autoplay=1&controls=0&showinfo=0&autohide=1" style="z-index: 2; position: absolute;"></iframe>
                @endif
            <div class="container">
                <div class="row">
                    <div class="col-12" style="position: relative;"> 
                     
                        <div  style="z-index: 3; position: relative; text-align:{{$banner->position}}" class="banner-content">
                            <h3 style="color: {{$banner->hex_text_title}}">{{ $banner->subtitle }}</h3>
                            <h2 style="color: {{$banner->hex_text_subtitle}}">{{ $banner->title }}</h2>
                            <p style="color: {{$banner->hex_text_subtitle}}">{{ $banner->text }}</p>

                            @if($banner->has_button == true)
                            <a style="color: {{$banner->hex_text_button}}; background-color: {{$banner->hex_button}}; border: none;" href="{{ $banner->link }}" class="btn btn-primary">{{ $banner->text_button }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="banner-img">
                @if($banner->image == NULL)
                @else
                    <img style="z-index: 1; position: relative;" src="{{ asset('img/banners/' . $banner->image ) }}" alt="" class="main-img">
                @endif
            </div>
        </div>
        @endforeach
    @endif
</section>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            @foreach($main_categories as $category)
                <div class="col-md-4">
                    <div class="cat-item mb-20">
                        <div class="thumb">
                            <a href="{{ route('catalog', $category->slug) }}">
                                @if($category->image == NULL)
                                <img src="{{ asset('img/categories/no_category.jpg') }}" alt="" width="100%">
                                @else
                                <img src="{{ asset('img/categories/' . $category->image) }}" alt="" width="100%">
                                @endif
                            </a>
                        </div>
                        <div class="content mt-3">
                            <span>Colección</span>
                            <h3 class="mb-3 mt-0"><a href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a></h3>
                            <a href="{{ route('catalog', $category->slug) }}" class="btn btn-outline-secondary">Comprar Ahora</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pt-5 pb-5">
    <div class="container custom-container-two">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row new-arrival-active">
                    @foreach($products->take(4) as $product_info)
                    <div class="col-md-3">
                        @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._product_card')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROMO BANNER -->

@php
    $banner_promo = Nowyouwerkn\WeCommerce\Models\Banner::where('is_promotional', true)->where('priority', 1)->first();
@endphp


<section class="banner-main" style="background:#f9f8f5;">
    @if(empty($banner_promo))
    <h2 class="text-center p-5">No se ha configurado un banner promocional</h2>
    @else
        <div class="banner-wrap" style="position: relative;">
            @if(empty($banner_promo->video_background))
            @else
                <iframe frameborder="0" height="100%" width="100%" src="https://youtube.com/{{$banner_promo->video_background}}?autoplay=1&controls=0&showinfo=0&autohide=1" style="z-index: 2; position: absolute;"></iframe>
                @endif
            <div class="container">
                <div class="row">
                    <div class="col-12" style="position: relative;"> 
                     
                        <div style="z-index: 3; position: relative;" class="banner-content">
                            <h3 style="color: {{ $banner_promo->hex_text_title }}">{{ $banner_promo->subtitle }}</h3>
                            <h2 style="color: {{$banner_promo->hex_text_subtitle}}">{{ $banner_promo->title }}</h2>
                            <p style="color: {{$banner_promo->hex_text_subtitle}}">{{ $banner_promo->text }}</p>

                            @if($banner_promo->has_button == true)
                            <a style="color: {{$banner_promo->hex_text_button}}; background-color: {{$banner_promo->hex_button}}; border: none;" href="{{ $banner_promo->link }}" class="btn btn-primary">{{ $banner_promo->text_button }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="banner-img">
                @if($banner_promo->image == NULL)
                @else
                    <img style="z-index: 1; position: relative;" src="{{ asset('img/banners/' . $banner_promo->image ) }}" alt="" class="main-img">
                @endif
            </div>
        </div>
    @endif
</section>

<!-- best-selling-area -->
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-5">
                    <h3>Productos Favoritos</h3>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($products_favorites->take(4) as $product_info)
            <div class="col-md-3">
                @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._product_card')
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-center mt-3">
                    <a href="{{ route('catalog.all') }}" class="btn btn-primary">Comprar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- best-selling-area-end -->
@endsection

@push('scripts')

@endpush