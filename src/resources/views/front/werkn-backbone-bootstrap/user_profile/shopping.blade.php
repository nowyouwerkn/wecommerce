@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    .card-default{
        position: relative;
    }

    .badge-process{
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
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
                    <p>Tus compras</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <!-- PROFILE INFORMATION -->
                <section class="col-md-9">
                    @if($orders->count())
                    <div class="row">
                        @foreach($orders as $order)
                        <div class="col-md-6">
                            @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._order_card')
                        </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            {{ $orders->links() }}
                        </div>
                    </div>
                    @else
                        <div class="text-center my-5">
                            <h4 class="mb-0">No tienes compras recientes.</h4>
                            <p>Visita la tienda <a href="{{ route('catalog.all') }}">aqui</a> y disfruta.</p>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </section>
@endsection