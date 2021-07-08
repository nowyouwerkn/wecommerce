@extends('front.layouts.main')

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
                    @include('front.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4 text-center mb-5">
                            <a href="{{ route('detail') }}">
                                <!-- Image -->
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
        
                                <!-- Info -->
                                <div class="row">
                                    <div class="col text-start">
                                        <p>Ladies Grey v Neck Reebok T Shirt</p>
                                    </div>
                                    <div class="col text-end">
                                        <p>$45</p>
                                    </div>
                                </div>
        
                                <!-- Buttons -->
                                <div class="row">
                                    <div class="col text-start">
                                        <a href="#" class="btn btn-primary">Agregar a carrito</a>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Button -->
                        <div class="col-md-6 offset-md-3 text-center">
                            <a href="#" class="btn btn-primary">Cargar mas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection