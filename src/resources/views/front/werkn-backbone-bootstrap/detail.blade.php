@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ $product->description }}">
<meta property="og:url" content="{{ route('detail', [$product->category->slug , $product->slug])}}">
<meta property="og:image" content="{{ asset('img/products/' . $product->image) }}">
<meta property="product:brand" content="{{ $product->brand ?? 'N/A' }}">
<meta property="product:availability" content="{{ $product->availability ?? '' }}">
<meta property="product:condition" content="{{ $product->condition ?? '' }}">
<meta property="product:gender" content="{{ $product->gender ?? 'N/A' }}">
<meta property="product:color" content="{{ $product->color ?? 'N/A' }}">
<meta property="product:age_group" content="{{ $product->age_group ?? '' }}">

<meta property="product:price:amount" content="{{ number_format($product->price, 2) }}">
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
    .rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    visibility: hidden;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
</style>
@endpush

@section('content')
<br>
<section class="product-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
                @if(!empty($last_product))
                <div class="previous-product">
                    <a href="{{ route('detail', [$last_product->category->slug, $last_product->slug]) }}"><i class="fas fa-angle-left"></i> Producto anterior</a>
                </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="breadcrumb-content">
                    <nav aria-label="breadcrumb">
                        
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                @if(!empty($next_product))
                <div class="next-product">
                    <a href="{{ route('detail', [$next_product->category->slug, $next_product->slug]) }}">Siguiente producto <i class="fas fa-angle-right"></i></a>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
          
            </div>

            <div class="col-md-6">
                <div class="shop-details-flex-wrap d-flex">
                    <div class="shop-details-nav-wrap">

                        <ul class=" list-group px-4" id="myTab" role="tablist">
                            <li class="nav-item list-group-item" role="presentation">
                                <a class="nav-link" id="item-one-tab" data-toggle="tab" href="#item-one" role="tab" aria-controls="item-one" aria-selected="true"><img width="80" height="80" src="{{ asset('img/products/' . $product->image) }}" alt="" class="img-fluid"></a>
                            </li>
                            @foreach($product->images as $image)
                            <li class="nav-item list-group-item" role="presentation">
                                <a class="nav-link" id="item-two-{{ $image->id }}" data-toggle="tab" href="#item-{{ $image->id }}" role="tab" aria-controls="item-{{ $image->id }}" aria-selected="false"><img width="80" height="80"src="{{ asset('img/products/' . $image->image) }}" alt="" class="img-fluid"></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="shop-details-img-wrap ">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="item-one" role="tabpanel" aria-labelledby="item-one-tab">
                                <div class="shop-details-img">
                                    <img height="400" width="400" src="{{ asset('img/products/' . $product->image) }}" alt="" class="img-fluid">
                                </div>
                            </div>
                            @foreach($product->images as $image)
                            <div class="tab-pane fade" id="item-{{ $image->id }}" role="tabpanel" aria-labelledby="item-two-{{ $image->id }}">
                                <div class="shop-details-img">
                                    <img src="{{ asset('img/products/' . $image->image) }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="shop-details-content">
                          <ol class="breadcrumb mb-10 mx-2 mt-2">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catalog.all') }}">Catálogo</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('catalog.all') }}">{{ $product->category->name ?? 'Sin Categoría' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                    <h2 class="title mx-2 mt-2">{{ $product->name }}</h2>

                    <div class="rating d-flex mx-2 mt-2">
                                @if(round($product->approved_reviews->avg('rating'), 0) == 0)
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                @endif
                                  @if(round($product->approved_reviews->avg('rating'), 0) == 1)
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                @endif
                                  @if(round($product->approved_reviews->avg('rating'), 0) == 2)
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                @endif
                                  @if(round($product->approved_reviews->avg('rating'), 0) == 3)
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                @endif
                                  @if(round($product->approved_reviews->avg('rating'), 0) == 4)
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star-outline"></ion-icon>
                                @endif
                                  @if(round($product->approved_reviews->avg('rating'), 0) == 5)
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                <ion-icon name="star"></ion-icon>
                                @endif
                    </div>
                    
                    <p class="style-name mx-2 mt-2">SKU : {{ $product->sku }}</p>
                    <p class="style-name mx-2 mt-2">Stock : {{ $product->stock }}</p>
                    @if($product->has_discount == true && $product->discount_end > $current_date_time)
                    <div class="price mx-2 mt-2">Precio : ${{ number_format($product->discount_price, 2) }}</div>
                    <div class="price price-discounted mx-2 mt-2">${{ number_format($product->price, 2) }}</div>
                    @else
                    <div class="price mx-2 mt-2">Precio : ${{ number_format($product->price, 2) }}</div>
                    @endif

                    
                    <div class="product-details-info mx-2 mt-2">
                        @if($product->has_variants == true)
                            @if($product->variants->count() != 0)
                            <div class="sidebar-product-size mb-30">
                                <h4 class="widget-title">Escoge tu variante</h4>
                                <div class="shop-size-list">
                                    <ul class="d-flex list-unstyled">
                                        @foreach($product->variants as $variant)
                                            <li>
                                                @if($variant->pivot->stock <= 0)
                                                <div class="no-stock-variant card"><span class="line"></span>{{ $variant->value }}</div>
                                                @else
                                                <a id="variant{{ $variant->id }}" data-value="{{ $variant->value }}" class="card px-4 pt-2 pb-2 mx-2" href="javascript:void(0)">{{ $variant->value }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                    <div class="perched-info d-flex">
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
                           <a href="{{ route('add-cart', ['id' => $product->id, 'variant' => 'unique']) }}" id="cartBtn" class="btn btn-primary mx-2 mt-2 " role="button">
                                <i class="fas fa-cart-plus"></i> Agregar al carrito
                            </a>
                            @endif
                        @else
                            @if($product->stock <= 0)
                            <div class="mr-3">
                                <p class="no-existance-btn mb-0"><i class="fas fa-heartbeat"></i> Sin Existencias</p>
                                <p class="no-existance-explain mb-0 mt-0"><small>Resurtiremos pronto, revisa más adelante.</small></p>
                            </div>
                            @else
                            <a href="{{ route('add-cart', ['id' => $product->id, 'variant' => 'unique']) }}" id="cartBtn" class="btn btn-primary mx-2 mt-2 " role="button">
                                <i class="fas fa-cart-plus"></i> Agregar al carrito
                            </a>
                            @endif
                        @endif

                       
                                
                                @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product->id))
                                    <a href="{{ route('wishlist.remove', $product->id) }}" class="mx-2 mt-2 btn btn-danger"><i class="far fa-heartbeat"></i> Quitar de tu Wishlist</a>
                                @else
                                    @if(Auth::guest())
                                    <a href="{{ route('login') }}" class="mx-2 mt-2 btn btn-info d-flex align-items-center text-center p-2"><i class="far fa-heart"></i> Agregar a tu Wishlist</a>
                                    @else
                                    <a href="{{ route('wishlist.add', $product->id) }}" class="mx-2 mt-2 btn btn-info d-flex align-items-center text-center p-2"><i class="far fa-heart"></i> Agregar a tu Wishlist</a>
                                    @endif
                                @endif
                                
                          
                    </div>
                </div>
            </div>
        </div>
<br>
        <div class="row">
            <div class="col-md-12">
                <div class="product-desc-wrap">
                    <div class="tab-content">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><h5 class="title">Información adicional:</h5></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false"><h5 class="title">Materiales:</h5></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false"><h5 class="title">Reseñas ({{ $product->approved_reviews->count() ?? '0' }}) :</h5></button>
                          </li>
                           <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes" type="button" role="tab" aria-controls="sizes" aria-selected="false"><h5 class="title">Guia de tallas</h5></button>
                          </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><p>{{ $product->description }}</p></div>
                          <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab"><p>{{ $product->materials }}</p></div>
                          <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">   @if($product->approved_reviews->count() != 0)
                                @foreach($product->approved_reviews as $review)
                                    <div class="media">
                                        <img class="mr-3 rounded-circle" src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review->email))) . '?404' }}" width="50" alt="{{ $review->name }}">
                                           <div class="rating d-flex mx-2 mt-2">
                                                @if($review->rating == 0)
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                  @if($review->rating == 1)
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                  @if($review->rating == 2)
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                  @if($review->rating == 3)
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                  @if($review->rating == 4)
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                  @if($review->rating == 5)
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                @endif
                                            </div>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-0">{{ $review->name }}</h5>
                                            <p class="mb-2"><small><i>Publicado: {{ date( 'd, m, Y' ,strtotime($review->created_at)) }}</i></small></p>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            @else
                                <p class="">No hay reseñas para este producto todavía. Se el primero en hablar de "{{ $product->name }}"</p>
                            @endif
                                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="comment-form review-form">
                                {{ csrf_field() }}

                                <input type="hidden" name="product_id" value="{{ $product->id }}">


                                <h5 class="mb-2">Tu reseña <span class="text-danger ">*</span></h5>
                                <div class="rate">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="text">1 star</label>
                              </div>
                                <textarea id="review" name="review" rows="4" class="form-control mb-4" placeholder="Este producto es genial..."></textarea>

                                @guest
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-2">Tu nombre <span class="text-danger ">*</span></h5>
                                        <input type="text" name="name" placeholder="Nombre Apellido" required="">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-2">Tu correo <span class="text-danger ">*</span></h5>
                                        <input type="email" name="email" placeholder="correo@correo.com" required="">
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-2">Tu nombre <span class="text-danger ">*</span></h5>
                                        <input type="text" name="name" placeholder="Nombre Apellido" required="" value="{{ Auth::user()->name }}" readonly="">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-2">Tu correo <span class="text-danger ">*</span></h5>
                                        <input type="email" name="email" placeholder="correo@correo.com" required="" value="{{ Auth::user()->email }}" readonly="">
                                    </div>

                                </div>
                                <div class="justify-content-center">
                                      <small class="d-block mb-4">Tienes sesión iniciada como {{ Auth::user()->name }} 
                                </small>
                                </div>
                              
                                @endguest

                                <!--
                                <div class="comment-check-box">
                                    <input type="checkbox" id="comment-check">
                                    <label for="comment-check">Save my name and email in this browser for the next time I comment.</label>
                                </div>
                                -->
                                <button type="submit" class="btn btn-primary mt-5">Publicar Reseña</button>
                            </form>
                        </div>
                             <div class="tab-pane fade show " id="sizes" role="tabpanel" aria-labelledby="reviews-tab">

                                <table class="table table-hover table-responsive mt-2 mb-4">
                                            <tbody>
                                                 @foreach($size_charts as $size_chart)
                                                <tr>
                                                    @php
                                                    $size_values = Nowyouwerkn\WeCommerce\Models\Size_guide::where('size_chart_id', '=', $size_chart->id)->get();
                                                    @endphp
                                                    <th scope="row" style="width: 150px;">{{$size_chart->name}}</th>
                                                     @foreach($size_values as $size)
                                                    <td style="text-align: center;">{{$size->size_value}}</td>
                                                    @endforeach
                                                    
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($products_selected->count() != 0)
<section class="related-products">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="related-product-title">
                    <h4 class="title">También te podría gustar...</h4>
                </div>
            </div>
        </div>

        <div class="row related-product-active">
            @foreach($products_selected as $product_info)
            <div class="col-3">
                @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._product_card')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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

@push('pixel-events')
<script type="text/javascript">
    fbq('track', 'ViewContent', {
        @if($product->has_discount == true)
            value: {{ $product->discount_price }},
        @else
            value: {{ $product->price }},
        @endif
        currency: 'MXN',
        content_ids: '{{ $product->sku }}',
        content_name: '{{ $product->name }}',
        content_type: 'product',
    });
</script>

@if($store_config->has_pixel() == NULL)
<script type="text/javascript">
    @if(Session::has('product_added'))
        fbq('track', 'AddToCart', {
            value: {{ $product->price }},
            currency: 'MXN',
            content_ids: '{{ $product->sku }}',
            content_name: '{{ $product->name }}',
            content_type: 'product',
        });
    @endif


    @if(Session::has('product_added_whislist'))
        fbq('track', 'AddToWishlist' {
            value: {{ $product->price }},
            currency: 'MXN',
            content_ids: '{{ $product->sku }}',
            content_name: '{{ $product->name }}',
            content_type: 'product',
        });
    @endif
</script>
@endif
@endpush