@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ordenes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Ordenes</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
        </div>
    </div>
@endsection

@section('content')

@if($orders->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_2.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Aquí aparecerán las compras que hagan tus clientes.</h4>
        <p class="mb-4">Actualmente nadie a comprado, regresa pronto.</p>
    </div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">
                        <form action="" method="POST" class="d-flex">
                            <div class="content-search col-6">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control" placeholder="Buscar orden...">
                            </div>

                            <select class="custom-select tx-13">
                                <option value="1" selected>Estatus</option>
                                <option value="2">...</option>
                                <option value="3">...</option>
                                <option value="4">...</option>
                            </select>

                            <select class="custom-select tx-13">
                                <option value="1" selected>Ordenar</option>
                                <option value="2">...</option>
                                <option value="3">...</option>
                                <option value="4">...</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Orden</th>
                                    <th>ID Pago</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Cobro</th>
                                    <th>País</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}">
                                            @if(strlen($order->id) == 1)
                                            Orden #00{{ $order->id }}
                                            @endif
                                            @if(strlen($order->id) == 2)
                                            Orden #0{{ $order->id }}
                                            @endif
                                            @if(strlen($order->id) > 2)
                                            Orden #{{ $order->id }}
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $order->payment_id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        <span class="text-muted"><i class="wb wb-time"></i> {{ $order->created_at }}</span>
                                    </td>
                                    <td>${{ number_format($order->cart->totalPrice) }}</td>
                                    <td>
                                        @if($order->is_completed == true)
                                        <div class="badge badge-table badge-success"><i class="simple-icon-check mr-1"></i> Pagado</div>
                                        @else
                                            @if($order->status == NULL)
                                            <div class="badge badge-table badge-warning"><i class="simple-icon-close mr-1"></i> Pendiente</div>
                                            @else
                                            <div class="badge badge-table badge-danger"><i class="simple-icon-close mr-1"></i> Expirado/Cancelado</div>
                                            @endif
                                        @endif
                                    </td>

                                    <td>{{ $order->country }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    @endif
@endsection