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
                    <p>Tus puntos</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="card p-3 mb-4">
                        <p>Puntos disponibles</p>
                        <input type="text" disabled class="text-center form-control mb-3" value="{{ $available }}">
                        @if (!empty($membership))
                            @if ($membership->has_expiration_time == true)
                                @if (!empty($last_points))
                                    <p>Vencen: <span>{{  Carbon\Carbon::parse($last_points->valid_until)->translatedFormat('d \d\e F, Y') }}</span></p>
                                @endif
                            @endif
                        @endif
                        <a href="{{ route('catalog.all') }}" class="btn btn-primary">Usar</a>
                    </div>
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <!-- PROFILE INFORMATION -->
                <section class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>Mis puntos</h3>
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">¿Cómo usar?</button>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Disponibles</h3>
                                         <input type="text" disabled class="text-center form-control mb-3" value="{{ $available }}">
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Pendientes</h3>
                                        <input type="text" disabled class="text-center form-control mb-3" value="{{ $pending }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (!empty($all_points))
                        <div class="col-md-12">
                            <h3>Mi historial de puntos</h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-dashboard">
                                    <thead>
                                        <tr>
                                            <th>Movimiento</th>
                                            <th>Estado</th>
                                            <th>Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_points as $point)
                                        <tr>
                                            <td>
                                                @switch($point->order_id)
                                                    @case(NULL)
                                                    Sistema
                                                        @break
                                                    @default
                                                    <a href="{{ route('orders.show', $point->order->id) }}"> Compra de ${{ $point->order->total }}</a>
                                                @endswitch
                                                </td>
                                            <td>
                                                @switch($point->type)
                                                    @case('in')
                                                        <span class="badge rounded-pill bg-success">Ganado</span>
                                                        @break
                                                    @case('out')
                                                        <span class="badge rounded-pill bg-danger">Usado</span>
                                                        @break
                                                    @default
                                                @endswitch
                                            </td>
                                            <td>{{ $point->value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Cómo usar tus puntos?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                   <li>Cada ${{ $membership->qty_for_points }} gastados = {{ $membership->earned_points }} puntos</li>
                   <li>1 punto = ${{ $membership->point_value }} peso</li>
                   <li>Hasta el checkout muestra los puntos a ganar</li>
                   <li>Se puede descontar hasta {{ $membership->max_redeem_points }} puntos = ${{ $membership->max_redeem_points * $membership->point_value }} pesos</li>
                   <li>Los puntos estarán disponibles para su uso una vez que el status de la orden cambie a “Entregado” .</li>
                    <li>Los puntos tienen caducidad máxima de {{ $membership->point_expiration_time }} meses después de haberlos adquirido.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
@endsection
