@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Órdenes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orden # {{ $order->id }}</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">
            Orden
            @if(strlen($order->id) == 1)
            #00{{ $order->id }}
            @endif
            @if(strlen($order->id) == 2)
            #0{{ $order->id }}
            @endif
            @if(strlen($order->id) > 2)
            #{{ $order->id }}
            @endif
        </h4>
    </div>

    <div class="d-none d-md-block">
        <a href="{{ route('orders.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
            <i class="fas fa-undo mr-1"></i> Regresar al listado
        </a>
    </div>
</div>
@endsection

@push('stylesheets')

@endpush

@section('content')

@if(!empty($shipment_method))
<div class="col-md-6">
    <div class="card border border-primary h-100">
        <div class="card-body text-secondary">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img class="img-fluid" src="{{ asset('assets/img/brands/ups.png') }}">
                </div>
                <div class="col-md-9">
                    <h5 class="card-title text-secondary mb-1">UPS Tracking Number</h5>
                    <p class="card-text">{{ $order->main_tracking }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card border border-secondary h-100">
        <div class="card-body text-secondary">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img class="img-fluid" src="{{ asset('assets/img/brands/ups.png') }}">
                </div>
                <div class="col-md-9">
                    <h5 class="card-title text-secondary mb-1">UPS Shipping Label</h5>
                    <a class="card-text"  href="javascript:void(0)" data-toggle="modal" data-target="#guideModal">Open Guide</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($shipping_method != 0)
<div class="modal fade" id="guideModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UPS Shipping Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 600px; overflow: hidden;">
                <img style="transform: rotate(90deg);width: 130%;height: auto;top: 26%;position: relative;left: -13%;" src="{{ asset('img/tracking-labels/' . $order->package->package_label_file) }}">
            </div>
            <div class="modal-footer">
                <a href="#" onclick="printJS( '{{ asset('img/tracking-labels/' . $order->package->package_label_file) }}', 'image');return false;">
                    <i class="fa fa-print"></i> Print Guide
                </a>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
    @if($order->status == 'Cancelado')
    <div class="bg-danger text-white p-3 mb-4">
        <h5 class="mb-0">Orden cancelada por Administración o Expiró el pago en la pasarela de Pago</h5>
    </div>
    @endif

    @if($order->status != 'Cancelado')
    <span class="printableArea">
    @else
    <span class="printableArea" style="opacity: .3;">
    @endif
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex align-items-center status-row">
                    <div class="status-box btn-{{ Str::slug($order->status) }}">
                        @switch($order->status)
                            @case('Pago Pendiente')
                                <i class="fas fa-exclamation mr-1"></i>
                                @break

                            @case('Pagado')
                                <i class="fas fa-check mr-1"></i>
                                @break

                            @case('Empaquetado')
                                <i class="fas fa-box mr-1"></i>
                                @break

                            @case('Enviado')
                                <i class="fas fa-truck mr-1"></i>
                                @break

                            @case('Entregado')
                                <i class="fas fa-dolly mr-1"></i>
                                @break

                            @case('Cancelado')
                                <i class="fas fa-times mr-1"></i>
                                @break

                            @case('Expirado')
                                <i class="fas fa-times mr-1"></i>
                                @break

                            @case('Sin Completar')
                                <i class="fas fa-user-clock"></i>
                                @break

                            @default
                                <i class="fas fa-check mr-1"></i>

                        @endswitch

                        <span>{{ $order->status ?? 'Pagado'}}</span>
                    </div>

                    <div class="status-box bg-dark text-white" data-toggle="tooltip" data-placement="bottom" title="ID de Pago: {{ $order->payment_id }}">
                        @if($order->payment_method == 'Paypal')
                            <i class="fab fa-paypal"></i>
                        @else
                            <i class="fas fa-credit-card"></i>
                        @endif

                        {{ $order->payment_method }}
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h4>Información de Compra:</h4>
                        <hr>
                        <h5 class="mb-1 mt-1">Comprador:</h5>
                        <p class="mb-0"><strong>Cuenta:</strong> <a href="{{ route('clients.show', $order->user_id) }}">{{ $order->user->name }}</a></p>

                        <p class="mb-0"><strong>Nombre del Comprador:</strong> {{ $order->client_name }}</p>
                        <p class="mb-0"><strong>E-Mail:</strong> {{ $order->user->email }}</p>
                        <p class="mb-0"><strong>Teléfono:</strong> {{ $order->phone }}</p>
                        <p class="mb-0"><strong>Tarjeta:</strong> **** **** **** {{ $order->card_digits }}</p>

                        <h5 class="mb-1 mt-3">Horario de Compra:</h5>
                        <p><span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y - h:ia') }}</span></p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Resumen de Orden</h6>
                    </div>

                    @if($order->cart == NULL)
                    <p class="alert alert-warning">Esta orden proviene de una importación de otro sistema. Es posible que la información mostrada esté incompleta.</p>
                    @endif
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Total en Carrito:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->cart_total, 2) }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Envío:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->shipping_rate, 2) ?? 'N/A' }}</strong></p>
                            </div>
                            @if(!empty($shipping_option))
                            <div class="col-12"><p class="mb-0 text-info">Seleccionado: {{ $shipping_option->name }}</p></div>
                            @endif
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Sub-total:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->sub_total, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Descuentos:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->discounts, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Cupón usado:</h6>
                            </div>
                            <div class="col text-right">
                                @if($order->coupon_id == 0 or $order->coupon_id == NULL)
                                <p class="mb-0" style="font-size: 1.3em;">n/a</p>
                                @else
                                <p class="mb-0" style="font-size: 1.3em;"><strong>{{ $order->coupon_id ?? 'n/a' }}</strong></p>
                                @endif
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Puntos usados:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>{{ ($order->points) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Impuestos:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->tax_rate, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Total cobrado al cliente:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->payment_total, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <!--<a class="btn btn-sm btn-block btn-primary" href="https://dashboard.stripe.com/payments/{{ $order->payment_id }}" target="_blank">See this Summary on Stripe <i class="icon-link ml-1"></i></a>-->
                </div>
            </div>

            <div class="col-md-8">
                @if($order->type == 'single_payment')
                <div class="card mb-4">'
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Carrito</h6>
                        <p class="mb-0"><strong>Total: ${{ number_format($order->cart_total) }}</strong></p>
                    </div>

                    <div class="card-body">
                        @if($order->cart == NULL)
                            <p class="alert alert-warning">Esta orden proviene de una importación de otro sistema. El "módulo carrito" no es compatible con la información y no puede mostrar los detalles.</p>
                        @else
                            @foreach($order->cart->items as $item)
                            <div class="card d-flex flex-row mb-3">
                                <a class="d-flex" href="#">
                                    <img height="40px" alt="{{ $item['item']['name'] }}" src="{{ asset('img/products/' . $item['item']['image'] ) }}" class="list-thumbnail responsive border-0 card-img-left">
                                </a>
                                <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                    <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                        <a href="{{ route('products.show', $item['item']['id'] ) }}" class="w-40 w-sm-100">
                                            <p class="list-item-heading mb-1 truncate">{{ $item['item']['name'] }}</p>
                                        </a>
                                        <p class="mb-1 text-muted text-small w-15 w-sm-100">Talla: {{ $item['variant'] }}</p>
                                        <p class="mb-1 text-muted text-small w-15 w-sm-100">{{ $item['qty'] }} Par</p>
                                    </div>

                                    <div class="pl-1 align-self-center pr-4">
                                        <span class="badge badge-pill badge-secondary float-right">$ {{ $item['price'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="card-footer bg-transparent pd-y-10 pd-sm-y-15 pd-x-10 pd-sm-x-20 dont-print">
                        <nav class="nav nav-with-icon tx-13">
                            <a href="javascript:void(0)" class="nav-link" data-toggle="modal" data-target="#resendMail"><i class="fas fa-envelope mr-2"></i> Reenviar confirmación de orden</a>
                            @if(!empty($shipping_option) && $shipping_option->type == 'pickup')

                            @else
                            <a href="{{ route('order.packing.list', $order->id) }}" class="nav-link"><i class="fas fa-print mr-2"></i> Imprimir la lista de empaque</a>
                            @endif
                        </nav>
                    </div>
                </div>

                <div class="row mb-4">
                    @if(empty($shipping_option))
                        @include('wecommerce::back.orders.utilities._shipment_guides')
                    @else
                        @if($shipping_option->type == 'pickup')
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Recolección en Tienda</h6>
                                        @if($order->status == 'Pagado')
                                        <p class="mb-0 text-warning">Pedido pendiente de empaquetado</p>
                                        @endif

                                        @if($order->status == 'Empaquetado')
                                        <p class="mb-0 text-info">Pedido listo para Entregar</p>
                                        @endif

                                        @if($order->status == 'Entregado')
                                        <p class="mb-0 text-success text-uppercase"><i class="fas fa-check"></i> Pedido Completo</p>
                                        @endif

                                    </div>
                                    <div class="card-body pd-25">
                                        <div class="d-flex justify-content-between">
                                            <img src="{{ asset('assets/img/pickup_1.svg') }}" alt="Listo para Recolercar" class="mb-4" width="180">
                                            <img src="{{ asset('assets/img/delivery_1.svg') }}" alt="Entregado al Cliente" class="mb-4" width="180">
                                        </div>

                                        {{--
                                        <div class="progress mb-3">
                                            <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        --}}

                                        <div class="d-flex align-items-start justify-content-between">
                                            @if($order->status == 'Empaquetado' or $order->status == 'Entregado')
                                            <a href="" class="btn btn-sm pd-x-15 btn-white btn-uppercase disabled"><i class="fas fa-box mr-2"></i> Marcar como Empaquetado</a>
                                            @else
                                            <div>
                                                <a href="{{ route('order.status.static', [$order->id, 'Empaquetado']) }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i class="fas fa-box mr-2"></i> Marcar como Empaquetado</a>
                                                <small class="text-mute mt-2 d-block">Se enviará un correo de notificación al comprador.</small>
                                            </div>

                                            @endif

                                            @if($order->status == 'Entregado')
                                            <a href="" class="btn btn-sm pd-x-15 btn-white btn-uppercase disabled"><i class="fas fa-box-open mr-2"></i> Marcar como Entregado</a>
                                            @else
                                            <a href="{{ route('order.status.static', [$order->id, 'Entregado']) }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i class="fas fa-box-open mr-2"></i> Marcar como Entregado</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @include('wecommerce::back.orders.utilities._shipment_guides')
                        @endif
                    @endif
                </div>
                @else
                <div class="card mb-4">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">
                            @if($order->type == 'recurring_payment')
                                @if($order->subscription_status == true)
                                <i class="fas fa-circle text-success mr-2"></i>
                                @else
                                <i class="fas fa-circle text-danger mr-2"></i>
                                @endif
                            @endif
                            Suscripción
                        </h6>
                        <p class="mb-0"><strong>Total: ${{ number_format($order->cart_total) }}</strong></p>
                    </div>

                    <div class="card-body">
                        <div class="card d-flex flex-row mb-3">
                            <a class="d-flex" href="#">
                                <img height="40px" alt="{{ $order->subscription->name }}" src="{{ asset('img/products/' . $order->subscription->image ) }}" class="list-thumbnail responsive border-0 card-img-left">
                            </a>
                            <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                    <a href="{{ route('products.show', $order->subscription->id ) }}" class="w-40 w-sm-100">
                                        <p class="list-item-heading mb-1 truncate">{{ $order->subscription->name }}</p>
                                    </a>
                                </div>

                                <div class="pl-1 align-self-center pr-4">
                                    <span class="badge badge-pill badge-secondary float-right">$ {{ $order->subscription->price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->subscription_status == true)
                    <div class="card-footer bg-transparent pd-y-10 pd-sm-y-15 pd-x-10 pd-sm-x-20 dont-print">
                        <nav class="nav nav-with-icon tx-13">
                            <a href="{{ route('order.cancel.subscription', $order->id) }}" class="nav-link text-danger"><i class="fas fa-ban mr-2"></i> Cancelar Suscripción</a>
                        </nav>
                    </div>
                    @endif
                </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Notas Internas</h6>
                        <nav class="nav nav-with-icon tx-13">
                            <a href="" class="nav-link" data-toggle="modal" data-target="#noteModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Nueva Nota</a>
                        </nav>
                    </div>

                    <div class="card-body">
                        @if($order->notes->count())
                            @foreach($order->notes as $note)
                            <div class="note-row row align-items-center">
                                <div class="col-2">
                                    <div class="user-image text-center mr-3">
                                        @if( $note->user->image == NULL)
                                        <img class="thumb-md rounded-circle mr-4" width="50" src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($note->user->email))) . '?d=retro&s=200' }}" alt="{{ $note->user->name }}">
                                        @else
                                        <img  class="thumb-md rounded-circle mr-4" width="50" src="{{ asset('img/usuarios/' . $note->user->image ) }}" alt="{{ $note->user->name }}">
                                        @endif

                                        <p class="mb-0">{{ $note->user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="speech-wrap">
                                        <div class="speech-bubble">
                                            <p>{{ $note->note }}</p>
                                            <p class="mb-0"><small>{{ $note->created_at }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center my-5">
                            <h4 class="mb-0">No hay comentarios en esta orden todavía.</h4>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mg-t-10 mb-4">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Histórico de Orden</h6>
                        @php
                            $logs = Nowyouwerkn\WeCommerce\Models\Notification::where('type', 'Orden')->where('model_id', $order->id)->get();
                        @endphp
                    </div>

                    @if($logs->count() != 0)
                        @include('wecommerce::back.layouts.partials._notification_table')
                    @else
                    <div class="card-body">
                        <h6 class="mb-0">No hay cambios en esta orden de compra todavía.</h6>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </span>

    <div class="row">
        <div class="col-md-4 mt-3">
            <button id="print" class="btn btn-default btn-primary btn-block btn-lg mt-4" type="button"> <span><i class="fa fa-print"></i> Imprimir Orden</span></button>
        </div>
    </div>

    <div class="modal fade" id="trackingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Guía de Envío</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('tracking.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Servicio / Proveedor</label>
                                    <input type="text" class="form-control" name="service_name" placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número de Guía</label>
                                    <input type="text" class="form-control" name="tracking_number" placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nota de Guía / Productos en Envío</label>
                                    <textarea class="form-control" name="products_on_order" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="user_id" value="{{ $order->user->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Comentario</label>
                                    <textarea class="form-control" name="note" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resendMail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reenviar Confirmación por Correo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('resend.order.mail', $order->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Reenviar a:</label>
                                    <input type="email" name="email" class="form-control" value="{{ $order->user->email }}">
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Reenviar Ahora</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>

<script>
$(document).ready(function() {
    $("#print").click(function() {
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: true,
            extraCss : "{{ asset('assets/css/PrintArea.css') }}"
        };
        $("span.printableArea").printArea(options);
    });
});
</script>
@endpush
