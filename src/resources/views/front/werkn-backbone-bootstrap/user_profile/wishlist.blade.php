@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

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
                            <div class="card-columns">
                                @foreach($wishlist as $ws)
                                <a href="{{ route('detail', [$ws->product->category->slug, $ws->product->slug]) }}" class="card">
                                    <img class="card-img-top" src="{{ asset('img/products/' . $ws->product->image ) }}" alt="{{ $ws->product->name }}">

                                    <div class="card-body">
                                        <h4 class="card-title">{{ $ws->product->name }}</h4>
                                        <p class="card-text"><strong>$ {{ $ws->product->price }}</strong></p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">¡Solo {{ $ws->product->stock }} en existencia!</small>
                                    </div>
                                </a>
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