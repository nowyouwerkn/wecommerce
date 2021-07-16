@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<!-- shop-area -->
<section class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="catalog-hero">
            <h3 class="mb-2">Búsqueda</h3>
            <h2 class="margin-text-2">{{ Request::input('query') }}</h2>
            <p>Actualmente {{ $products->count() }} resultado(s)</p>
        </div>

        @if($products->count() == 0)
        <div class="text-center" style="padding:80px 0px 100px 0px;">
            <img src="{{ asset('themes/werkn-backbone/img/not_found.svg') }}" class="ml-auto mr-auto mb-5" width="300">
            <h4>Todavía no hay nada por aqui</h4>
            <p class="mb-4">Regresa pronto para conocer nuestros productos. ¿Eres el dueño? Inicia sesión <a href="{{ route('login') }}">aquí.</a></p>
        </div>
        @else
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <form method="get" action="{{ route('dynamic.filter.front') }}" id="product_filter_form">
                    @php
                        $popular_products = Nowyouwerkn\WeCommerce\Models\Product::where('is_favorite', true)->get();
                        $categories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
                        $variants = Nowyouwerkn\WeCommerce\Models\Variant::get();
                    @endphp

                    <aside class="shop-sidebar pr-5">
                        <div class="d-flex align-items-center mb-20">
                            <button type="submit" class="btn-link btn-block btn-sm mr-3"><i class="mdi mdi-filter"></i> Filtrar Búsqueda</button>

                            <a href="{{ route('catalog.all') }}" id="clean_selection" class="btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Limpiar Selección"><i class="mdi mdi-refresh"></i> Refrescar</a>
                        </div>

                        <div class="widget">
                            <h4 class="widget-title">Colecciones</h4>
                            <div class="shop-cat-list">
                                <ul>
                                    @foreach($categories as $category)
                                    <li class="form-check">
                                        <input type="checkbox" id="{{ $category->slug }}" name="cat_type[]" class="form-check-input" value="{{ $category->slug }}"
                                        @if(isset($selected_scale))  
                                            @if (in_array('{{ $category->slug }}', $selected_scale))  
                                                checked="checked"   
                                            @endif 
                                        @endif
                                        >
                                        <label for="{{ $category->slug }}" class="form-check-label ib-m">
                                            {{ $category->name }}
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="widget has-border">
                            <div class="sidebar-product-size mb-30">
                                <h4 class="widget-title">Variantes</h4>
                                <div class="shop-size-list">
                                    <ul>
                                        @foreach($variants as $variant)
                                        <li class="form-check">
                                            <input type="checkbox" id="{{ $variant->value }}" name="variant[]" class="form-check-input" value="{{ $variant->value }}"
                                            @if(isset($selected_scale))  
                                                @if (in_array('{{ $variant->value }}', $selected_scale))  
                                                    checked="checked"   
                                                @endif 
                                            @endif
                                            >
                                            <label for="{{ $variant->value }}" class="form-check-label ib-m">
                                                {{ $variant->value }}
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="widget">
                            <h4 class="widget-title">Populares</h4>
                            <div class="sidebar-product-list">
                                <ul>
                                    @foreach($popular_products as $product)
                                    <li>
                                        <div class="sidebar-product-thumb">
                                        <a href="{{ route('detail', [$product->category->slug, $product->slug]) }}"><img src="{{ asset('img/products/' . $product->image) }}" alt=""></a>
                                        </div>
                                        <div class="sidebar-product-content">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h5><a href="#">{{ $product->name }}</a></h5>
                                            <span>$ {{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </aside>
                </form>
            </div>

            <div class="col-xl-9 col-lg-8 pl-4">
                <div class="shop-top-meta mb-35">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shop-top-left">
                                <ul>
                                    <li>Mostrando 1–9 de 80 resultados</li>
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