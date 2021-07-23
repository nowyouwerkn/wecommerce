@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Pagos</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>

    <style type="text/css">
    .payment-methods .badge{
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Proveedores de pago</h3>
            <p>Acepta pagos en tu tienda, usando proveedores externos tales como Conekta u otros métodos de pago.</p>

            <p>Tu tienda acepta pagos con: </p>

            <ul>
                <li>Stripe</li>
                <ul>
                    <li>Tarjetas de Crédito y Débito</li>
                </ul>
                <li>Conekta</li>
                <ul>
                    <li>Tarjetas de Crédito y Débito</li>
                    <li>OxxoPay</li>
                    <li>Transferencias Bancarias</li>
                </ul>
                <li>OpenPay</li>
                <ul>
                    <li>Tarjetas de Crédito y Débito</li>
                </ul>

                <li>Paypal</li>
                <li>MercadoPago <span class="badge badge-info">PROXIMAMENTE</span></li>
            </ul>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card card-body mb-4 payment-methods">
            @if($paypal_method->is_active == false)
            <span class="badge badge-danger">Desactivado</span>
            @else
            <span class="badge badge-success">Activado</span>
            @endif

            <img src="{{ asset('assets/img/brands/paypal.png') }}" width="120" style="margin: 10px 0px;">
            <h4>Express Checkout</h4>
            <p class="mb-4">Un botón que les permite a los clientes utilizar PayPal directamente desde tu pantalla de pago.</p>
            <a href="" data-toggle="modal" data-target="#modalCreatePaypal" class="btn btn-outline-primary btn-sm">Configurar Paypal Checkout</a>
        </div>

        <div class="card card-body mb-4">
            <h4>Tarjetas de Crédito y Débito</h4>
            <p class="mb-4">Acepta pagos con tarjetas de crédito y débito con alguno de estos proveedores. <strong>(Solo puedes tener activado uno a la vez)</strong></p>

            <div class="row payment-methods">
                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($conekta_method->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/conekta.png') }}" width="120" style="margin: 10px 0px;">

                        <p>Comisión: 2.9% + 2.50 MXN + IVA Por transacción exitosa</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateConekta" class="btn btn-outline-secondary btn-sm">Configurar Conekta</a>
                        <a href="http://www.conekta.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                    
                </div>

                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($stripe_method->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/stripe.png') }}" width="80" style="margin-bottom: 10px;">

                        <p>Comisión: 3,6 % + 3 MXN por cargo con tarjeta efectuado con éxito</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateStripe" class="btn btn-outline-secondary btn-sm">Configurar Stripe</a>
                        <a href="http://www.stripe.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                </div>

                <div class="col-md-6  mt-4">
                    <div class="card card-body h-100">
                        @if($openpay_method->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/openpay.png') }}" width="110" style="margin-bottom: 20px;">

                        <p>Comisión: 2.9% + $2.5 MXN por cargo con tarjeta efectuado con éxito</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateOpenPay" class="btn btn-outline-secondary btn-sm">Configurar OpenPay</a>
                        <a href="https://www.openpay.mx" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                </div>
            </div>
            <!--<a href="{{ route('payments.create') }}" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Agregar Otro Método</a>-->
        </div>

        <div class="card card-body">
            <h4>Pagos en Efectivo</h4>
            <p class="mb-4">Empieza a cargar uno en tu plataforma usando el botón superior.</p>
            <!--<a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Agregar Nuevo Método</a>-->

            <div class="row payment-methods">
                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($oxxo_pay->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/oxxopay.png') }}" width="120" style="margin: 10px 0px;">

                        <p class="mt-2">Comisión: 3.9% + IVA Por transacción exitosa. Tienda OXXO Cobrará una comisión adicional de $13.00 pesos en cajas.</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateOxxoConekta" class="btn btn-outline-secondary btn-sm">Configurar OxxoPay de Conekta</a>
                        <a href="http://www.conekta.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="modalCreatePaypal" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con Paypal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="Paypal">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/paypal.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Correo de Acceso</label>
                        <input type="text" class="form-control" name="email_access" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Contraseña</label>
                        <input type="text" class="form-control" name="password_access" />
                    </div>

                    <div class="alert alert-success">
                        <p class="mb-0">Este método de pago puede funcionar en conjunto con otros métodos de pago con tarjeta. </p>
                    </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="modalCreateOxxoConekta" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con OxxoPay de Conekta</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="cash">
                <input type="hidden" name="supplier" value="Conekta">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/oxxopay.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de este método de pago se activará automáticamente. Si tienes otro método de pagó se desactivará.</p>
                    </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="modalCreateConekta" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con Conekta</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="Conekta">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/conekta.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de este método de pago se activará automáticamente. Si tienes otro método de pagó se desactivará.</p>
                    </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="modalCreateStripe" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con Stripe</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="Stripe">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/stripe.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de este método de pago se activará automáticamente. Si tienes otro método de pagó se desactivará.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalCreateOpenPay" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con OpenPay</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="OpenPay">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/openpay.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Clave de Comerciante (Merchant ID)</label>
                        <input type="text" class="form-control" name="merchant_id" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de este método de pago se activará automáticamente. Si tienes otro método de pagó se desactivará.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

{{-- 
@if($payments->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay métodos de pago guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar uno en tu plataforma usando el botón superior.</p>
    <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Agregar Nuevo Método</a>
</div>
@else

<div class="card-columns">
    @foreach($payments as $payment)
        <div class="card">
            <div class="action-btns">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#editModal_{{ $payment->id }}" class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-wrench"></i></a></li>
                    <li class="list-inline-item"><a  data-toggle="tooltip" title="" data-original-title="Detail" href="#" class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-eye"></i></a></li>

                    <li class="list-inline-item">
                        <form method="POST" action="{{ route('categories.destroy', $payment->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-rounded btn-icon btn-danger" data-toggle="tooltip" data-original-title="Delete">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>

                    </li>                    
                </ul>

                <div class="modal fade" id="editModal_{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('categories.update', $payment->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nombre del Elemento</label>
                                                <input type="text" class="form-control" name="name" value="{{ $payment->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($payment->image == NULL)
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/no_category.jpg') }}" alt="Imagen para {{ $payment->name }} no disponible">
            @else
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/' . $payment->image) }}" alt="{{ $payment->name }}">
            @endif

            <div class="card-body pb-0">
                <h5 class="card-title display-4 mb-1">{{ $payment->name }}</h5> 

                <p class="card-text">Productos en esta categoría: <span class="badge badge-info">{{ $payment->products->count() }}</span></p>

                <h5 class="card-title mt-3 mb-2">Sub-Categorías</h5>              
            </div>

            <ul class="mt-0 list-group list-group-flush">
                @foreach($payment->children as $sub)
                <li class="d-flex align-items-center justify-content-between list-group-item">
                    <div>
                        <a href="#">{{ $sub->name }} 
                            <span class="badge badge-info">{{ $sub->products->count() }}</span>
                        </a>
                    </div>
                    <div style="transform: scale(.8);">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#editModalSub_{{ $sub->id }}" class="btn btn-rounded btn-icon btn-sm btn-dark"><i class="fas fa-wrench"></i></a>

                        <form method="POST" action="{{ route('categories.destroy', $sub->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-rounded btn-icon btn-sm btn-danger" data-toggle="tooltip" data-original-title="Delete">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </li>
                <div class="modal fade" id="editModalSub_{{ $sub->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('categories.update', $sub->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <input type="hidden" name="parent_id" value="{{ $sub->parent_id }}">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name of Element</label>
                                                <input type="text" class="form-control" name="name" value="{{ $sub->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </ul>

            
            <div class="card-body">
                <p class="card-text mb-0">
                    <small class="text-muted">Creado: {{ $payment->created_at }}</small>
                </p>
                <p class="card-text mb-0">
                    <small class="text-muted">Actualizado: {{ $payment->updated_at }}</small>
                </p>
            </div>
        </div>    
    @endforeach
</div>

<div class="row justify-items-center">
    <div class="col text-center">
        {{ $payments->links() }}
    </div>
</div>

@endif
--}}
@endsection