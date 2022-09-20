@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

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

    .coupon-wrap{
        display: inline-block;
        padding: 15px 20px;
        border: 3px solid #000;
        border-radius: 10px;
        border-style: dotted;
    }
</style>
@endpush

@section('content')
@php
    $membership = Nowyouwerkn\WeCommerce\Models\MembershipConfig::where('is_active', true)->first();
@endphp
    <!-- Profile -->
    <section>
        <div class="container">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Bienvenido</p>
                    <h1>Hola, {{ Auth()->user()->name ?? 'N/A' }} @if ($vip_status != false)<ion-icon name="trophy"></ion-icon>@endif</h1>
                </div>
            </div>
            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @if (!empty($membership))
                    <div class="card p-3 mb-4">
                        <p>Puntos disponibles</p>
                        <input type="text" disabled class="text-center form-control mb-3" value="{{ $valid }}">
                        @if ($membership->has_expiration_time == true)
                            @if (!empty($last_points))
                                <p>Vencen: <span>{{  Carbon\Carbon::parse($last_points->valid_until)->translatedFormat('d \d\e F, Y') }}</span></p>
                            @endif
                        @endif
                        <a href="" class="btn btn-primary">Usar</a>
                    </div>
                    @endif
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    @if(Auth()->user()->hasCoupon() == true)
                        @if(Auth()->user()->coupon->end_date > Carbon\Carbon::now()->format('Y-m-d'))
                        <div class="bg-light card card-body mb-3">
                            <div class="d-flex align-items-center">
                                <div class="mx-3 my-3">
                                    <img width="250px" src="{{ asset('img/coupon_image.svg') }}">
                                </div>

                                <div class="coupon-text ms-3">
                                    <h4 class="mb-0">¡Bienvenido!</h4>
                                    <p>Gracias por tu registro, por promoción aquí está tu cupón:</p>

                                    <div class="coupon-wrap">
                                        {{ Auth()->user()->coupon->code }}
                                    </div>

                                    <p class="mt-3 mb-0"><small>Este cupón caduca en {{ Carbon\Carbon::parse(Auth()->user()->coupon->end_date)->diffForHumans() }}, el día {{ Carbon\Carbon::parse(Auth()->user()->coupon->end_date)->format('d M Y') }}</small></p>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif

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
                                <div class="row">
                                    @foreach($orders as $order)
                                        <div class="col-md-6">
                                            @include('front.theme.werkn-backbone-bootstrap.layouts.utilities._order_card')
                                        </div>
                                    @endforeach
                                </div>

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
