@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ $product->description }}">
<meta property="og:url" content="{{ route('detail', [$product->category->slug , $product->slug])}}">
<meta property="og:image" content="{{ asset('img/products/' . $product->image) }}">
<meta property="product:brand" content="Manfort">
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="product:gender" content="male">
<meta property="product:color" content="{{ $product->color ?? 'N/A' }}">
<meta property="product:age_group" content="adult">

<meta property="product:price:amount" content="{{ number_format($product->price,2) }}">
<meta property="product:price:currency" content="MXN">

@if($product->has_discount == true)
    <meta property="product:sale_price:amount" content="{{ number_format($product->discount_price,2) }}">
    <meta property="product:sale_price:currency" content="MXN">
    <meta property="product:sale_price_dates:start" content="{{ Carbon\Carbon::parse($product->discount_start)->format('Y-m-d') .'T08:00-07:00' }}">
    <meta property="product:sale_price_dates:end" content="{{ Carbon\Carbon::parse($product->discount_end)->format('Y-m-d') .'T08:00-06:00' }}">
@endif

<meta property="product:retailer_item_id" content="{{ $product->sku }}">
<meta property="product:item_group_id" content="mf_shoes_{{ $product->sku }}">
<meta property="product:category" content="Apparel &amp; Accessories &gt; Shoes"/>

@foreach($product->images as $image)
    <meta property="product:additional_image_link" content="{{ asset('img/products/' . $image->image) }}" />
@endforeach

@endpush

@push('stylesheets')
<style type="text/css">
    .shop-size-list ul li .active{
        background: #ff6000;
        border-color: #ff6000;
        color: #fff;
    }

    .price-discounted{
        opacity: .7;
        font-size: 15px !important;
        position: relative;
        margin-top: -10px;
        left: 0px;
        border-bottom: 2px solid red;
        display: inline-block;
        line-height: 0px;
        padding: 0px 11px;
    }
</style>
@endpush

@section('content')
<!-- breadcrumb-area -->
<div class="breadcrumb-area breadcrumb-style-two" data-background="{{ asset('themes/werkn-backbone/img/bg/s_breadcrumb_bg01.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="previous-product">
                    <a href="{{ route('detail', [$last_product->category->slug, $last_product->slug]) }}"><i class="fas fa-angle-left"></i> Producto anterior</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="breadcrumb-content">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('catalog.all') }}">Catálogo</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('catalog.all') }}">{{ $product->category->name ?? 'Sin Categoría' }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <div class="next-product">
                    <a href="{{ route('detail', [$next_product->category->slug, $next_product->slug]) }}">Siguiente producto <i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area-end -->

<!-- shop-details-area -->
<section class="shop-details-area pt-100 pb-95">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="shop-details-flex-wrap">
                    <div class="shop-details-nav-wrap">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="item-one-tab" data-toggle="tab" href="#item-one" role="tab" aria-controls="item-one" aria-selected="true"><img src="{{ asset('img/products/' . $product->image) }}" alt=""></a>
                            </li>
                            @foreach($product->images as $image)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="item-two-{{ $image->id }}" data-toggle="tab" href="#item-{{ $image->id }}" role="tab" aria-controls="item-{{ $image->id }}" aria-selected="false"><img src="img/product/sd_nav_img02.jpg" alt=""></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="shop-details-img-wrap">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="item-one" role="tabpanel" aria-labelledby="item-one-tab">
                                <div class="shop-details-img">
                                    <img src="{{ asset('img/products/' . $product->image) }}" alt="">
                                </div>
                            </div>
                            @foreach($product->images as $image)
                            <div class="tab-pane fade" id="item-{{ $image->id }}" role="tabpanel" aria-labelledby="item-two-{{ $image->id }}">
                                <div class="shop-details-img">
                                    <img src="img/product/shop_details_img02.jpg" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="shop-details-content">
                    <a href="{{ route('catalog', $product->category->slug) }}" class="product-cat">{{ $product->category->name ?? 'Sin Categoria' }}</a>
                    <h3 class="title">{{ $product->name }}</h3>

                    <!--
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    -->
                    <p class="style-name">SKU : {{ $product->sku }}</p>
                    @if($product->has_discount == true)
                    <div class="price">Precio : ${{ number_format($product->discount_price, 2) }}</div>
                    <div class="price price-discounted">${{ number_format($product->price, 2) }}</div>
                    @else
                    <div class="price">Precio : ${{ number_format($product->price, 2) }}</div>
                    @endif

                    
                    <div class="product-details-info">
                        <span><a href="javascript:void(0)" data-toggle="modal" data-target="#sizesModal"><i class="fas fa-shoe-prints"></i> Guía de tallas</a></span>

                        @if($product->has_variants == true)
                            @if($product->variants->count() != 0)
                            <div class="sidebar-product-size mb-30">
                                <h4 class="widget-title">Escoge tu variante</h4>
                                <div class="shop-size-list">
                                    <ul>
                                        @foreach($product->variants as $variant)
                                            <li>
                                                <a id="variant{{ $variant->id }}" data-value="{{ $variant->value }}" class="" href="javascript:void(0)">{{ $variant->value }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                    <div class="perched-info">
                        <!--
                        <div class="cart-plus-minus">
                            <form action="#" class="num-block">
                                <input type="text" class="in-num" value="1" readonly="">
                                <div class="qtybutton-box">
                                    <span class="plus"><img src="img/icon/plus.png" alt=""></span>
                                    <span class="minus dis"><img src="img/icon/minus.png" alt=""></span>
                                </div>
                            </form>
                        </div>
                        -->
                        @if($product->has_variants == true)
                            @if($product->variants->count() == 0)
                                <div class="mr-3">
                                    <p class="no-existance-btn mb-0"><i class="fas fa-heartbeat"></i> Sin Existencias</p>
                                    <p class="no-existance-explain mb-0 mt-0"><small>Resurtiremos pronto, revisa más adelante.</small></p>
                                </div>
                            @else
                                <a href="#" id="cartBtn" class="btn" role="button">
                                    <i class="fas fa-cart-plus"></i> Agregar al carrito
                                </a>
                            @endif
                        @else
                            <a href="{{ route('add-cart', ['id' => $product->id, 'variant' => 'unique']) }}" id="cartBtn" class="btn" role="button">
                                <i class="fas fa-cart-plus"></i> Agregar al carrito
                            </a>
                        @endif

                        <div class="wishlist-compare">
                            <ul>
                                <li>
                                @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product->id))
                                    <a href="{{ route('wishlist.remove', $product->id) }}" class="wishlist-btn wishlist-btn-delete"><i class="far fa-heartbeat"></i> Quitar de tu Wishlist</a>
                                @else
                                    @if(Auth::guest())
                                    <a href="{{ route('login') }}" class="wishlist-btn d-flex align-items-center text-center p-2"><i class="far fa-heart"></i> Agregar a tu Wishlist</a>
                                    @else
                                    <a href="{{ route('wishlist.add', $product->id) }}" class="wishlist-btn d-flex align-items-center text-center p-2"><i class="far fa-heart"></i> Agregar a tu Wishlist</a>
                                    @endif
                                @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--
                    <div class="product-details-share">
                        <ul>
                            <li>Compartir :</li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-desc-wrap">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description"
                                aria-selected="true">Descripción y Materiales</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                aria-selected="false">Reseñas ({{ $product->approved_reviews->count() ?? '0' }})</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="product-desc-title mb-30">
                                        <h4 class="title">Información adicional :</h4>
                                    </div>
                                    <p>{{ $product->description }}</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="product-desc-title mb-30">
                                        <h4 class="title">Materiales :</h4>
                                    </div>
                                    <p>{{ $product->materials }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="product-desc-title mb-30">
                                <h4 class="title">Reseñas ({{ $product->approved_reviews->count() ?? '0' }}) :</h4>
                            </div>
                            @if($product->approved_reviews->count() != 0)
                                @foreach($product->approved_reviews as $review)
                                    <div class="media">
                                        <img class="mr-3 rounded-circle" src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review->email))) . '?404' }}" width="50" alt="{{ $review->name }}">
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-0">{{ $review->name }}</h5>
                                            <p class="mb-2"><small><i>Publicado: {{ date( 'd, m, Y' ,strtotime($review->created_at)) }}</i></small></p>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            @else
                                <p class="adara-review-title">No hay reseñas para este producto todavía. Se el primero en hablar de "{{ $product->name }}"</p>
                            @endif

                            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="comment-form review-form">
                                {{ csrf_field() }}

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <span>Tu reseña <span class="text-danger">*</span></span>

                                <textarea id="review" name="review" rows="4" class="form-control" placeholder="Este producto es genial..."></textarea>

                                @guest
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="name" placeholder="Tu nombre *" required="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" placeholder="Tu correo electrónico *" required="">
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="name" placeholder="Tu nombre *" required="" value="{{ Auth::user()->name }}" readonly="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" placeholder="Tu correo electrónico *" required="" value="{{ Auth::user()->email }}" readonly="">
                                    </div>
                                </div>
                                <small class="d-block mb-4">Tienes sesión iniciada como {{ Auth::user()->name }}. ¿No eres tu? 
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger"><span>Cerrar Sesión</span>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </a>
                                </small>
                                @endguest

                                <!--
                                <div class="comment-check-box">
                                    <input type="checkbox" id="comment-check">
                                    <label for="comment-check">Save my name and email in this browser for the next time I comment.</label>
                                </div>
                                -->
                                <button type="submit" class="btn">Publicar Reseña</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="related-product-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="related-product-title">
                        <h4 class="title">También te podría gustar...</h4>
                    </div>
                </div>
            </div>
            <div class="row related-product-active">
                @foreach($products_selected as $product_info)
                <div class="col">
                    @include('front.theme.werkn-backbone.layouts._product_card')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- shop-details-area-end -->

<!-- Modal GUIA DE TALLAS -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Guía de Tallas</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 modal-tallas">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 150px;">MEX</th>
                            <td style="text-align: center;">25</td>
                            <td style="text-align: center;">26</td>
                            <td style="text-align: center;">27</td>
                            <td style="text-align: center;">28</td>
                            <td style="text-align: center;">29</td>
                        </tr>
                        <tr>
                            <th scope="row" style="width: 150px;">US</th>
                            <td style="text-align: center;">5</td>
                            <td style="text-align: center;">7</td>
                            <td style="text-align: center;">9</td>
                            <td style="text-align: center;">10</td>
                            <td style="text-align: center;">12</td>
                        </tr>
                        <tr>
                            <th scope="row" style="width: 150px;">EU</th>
                            <td style="text-align: center;">38</td>
                            <td style="text-align: center;">40</td>
                            <td style="text-align: center;">42</td>
                            <td style="text-align: center;">43</td>
                            <td style="text-align: center;">45</td>
                        </tr>
                        <tr>
                            <th scope="row" style="width: 150px;">UK</th>
                            <td style="text-align: center;">4</td>
                            <td style="text-align: center;">6</td>
                            <td style="text-align: center;">8</td>
                            <td style="text-align: center;">10</td>
                            <td style="text-align: center;">11</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-hover mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 150px;">Longitud del Pie</th>
                            <td style="text-align: center;">24.6 cm</td>
                            <td style="text-align: center;">25.6 cm</td>
                            <td style="text-align: center;">26.6 cm</td>
                            <td style="text-align: center;">27.6 cm</td>
                            <td style="text-align: center;">28.6 cm</td>
                        </tr>
                    </tbody>
                </table>

                <p><small>(Para que el calzado te quede a la medida, es recomendable que no exceda esta equivalencia en cms, puede haber un margen de 2 a 3 cms dependiento la forma del pie)</small></p>

                <hr>
                <h4>¿Cómo medir mi pie?</h4>
                <p>Medir del talon a la punta del pie. Si al consultar la tabla y la equivalencia en cms. respecto a la medida del pie, dudamos entre dos tallas, es recomendable escoger la talla superior.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $('.shop-size-list ul li a').click(function() {
            event.preventDefault();
            console.log('Seleccionado:' , $(this).attr('data-value'));
            
            $('.shop-size-list ul li a').removeClass('active');
            $('#cartBtn').attr('href', '');


            if($(this).hasClass('active')){
                $(this).removeClass('active');
            }else{
                $(this).addClass('active');
            }

            var product = {{ $product->id }};
            var value = $(this).attr('data-value');
            var url = "{{ route('add-cart', ['id' => ':product', 'variant' => ':value']) }}";

            var url_new = url.replace(':value', value);
            var product_new = url_new.replace(':product', product);

            $('#cartBtn').attr('href', product_new);             
        });
    </script>
@endpush