@extends('front.layouts.main')

@section('content')
    <!-- Profile -->
    <section>
        <div class="container">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Bienvenido</p>
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
                        <div class="col-md-6">
                            <div class="card p-3">
                                <p>Pedidos Totales</p>
                                <h2>0</h2>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-3">
                                <p>Direcciones Guardadas</p>
                                <h2>0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection