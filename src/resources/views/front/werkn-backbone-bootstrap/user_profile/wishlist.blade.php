@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    
</style>
@endpush

@section('content')
    <!-- Profile -->
    <section>
        <div class="container catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Tus lista de deseos</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row align-items-center">
                            <div class="col">
                                <h3>Mi Wishlist</h3>
                            </div>
                            <div class="col">
                                <ul class="my-0 float-right list-inline">
                                    <li class="list-inline-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Compartir
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="#"><i class="fa fa-facebook-official"></i> Facebook</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-twitter-square"></i> Twitter</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-google-plus-square"></i> Google +</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-envelope-square"></i> Email</a>
                                        </div>
                                    </li>
                                </ul>
                            
                            </div>

                        </div>
                        
                        <hr>

                        @if($wishlist->count())
                            <div class="row">
                                @foreach($wishlist as $product_info)
                                <div class="col-4">
                                    <div class="card mb-4">
                                        <a href="{{ route('detail', [$product_info->product->category->slug, $product_info->product->slug]) }}">
                                            <img class="card-img-top" src="{{ asset('img/products/' . $product_info->product->image) }}" data-holder-rendered="true">
                                        </a>

                                        <div class="card-body">
                                            <h5 class="card-text mb-1">{{ $product_info->product->name }}</h5>

                                            <div class="rating d-flex mt-0 mb-3">
                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 0)
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                @endif

                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 1)
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                
                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 2)
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                @endif

                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 3)
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                @endif

                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 4)
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                @endif
                                                
                                                @if(round($product_info->product->approved_reviews->avg('rating'), 0) == 5)
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                @endif
                                            </div>

                                            <p class="card-text text-truncate">{{$product_info->product->description}}</p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('detail', [$product_info->product->category->slug, $product_info->product->slug]) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="eye-outline"></ion-icon></a>

                                                    @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->product->id))
                                                        <a href="{{ route('wishlist.remove', $product_info->product->id) }}" class="btn btn-sm btn-outline-danger d-flex align-items-center"><ion-icon name="heart-dislike-outline"></ion-icon></a>
                                                    @else
                                                        @guest
                                                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center"><ion-icon name="heart-outline"></ion-icon></a>
                                                        @else
                                                        <a href="{{ route('wishlist.add', $product_info->product->id) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center"><ion-icon name="heart-outline"></ion-icon></a>
                                                        @endif
                                                    @endif
                                                </div>

                                                @if($product_info->product->has_discount == true && $product_info->product->discount_end > Carbon\Carbon::today())
                                                    <div class="wk-price">${{ number_format($product_info->product->discount_price, 2) }}</div>
                                                    <div class="wk-price wk-price-discounted">${{ number_format($product_info->product->price, 2) }}</div>
                                                @else
                                                    <div class="wk-price">${{ number_format($product_info->product->price, 2) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div> 
                        @else
                            <div class="text-center my-5">
                                <h4 class="mb-0">No tienes productos guardados.</h4>
                                <p>Visita la tienda <a href="{{ route('catalog.all') }}">aquí</a> y empieza a guardar tus favoritos para compartir con tus amigos.</p>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </section>
@endsection