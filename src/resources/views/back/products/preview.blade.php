@php
    $theme = Nowyouwerkn\WeCommerce\Models\StoreTheme::where('is_active', 1)->first();
@endphp

@extends('front.theme.' . $theme->name . '.layouts.main')
@push('stylesheets')

@endpush

@section('content')
<section class="product-detail">
    <div class="wk-product-travel-nav pt-3 pb-3 mb-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="previous-product text-start">
                    <a href="#" class="btn btn-link"><ion-icon name="arrow-back-outline"></ion-icon> Producto anterior</a>
                </div>

                <div class="breadcrumb-content text-center">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#">Catálogo</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Sin Categoría' }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </div>

                <div class="next-product text-end">
                    <a href="#" class="btn btn-link">Siguiente producto <ion-icon name="arrow-forward-outline"></ion-icon></a>
                </div>
            </div>
        </div>    
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="shop-details-flex-wrap d-flex">
                    <div class="shop-details-nav-wrap">
                        <ul class=" list-group px-4" id="myTab" role="tablist">
                            @foreach($product->images as $image)
                            <li class="nav-item list-group-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile_{{ $image->id }}" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    <img width="80" height="80"src="{{ asset('img/products/' . $image->image) }}" alt="" class="img-fluid">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="shop-details-img-wrap ">
                        <div class="tab-content" id="myTabContent">
                            @foreach($product->images as $image)
                            <div class="tab-pane fade" id="profile_{{ $image->id }}" role="tabpanel" aria-labelledby="profile-tab">
                                <img width="400" height="400"src="{{ asset('img/products/' . $image->image) }}" alt="" class="img-fluid">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="shop-details-content">
                    @switch($product->type)
                        @case('physical')
                        <span class="badge bg-info">Producto Físico</span>
                        @break

                        @case('subscription')
                        <span class="badge bg-info">Suscripción</span>
                        @break

                        @case('digital')
                        <span class="badge bg-info">Producto Digital</span>
                        @break
                    @endswitch
           
                    <h2 class="title mt-2">{{ $product->name }}</h2>

                    <div class="rating d-flex mt-2">
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                    </div>

                    <p class="style-name mt-2">SKU: {{ $product->sku }}</p>

                    @if($product->type == 'subscription')
                        <p>Incluye:</p>    
                        <hr>
                        <ul class="list-unstyled">
                            @foreach($product->characteristics as $characteristic)
                                <li><ion-icon name="checkmark-circle" class="text-success"></ion-icon> {{ $characteristic->title }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if($product->has_discount == true && $product->discount_end > Carbon\Carbon::today())
                        <div class="wk-price">${{ number_format($product->discount_price, 2) }}</div>
                        <div class="wk-price wk-price-discounted">${{ number_format($product->price, 2) }}</div>
                    @else
                        <div class="wk-price">${{ number_format($product->price, 2) }}</div>
                    @endif
                    
                    @if(!empty($all_relationships))
                    <div class="product-details-info mt-4">
                        <h6 class="wk-variant-title">Colores</h6>

                        <ul class="d-flex list-unstyled mb-4">
                            <li>
                                <a href="#" style="background-color: {{ $base_product->base_product->hex_color  }}; border-color:{{ $base_product->base_product->hex_color  }};" class="rs-variant" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $base_product->base_product->color }}">{{ $base_product->base_product->color }}</a>
                            </li>

                            @foreach($all_relationships as $rs_variant)
                                @if($rs_variant->product->status != 'Borrador')
                                <li>
                                    <a href="#" style="background-color: {{ $rs_variant->product->hex_color  }};" class="rs-variant" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $rs_variant->value }}">{{ $rs_variant->value }}</a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($product->has_variants == true)
                    <div class="product-details-info mt-4">
                        <!-- Variantes Principales -->
                        @if($product->variants->count() != 0)
                        <h6 class="wk-variant-title">Escoge tu variante <span class="text-warning">Existencias totales: {{ $product->stock }} <ion-icon name="alert-circle-outline"></ion-icon></span></h6>
     
                        <ul class="wk-variant-list d-flex list-unstyled">
                            @foreach($product->variants as $variant)
                                <li>
                                    @if($variant->pivot->stock <= 0)
                                    <div class="no-stock-variant"><span class="line"></span>{{ $variant->value }}</div>
                                    @else
                                    <a id="variant{{ $variant->id }}" data-value="{{ $variant->value }}" class="stock-variant" href="javascript:void(0)">{{ $variant->value }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endif

                    <div class="product-actions d-flex align-items-center mt-5">
                        @switch($product->type)
                            @case('subscription')
                                <a href="#" class="btn btn-primary d-flex align-items-center me-3" role="button">
                                    <ion-icon name="planet-outline" class="me-2"></ion-icon> Comprar esta suscripción
                                </a>
                                @break

                            @case('digital')
                                <a href="#" id="addToCartBtn" class="btn btn-primary d-flex align-items-center me-3" role="button">
                                    <ion-icon name="bag-add-outline" class="me-2"></ion-icon> Agregar al carrito
                                </a>
                                @break

                            @default
                                <a href="#" id="addToCartBtn" class="btn btn-primary d-flex align-items-center me-3" role="button">
                                    <ion-icon name="bag-add-outline" class="me-2"></ion-icon> Agregar al carrito
                                </a>
                                @break
                        @endswitch

                        <a href="#" class="btn btn-outline-secondary d-flex align-items-center"><ion-icon name="heart-outline" class="me-2"></ion-icon> Agregar a tu Wishlist</a>
                    </div>

                    <p class="text-primary mt-4"><ion-icon name="bag-handle-outline"></ion-icon> Récibelo en {{ $shipment_option->delivery_time }} al seleccionar <br> {{ $shipment_option->name }} en tu Checkout.</p>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4">
            <div class="col-md-12">
                <div class="product-desc-wrap">
                    <div class="tab-content">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Información adicional</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false">Materiales</button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reseñas ({{ $product->approved_reviews->count() ?? '0' }})</button>
                          </li>
                           <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes" type="button" role="tab" aria-controls="sizes" aria-selected="false">Guia de tallas</button>
                          </li>
                        </ul>

                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Descripción</h6>
                                        <hr>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Consejos de cuidado</h6>
                                        <hr>
                                        <p>{{ $product->care_instructions }}</p>
                                    </div>
                                </div>
                            </div>

                          <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab"><p>{{ $product->materials }}</p></div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">   
                                <div class="wireframe-box"></div>
                            </div>
                             <div class="tab-pane fade show " id="sizes" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="wireframe-box"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-products mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="related-product-title mb-3">
                    <h4 class="title">Productos similares...</h4>
                </div>
            </div>
        </div>

        <div class="row related-product-active">
            <div class="col-3">
                <div class="wireframe-box"></div>
            </div>
        </div>
    </div>
</section>
@endsection