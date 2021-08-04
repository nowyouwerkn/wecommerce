@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Ordenes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orden # {{ $order->id }}</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Orden # {{ $order->id }}</h4>
    </div>

    <div class="d-none d-md-block">
        <a class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5" href="#" onclick="event.preventDefault(); document.getElementById('status-form').submit();">
            Cancelar Orden

            <form id="status-form" action="{{ route('order.status', $order->id) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input type="text" name="status" value="Cancelar Orden">
            </form>
        </a>

        <a href="{{ route('orders.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
            <i class="fas fa-undo mr-1"></i> Regresar al listado
        </a>
    </div>
</div>
@endsection

@push('stylesheets')
<style type="text/css">
    .payment_id{
        width: 100%;
        line-height: 1.3em;
        padding: 10px 20px;
        color: #fff;
        background-color: #C4B795 !important;
    }

    .note-row{
        margin-bottom: 30px;
    }

    .speech-bubble {
        position: relative;
        background: #c8d6e5;
        border-radius: .4em;
        color: #222f3e;
        padding: 20px 30px;
    }

    .speech-bubble:after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 22px solid transparent;
        border-right-color: #c8d6e5;
        border-left: 0;
        border-top: 0;
        margin-top: -11px;
        margin-left: -22px;
    }

    .just-one-image{
        width: 85px;
        height: 85px;
        overflow: hidden;
        position: relative;
    }

    .just-one-image img{
        position: absolute;
        top: 0px;
    }

    .icon-cards-row .card-text{
        height: 20px;
    }

    .icon-cards-row small{
        text-transform: uppercase;
        opacity: .8;
        color: #8f8f8f;
        margin-bottom: 10px;
        font-size: .6em;
        display: block;
    }

    .icon-cards-row .card-body {
        padding: 1.3rem 0.5rem;
    }

    .well{
        border-radius: 15px;
        border: 1px solid rgba(0,0,0,.2);
        padding: 20px 30px;
    }
</style>
@endpush

@section('content')

<div class="row mb-3">
    <div class="col-md-4">
        <div class="card text-white bg-info" style="height:91%;">
            <div class="card-body">
                <h2 class="card-title text-white" style="font-size: 3vw !important;">Order #{{ $order->id }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
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

            <div class="col-md-6">
                <div class="card border border-secondary h-100">
                    <div class="card-body text-secondary">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img class="img-fluid" src="{{ asset('assets/img/brands/stripe.png') }}">
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title text-secondary mb-1">ID de Pago</h5>
                                <p class="card-text">{{ $order->payment_id }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- Modal -->

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

    @if($order->is_completed == true)

    @else
        @if($order->status == NULL)
        @else
        <div class="bg-danger text-white p-3 mb-4">
            <h5 class="mb-0">Orden cancelada por Administración o Expiró el pago en la pasarela de Pago</h5>
        </div>
        @endif
    @endif

    @if($order->is_completed == true)
    <span class="printableArea">
    @else
        @if($order->status == NULL)
        <span class="printableArea">
        @else
        <span class="printableArea" style="opacity: .3;">
        @endif
    @endif
        <div class="row">
            <div class="col-md-4">
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
                        <p><span class="text-muted"><i class="wb wb-time"></i> {{ $order->created_at }}</span></p>

                        <h5 class="mb-1 mt-3">Estado:</h5>
                        @if($order->is_completed == true)
                        <div class="badge badge-success"><i class="icon-check mr-1"></i> Pagado</div>
                        @else
                            @if($order->status == NULL)
                            <div class="badge badge-table badge-warning"><i class="icon-close mr-1"></i> Pendiente</div>
                            @else
                            <div class="badge badge-table badge-danger"><i class="icon-close mr-1"></i> Cancelado</div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">  
                        <h4>Resumen de Orden</h4>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Total en Carrito:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->cart->totalPrice, 2) }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Envio:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->shipping_rate, 2) ?? 'N/A' }}</strong></p>
                            </div>
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
                                <p class="mb-0" style="font-size: 1.3em;"><strong>${{ number_format($order->total, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                    </div>

                    <!--<a class="btn btn-sm btn-block btn-primary" href="https://dashboard.stripe.com/payments/{{ $order->payment_id }}" target="_blank">See this Summary on Stripe <i class="icon-link ml-1"></i></a>-->
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">Carrito</h4>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>Total: ${{ number_format($order->cart->totalPrice) }}</strong></p>
                            </div>
                        </div>
                        <hr>

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

                        <hr class="dont-print">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#resendMail" class="btn btn-outline-info dont-print"><i class="iconsminds-mail-send"></i> Reenviar confirmación de orden</a>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="mb-0">Guía de Envío</h4>
                                    </div>
                                    <div class="col text-right dont-print">
                                        <a data-toggle="modal" data-target="#trackingModal" class="btn btn-outline-secondary"><i class="iconsminds-box-close"></i> Adjuntar Guía</a>
                                    </div>
                                </div>
                                <hr>

                                @if($order->trackings->count())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Guía</th>
                                                <th>Notas</th>
                                                <th>Estado</th>
                                                <th>Entrega</th>
                                                <th class="dont-print">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->trackings as $tracking)
                                            <tr>
                                                <td>{{ $tracking->service_name }}</td>
                                                <td>{{ $tracking->tracking_number }}</td>
                                                <td>{{ $tracking->products_on_order }}</td>
                                                <td>
                                                    @if($tracking->status == 'En proceso')
                                                    <span class="badge badge-warning">{{ $tracking->status }}</span>
                                                    @endif
                                                    @if($tracking->status == 'Completado')
                                                    <span class="badge badge-success">{{ $tracking->status }}</span>
                                                    @endif
                                                    @if($tracking->status == 'Perdido')
                                                    <span class="badge badge-warning">{{ $tracking->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($tracking->is_delivered  == true)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-success disabled"><i class="simple-icon-check"></i> Entregado</a>
                                                    @else
                                                    <a href="{{ route('tracking.complete', $tracking->id) }}" class="btn btn-sm btn-info"><i class="simple-icon-check"></i> Marcar Entrega</a>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap dont-print">
                                                    <a href="" class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="tooltip" data-original-title="Reenviar correo">
                                                        <i class="iconsminds-mail-send"></i> Reenviar correo
                                                    </a>

                                                    <form method="POST" action="{{ route('tracking.destroy', $tracking->id) }}" style="display: inline-block;">
                                                        <button type="submit" class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="tooltip" data-original-title="Borrar">
                                                            <i class="simple-icon-trash" aria-hidden="true"></i>
                                                        </button>
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @else
                                <div class="text-center my-5">
                                    <h4 class="mb-0">¡Todavía no se asigna una guía para esta orden!</h4>
                                    <p>¡Realiza el proceso necesario para comenzar!</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mb-2 mt-1">Dirección de Envío </h5>
                                        <ul class="list-unstyled">
                                            <li><strong>Calle + Num:</strong> {{ $order->street }} {{ $order->street_num }}</li>
                                            <li><strong>Código Postal:</strong> {{ $order->postal_code }}</li>

                                            <li><strong>Ciudad:</strong> {{ $order->city }}</li>
                                            <li><strong>Estado:</strong> {{ $order->state }}</li>
                                            <li><strong>País:</strong> {{ $order->country }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDhjSfxxL1-NdSlgkiDo5KErlb7rXU5Yw4&q={{ str_replace(' ', '-', $order->street . ' ' . $order->street_num) }},{{ $order->city }},{{ $order->state }},{{ $order->country }}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen class="mt-0 dont-print"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">Notas Internas</h4>
                            </div>
                            <div class="col text-right dont-print">
                                <a data-toggle="modal" data-target="#noteModal" class="btn btn-outline-secondary"><i class="iconsminds-box-close"></i> Nueva Nota</a>
                            </div>
                        </div>
                        <hr>

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
                                <label>Nota de Guía / Productos en Envio</label>
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
                                <label>Comment</label>
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