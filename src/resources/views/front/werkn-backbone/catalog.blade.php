@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
{{-- 
<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('themes/werkn-backbone/img/bg/breadcrumb_bg01.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="text-white">Catálogo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white"><a href="{{ route('index') }}">Inicio</a></li>
                            <li class="breadcrumb-item active text-white" style="opacity:.7;" aria-current="page">Catálogo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
--}}

<!-- shop-area -->
<section class="shop-area pt-100 pb-100">
    <div class="container">
        @if($products->count() == 0)
        <div class="text-center" style="padding:80px 0px 100px 0px;">
            <img src="{{ asset('themes/werkn-backbone/img/not_found.svg') }}" class="ml-auto mr-auto mb-5" width="300">
            <h4>Todavía no hay nada por aqui</h4>
            <p class="mb-4">Regresa pronto para conocer nuestros productos. ¿Eres el dueño? Inicia sesión <a href="{{ route('login') }}">aquí.</a></p>
        </div>
        @else
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include('front.theme.werkn-backbone.layouts._filter_sidebar')
            </div>

            <div class="col-xl-9 col-lg-8 pl-4">
                <div class="shop-top-meta mb-35">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shop-top-left">
                                <ul>
                                    <!--<li><a href="#"><i class="flaticon-menu"></i> FILTER</a></li>-->
                                    <!--<li>Mostrando 1–9 de 80 resultados</li>-->
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="shop-top-right">
                                <form action="#">
                                    <select name="select">
                                        <option value="">Ordenar por tendencia</option>
                                        <option>De mayor a menor precio</option>
                                        <option>De menor a mayor precio</option>
                                        <option>Descuentos</option>
                                        <option>Alfabético</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product_info)
                    <div class="col-xl-4 col-sm-6">
                        @include('front.theme.werkn-backbone.layouts._product_card')
                    </div>
                    @endforeach
                </div>
                <div class="pagination-wrap">
                    {{ $products->links() }}
                </div>
            </div>
            
        </div>
        @endif
    </div>
</section>
<!-- shop-area-end -->
@endsection

@push('scripts')

@endpush