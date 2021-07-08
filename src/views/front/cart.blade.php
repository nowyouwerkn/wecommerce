@extends('front.layouts.main')

@section('content')
    <!-- Product Cart -->
    <section>
        <div class="container cart">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1>4 Productos en tu carrito</h1>
        
                    <!-- Table title -->
                    <div class="row mt-3">
                        <div class="col-6">
                            <p>Producto</p>
                        </div>
                        <div class="col">
                            <p>Talla</p>
                        </div>
                        <div class="col">
                            <p>Precio</p>
                        </div>
                        <div class="col">
                            <p>Acciones</p>
                        </div>
                    </div>
        
                    <!-- Table content -->
                    <div class="row mt-3">
                        <div class="col-6 d-flex">
                            <div>
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            </div>
                            <div class="p-2">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    Men GTYH859
                                    <br>
                                    <strong>
                                        - 1 +
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="col">
                            <p>XXL</p>
                        </div>
                        <div class="col">
                            <p>$37</p>
                        </div>
                        <div class="col">
                            <p>x</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6 d-flex">
                            <div>
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            </div>
                            <div class="p-2">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    Men GTYH859
                                    <br>
                                    <strong>
                                        - 1 +
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="col">
                            <p>XXL</p>
                        </div>
                        <div class="col">
                            <p>$37</p>
                        </div>
                        <div class="col">
                            <p>x</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-6 d-flex">
                            <div>
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            </div>
                            <div class="p-2">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    Men GTYH859
                                    <br>
                                    <strong>
                                        - 1 +
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="col">
                            <p>XXL</p>
                        </div>
                        <div class="col">
                            <p>$37</p>
                        </div>
                        <div class="col">
                            <p>x</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6 d-flex">
                            <div>
                                <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                            </div>
                            <div class="p-2">
                                <p>
                                    Green T-Shirt 2018
                                    <br>
                                    Men GTYH859
                                    <br>
                                    <strong>
                                        - 1 +
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="col">
                            <p>XXL</p>
                        </div>
                        <div class="col">
                            <p>$37</p>
                        </div>
                        <div class="col">
                            <p>x</p>
                        </div>
                    </div>
    
                    <!-- Total and Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <p>Total: $148</p>
    
                            <a href="{{ route('catalog') }}" class="btn btn-primary me-3">Regresar al catalogo</a>
                            <a href="{{ route('checkout') }}" class="btn btn-secondary">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information -->
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4">
                    <h4>Compra segura</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis, fugiat quis ipsam eius vitae, magni architecto iusto error culpa minus dolores doloremque ad, est possimus.</p>
                </div>
                <div class="col-md-4">
                    <h4>Sitio seguro (SSL)</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis, fugiat quis ipsam eius vitae, magni architecto iusto error culpa minus dolores doloremque ad, est possimus.</p>
                </div>
                <div class="col-md-4">
                    <h4>Información protegida</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis assumenda facilis ullam quaerat blanditiis, fugiat quis ipsam eius vitae, magni architecto iusto error culpa minus dolores doloremque ad, est possimus.</p>
                </div>
            </div>
        </div>
    </section>
@endsection