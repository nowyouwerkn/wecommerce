@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    .bg-warning{
        background-color: rgba(212,205,191,1) !important;
        color: #6a6340 !important;
    }

    .bg-danger{
        background-color: rgba(10,18,33,1) !important;
        color: #d7cfc0 !important;
    }
</style>
@endpush

@section('content')
    <!-- Profile -->
    <section>
        <div class="container">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Bienvenido</p>
                    <h1>Hola, {{ Auth()->user()->name ?? 'N/A' }}</h1>
                </div>
            </div>
            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3">
                                <p>Pedidos Totales</p>
                                <h2>{{ $total_orders->count() }}</h2>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-3">
                                <p>Direcciones Guardadas</p>
                                <h2>{{ $addresses->count() }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mt-3">Resumen de Pedidos</h3>
                            <hr>

                            @if($orders->count())
                                @foreach($orders as $order)
                                    @include('front.theme.werkn-backbone.layouts._order_card')
                                @endforeach

                                <div class="text-center">
                                    <a class="btn btn-secondary mt-3" href="{{ route('shopping') }}">Ver todos</a>
                                </div>

                            @else
                                <div class="text-center my-5">
                                    <h4 class="mb-0">No tienes compras recientes.</h4>
                                    <p>Visita la tienda <a href="{{ route('catalog.all') }}">aqui</a> y disfruta.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection