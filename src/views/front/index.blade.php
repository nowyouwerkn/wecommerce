@extends('front.layouts.main')

@section('content')
    <!-- Home --> 
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy" src="http://placehold.jp/99ccff/2475c7/300x300.png?text=Werkn Rocks" alt="">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Grandes pasos para grandes zapatos</h1>
                <p class="lead">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Enim blanditiis quia accusantium deleniti earum dolorem odio aut eaque, fuga omnis ipsum asperiores, voluptatum magnam at ut, numquam officia facere repellendus.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Catálogo</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Conócenos</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Catalog -->
    <section>
        <div class="container mt-5 catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Catalog</h2>
                </div>
            </div>

            <!-- Filter -->
            <div class="row mb-5">
                <div class="col-md-8">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="">Todo</a>
                        </li>
                        @php
                            $categories = App\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
                        @endphp

                        @foreach($categories as $category)
                        <li class="list-inline-item">
                            <a class="nav-link" href="{{ route('catalog', $category->slug) }}">{{ $category->name }}</a>
                        </li>
                        @endforeach

                    </ul>
                </div>

                <div class="col-md-4">
                    <form action="" method="POST">
                        <input type="text" placeholder="Búsqueda" class="form-control">
                    </form>
                </div>
            </div>

            <!-- Products -->
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
    </section>

    <!-- Banner -->
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1>El mejor amigo de un fashionista</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus sequi excepturi accusantium sunt aliquam? Nulla, deserunt ab aut nemo laborum consequatur reprehenderit molestias doloribus quos cupiditate non? Magni, quae quam.</p>
                    <a href="#" class="btn btn-primary">Ver todo el catálogo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Discount -->
    <section>
        <div class="container mt-5 recommend">
            <div class="row">
                <!-- Title -->
                <div class="col-md-3">
                    <p>Descuentos</p>
                    <h3>Descuentos Verano</h3>
                    <p>Gran calidad a mejores precios</p>
                    <a href="#" class="btn btn-primary">Comprar ahora</a>
                </div>

                <!-- Products -->
                <div class="col-md-9">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                        <div class="col-md-3">
                            <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            <p>Leather Ankle Boot Style Shoes</p>
                            <p>$210 $170</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Tienda Física</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas dolore rerum aliquam officia ea illo enim reprehenderit est commodi. Vel optio iste at temporibus delectus veniam impedit iure quasi aliquid.</p>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#">
                                        <ion-icon name="phone-portrait-outline"></ion-icon> +52 477 152 96 85
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <ion-icon name="mail-outline"></ion-icon> contacto@tienda.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About banner -->
    <section class="banner-about">
        <div class="container">
            <div class="row">
                <div class="col-md-3 offset-md-1 bg-light mt-5 p-3">
                    <h6>Encuéntranos</h6>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-primary">Mostrar en mapa</a>
                </div>
            </div>
        </div>
    </section>
@endsection