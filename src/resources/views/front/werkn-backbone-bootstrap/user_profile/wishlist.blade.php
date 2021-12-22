@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    .footer-card-wish{
        text-align: center;
        padding: 1rem;
        background-color: black;
        color: white;
        margin-top: 1rem;
    }
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
                                    <!--
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
                                    -->
                                    
                                    <!--
                                    @if($wishlist->count())
                                        <li class="list-inline-item"><a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> ¡Comprar ahora!</a></li>
                                    @else
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary disabled"><i class="fa fa-shopping-cart"></i> ¡Comprar ahora!</a></li>
                                    @endif
                                    -->
                                </ul>
                            
                            </div>

                        </div>
                        
                        <hr>

                       @if($wishlist->count())
                            <div class="row">
                                @foreach($wishlist as $product_info)


                                
                                <div class="col-4">
                                    <div class="card mb-4 box-shadow">
                                    <a href="{{ route('detail', [$product_info->product->category->slug, $product_info->product->slug]) }}">
                                    <img class="card-img-top" src="{{ asset('img/products/' . $product_info->product->image) }}" data-holder-rendered="true">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-text">{{$product_info->product->name}}</h5>
                                      <p class="card-text">{{$product_info->product->description}}</p>
                                      <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->product->id))
                                             <a href="{{ route('wishlist.remove', $product_info->product->id) }}" class="btn-sm btn btn-outline-danger"><ion-icon name="heart-dislike"></ion-icon></a>
                                            @else
                                                @if(Auth::guest())
                                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary"><ion-icon name="heart"></ion-icon></a>
                                                @else
                                                 <a href="{{ route('wishlist.add', $product_info->product->id) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="heart"></ion-icon></a>
                                                @endif
                                            @endif
                                            @if($product_info->product->status == 'Publicado')
                                            <a href="{{ route('add-cart', ['id' => $product_info->product->id, 'variant' => 'unique']) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="cart"></ion-icon></a>
                                            @else
                                            <a href="#" class="btn btn-sm btn-outline-secondary">Disabled</a>
                                            @endif
                                        </div>
                                                             @if($product_info->product->has_discount == true)
                                            <span class="price">${{ number_format($product_info->product->discount_price, 2) }}</span>
                                            @else
                                            <span class="price">${{ number_format($product_info->product->price, 2) }}</span>
                                            @endif
                                      </div>
                                      <div class="footer-card-wish">Solo quedan {{$product_info->product->stock}}</div>
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