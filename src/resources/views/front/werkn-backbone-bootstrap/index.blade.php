@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
@include('front.theme.werkn-backbone-bootstrap.layouts.partials._cookies_modal')
<section class="banner-main" style="background:#f9f8f5;">
    @if(empty($banners))
    <h2 class="text-center p-5">No se ha configurado un banner</h2>
    @else
        @foreach($banners as $banner)
        <div class="banner-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-4"> 
                        <div class="banner-content">
                            <h3>{{ $banner->subtitle }}</h3>
                            <h2>{{ $banner->title }}</h2>
                            <p>{{ $banner->text }}</p>

                            @if($banner->has_button == true)
                            <a href="{{ $banner->link }}" class="btn btn-primary">{{ $banner->text_button }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="banner-img">
                @if($banner->image == NULL)
                @else
                    <img src="{{ asset('img/banners/' . $banner->image ) }}" alt="" class="main-img">
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