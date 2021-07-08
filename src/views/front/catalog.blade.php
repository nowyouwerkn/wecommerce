@extends('front.layouts.main')

@section('content')
    <!-- Catalog -->
    <section>
        <div class="container mt-5 catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-8">
                    <h1>Catalog</h1>
                </div>

                <div class="col-md-4">
                    <form action="" method="POST">
                        <input type="text" placeholder="Búsqueda" class="form-control">
                    </form>
                </div>
            </div>

            <!-- Catalog -->
            <div class="row mt-5">
                <!-- Filter -->
                <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="#">Ver todo</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Zapatos</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Ropa</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Básicos</a>
                        </li>

                        <h4 class="mb-3">Populares</h4>

                        <li class="mb-3">
                            <a href="#">Talla</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Marcas</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Precios</a>
                        </li>
                    </ul>
                </div>

                <!-- Products -->
                <div class="col-md-9">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-md-4 text-center mb-5">
                            <a href="{{ route('detail', $product->slug) }}">
                                <!-- Image -->
                                @if($product->image == NULL)
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text={{ $product->name }}" alt="">
                                @else
                                <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}">
                                @endif 
                                <!-- Info -->
                                <div class="row">
                                    <div class="col text-start">
                                        <p>{{ $product->name }}</p>
                                    </div>
                                    <div class="col text-end">
                                        @if($product->has_discount == true)
                                        <p class="price">${{ number_format($product->discount_price, 2) }}</p>
                                        <p class="price-discounted"><span>${{ number_format($product->price, 2) }}</span></p>
                                        @else
                                        <p class="price">${{ number_format($product->price, 2) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information -->
    <section>
        <div class="container px-4 py-5">
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                    <ion-icon name="cart-outline"></ion-icon>
                    </div>
                    <h2>Compra Segura</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis.</p>
                </div>
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </div>
                    <h2>Sitio Seguro</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis fugiat quis ipsam eius vitae.</p>
                </div>
                <div class="feature col">
                    <div class="feature-icon bg-primary bg-gradient">
                    <ion-icon name="shield-checkmark-outline"></ion-icon>
                    </div>
                    <h2>Información Protegida</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis, fugiat quis ipsam eius vitae</p>
                </div>
            </div>
        </div>
    </section>
@endsection