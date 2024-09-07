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

    .sandbox{
        top:40px !important;
    }

    .btn-danger {
        margin-top: 10px;
    }
    #sandbox-keys-stripe{
        display: none;
    }
    #sandbox-keys-conekta{
        display: none;
    }
    #sandbox-keys-openpay{
        display: none;
    }
    #sandbox-keys-oxxopay{
        display: none;
    }
    #sandbox-keys-mercadopago{
        display: none;
    }
    #sandbox-keys-paypal{
        display: none;
    }
    #sandbox-keys-kueski{
        display: none;
    }
    #sandbox-keys-aplazo{
        display: none;
    }

    .change-sandbox {
        color: white !important;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
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
                <li>MercadoPago</li>
                <li>Kueski Pay</li>
                <ul>
                    <li>Sistema de créditos personales.</li>
                </ul>

                <li>Aplazo</li>
                <ul>
                    <li>Sistema de créditos personales.</li>
                </ul>
            </ul>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card card-body payment-methods h-100">
                    @if($paypal_method->is_active == false)
                    <span class="badge badge-danger">Desactivado</span>
                    @else
                    <span class="badge badge-success">Activado</span>
                    @endif
                    @if($paypal_method->sandbox_mode == false)
                    <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                    @else
                    <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                    @endif

                    <img src="{{ asset('assets/img/brands/paypal.png') }}" width="120" style="margin: 10px 0px;">
                    <h4>Express Checkout</h4>
                    <p class="mb-4">Un botón que les permite a los clientes utilizar PayPal directamente desde tu pantalla de pago.</p>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreatePaypal" class="btn btn-outline-primary btn-sm">Configurar Paypal Checkout</a>
                     @if($paypal_method->is_active == true)
                        <a href="{{ route('payments.status', $paypal_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-body payment-methods h-100">
                    @if($mercadopago_method->is_active == false)
                    <span class="badge badge-danger">Desactivado</span>
                    @else
                    <span class="badge badge-success">Activado</span>
                    @endif
                    @if($mercadopago_method->sandbox_mode == false)
                    <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                    @else
                    <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                    @endif

                    <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" width="120" style="margin: 10px 0px;">
                    <h4>MercadoPago SDK</h4>
                    <p class="mb-4">Un botón que les permite a los clientes pagar por medio de MercadoPago.</p>
                    <a href="" data-toggle="modal" data-target="#modalCreateMercadoPago" class="btn btn-outline-primary btn-sm">Configurar MercadoPago</a>
                     @if($mercadopago_method->is_active == true)
                         <a href="{{ route('payments.status', $mercadopago_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                    @endif
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card card-body payment-methods h-100">
                    @if($kueski_method->is_active == false)
                    <span class="badge badge-danger">Desactivado</span>
                    @else
                    <span class="badge badge-success">Activado</span>
                    @endif
                    @if($kueski_method->sandbox_mode == false)
                    <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                    @else
                    <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                    @endif

                    <img src="{{ asset('assets/img/brands/kueski.jpg') }}" width="120" style="margin: 10px 0px;">
                    <h4>Kueski Pay</h4>
                    <p class="mb-4">Un botón que les permite a los clientes solicitar un crédito a Kueski directamente desde tu pantalla de pago.</p>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateKueski" class="btn btn-outline-primary btn-sm">Configurar Kueski</a>
                     @if($kueski_method->is_active == true)
                        <a href="{{ route('payments.status', $kueski_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar</a>  
                    @endif
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card card-body payment-methods h-100">
                    @if($aplazo_method->is_active == false)
                    <span class="badge badge-danger">Desactivado</span>
                    @else
                    <span class="badge badge-success">Activado</span>
                    @endif
                    @if($aplazo_method->sandbox_mode == false)
                    <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                    @else
                    <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                    @endif

                    <img src="{{ asset('assets/img/brands/aplazo.png') }}" width="120" style="margin: 10px 0px;">
                    <h4>Aplazo</h4>
                    <p class="mb-4">Un botón que les permite a los clientes solicitar un crédito con Aplazo directamente desde tu pantalla de pago.</p>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateAplazo" class="btn btn-outline-primary btn-sm">Configurar Aplazo</a>
                     @if($aplazo_method->is_active == true)
                        <a href="{{ route('payments.status', $aplazo_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar</a>  
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-body mb-4">
            <h4>Tarjetas de Crédito y Débito</h4>
            <p class="mb-4">Acepta pagos con tarjetas de crédito y débito con alguno de estos proveedores. <strong>(Solo puedes tener activado uno a la vez).</strong></p>

            <div class="row payment-methods">
                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($conekta_method->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        @if($conekta_method->sandbox_mode == false)
                        <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                        @else
                        <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/conekta.png') }}" width="120" style="margin: 10px 0px;">

                        <p>Comisión: 2.9% + 2.50 MXN + IVA Por transacción exitosa</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateConekta" class="btn btn-outline-secondary btn-sm">Configurar Conekta</a>
                        <a href="http://www.conekta.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                         @if($conekta_method->is_active == true)
                             <a href="{{ route('payments.status', $conekta_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                        @endif
                    </div>
                    
                </div>

                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($stripe_method->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        @if($stripe_method->sandbox_mode == false)
                        <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                        @else
                        <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/stripe.png') }}" width="80" style="margin-bottom: 10px;">
                        <p>Comisión: 3,6 % + 3 MXN por cargo con tarjeta efectuado con éxito</p>

                        
                        <a href="" data-toggle="modal" data-target="#modalCreateStripe" class="btn btn-outline-secondary btn-sm">Configurar Stripe</a>
                        <a href="http://www.stripe.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                        @if($stripe_method->is_active == true)
                         <a href="{{ route('payments.status', $stripe_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                        @endif
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
                        @if($openpay_method->sandbox_mode == false)
                        <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                        @else
                        <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                        @endif
                        <a href="" data-toggle="modal" data-target="#modalCreateOpenPay" class="btn btn-outline-secondary btn-sm">Configurar OpenPay</a>
                        <a href="https://www.openpay.mx" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                        @if($openpay_method->is_active == true)
                            <a href="{{ route('payments.status', $openpay_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                        @endif
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
                        @if($oxxo_pay->sandbox_mode == false)
                        <span class="badge badge-danger sandbox">Modo sandbox: Desactivado</span>
                        @else
                        <span class="badge badge-success sandbox">Modo sandbox: Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/oxxopay.png') }}" width="120" style="margin: 10px 0px;">

                        <p class="mt-2">Comisión: 3.9% + IVA Por transacción exitosa. Tienda OXXO cobrará una comisión adicional de $13.00 pesos en cajas.</p>

                        <a href="" data-toggle="modal" data-target="#modalCreateOxxoConekta" class="btn btn-outline-secondary btn-sm">Configurar OxxoPay de Conekta</a>
                        <a href="http://www.conekta.com" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                        @if($oxxo_pay->is_active == true)
                            <a href="{{ route('payments.status', $oxxo_pay->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar método de pago">Desactivar método de pago</a>  
                        @endif
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
                <input id="sandbox_mode_paypal" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/paypal.png') }}" width="250" style="margin: 10px 0px;">
                    <div id="live-keys-paypal">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxpaypal()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Correo de Acceso(Producción)</label>
                            <input type="text" class="form-control" name="email_access" value="{{ $paypal_method->email_access }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Contraseña (Producción)</label>
                            <input type="text" class="form-control" name="password_access" value="{{ $paypal_method->password_access }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-paypal">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxpaypal()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Correo de Acceso (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_email_access" value="{{ $paypal_method->sandbox_email_access }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Contraseña (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_password_access" value="{{ $paypal_method->sandbox_password_access }}"/>
                        </div>
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

<div id="modalCreateMercadoPago" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con MercadoPago</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="MercadoPago">
                <input id="sandbox_mode_mercadopago" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" width="250" style="margin: 10px 0px;">

                    <div id="live-keys-mercadopago">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxmercadopago()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $mercadopago_method->private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{ $mercadopago_method->public_key }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-mercadopago">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxmercadopago()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" value="{{ $mercadopago_method->sandbox_private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" value="{{ $mercadopago_method->sandbox_public_key }}"/>
                        </div>
                    </div>
                         <div class="form-group mt-2">
                                <input type="hidden" id="oxxo_oxxo" name="mercadopago_oxxo" value="oxxo" >
                                <input type="checkbox" id="oxxo_none" name="mercadopago_oxxo" value="none" {{ ($mercadopago_method->mercadopago_oxxo == 'none') ? 'checked' : '' }}>
                                <label for="oxxo_none">Pago con oxxo</label>
                        </div>

                        <div class="form-group mt-2">
                                <input type="hidden" id="paypal_paypal" name="mercadopago_paypal" value="paypal">
                                <input type="checkbox" id="paypal_none" name="mercadopago_paypal" value="none" {{ ($mercadopago_method->mercadopago_paypal == 'none') ? 'checked' : '' }}>
                                <label for="paypal_none">Pago con Paypal</label>
                        </div>

                    <div class="alert alert-success">
                        <p class="mb-0">Este método de pago puede funcionar en conjunto con otros métodos de pago con tarjeta.</p>
                    </div>
                    <div class="alert alert-info mt-3">
                        <p class="mb-0">Las integraciones con Paypal y pagos en Efectivo estarán desactivadas para mercado pago.</p>
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

<div id="modalCreateKueski" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con Kueski</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="Kueski">
                <input id="sandbox_mode_kueski" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/kueski.jpg') }}" width="250" style="margin: 10px 0px;">
                    <div id="live-keys-kueski">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxkueski()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $kueski_method->private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{ $kueski_method->public_key }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-kueski">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxkueski()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" value="{{ $kueski_method->sandbox_private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" value="{{ $kueski_method->sandbox_public_key }}"/>
                        </div>
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

<div id="modalCreateAplazo" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con Aplazo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="card">
                <input type="hidden" name="supplier" value="Aplazo">
                <input id="sandbox_mode_aplazo" type="hidden" name="sandbox_mode" value="0">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/aplazo.png') }}" width="250" style="margin: 10px 0px;">
                    <div id="live-keys-aplazo">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxaplazo()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $aplazo_method->private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Merchant ID (Producción)</label>
                            <input type="text" class="form-control" name="merchant_id" value="{{ $aplazo_method->merchant_id }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-aplazo">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxaplazo()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" value="{{ $aplazo_method->sandbox_private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Merchant ID (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_merchant_id" value="{{ $aplazo_method->merchant_id }}"/>
                        </div>
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
                 <input id="sandbox_mode_oxxopay" type="hidden" name="sandbox_mode" value="0">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/oxxopay.png') }}" width="250" style="margin: 10px 0px;">

                    <div id="live-keys-oxxopay">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxoxxopay()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $oxxo_pay->private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{ $oxxo_pay->public_key }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-oxxopay">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxoxxopay()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" 
                             value="{{ $oxxo_pay->sandbox_private_key }}"/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" 
                             value="{{ $oxxo_pay->sandbox_private_key }}"/>
                        </div>
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
                <input id="sandbox_mode_conekta" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/conekta.png') }}" width="250" style="margin: 10px 0px;">

                       <div id="live-keys-conekta">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxconekta()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{$conekta_method->private_key}}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{$conekta_method->public_key}}" />
                        </div>
                    </div>
                    <div id="sandbox-keys-conekta">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxconekta()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" 
                             value="{{$conekta_method->sandbox_private_key}}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" 
                             value="{{$conekta_method->sandbox_private_key}}" />
                        </div>
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
                <input id="sandbox_mode_stripe" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/stripe.png') }}" width="250" style="margin: 10px 0px;">
                    <div id="live-keys-stripe">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxstripe()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $stripe_method->private_key }}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{ $stripe_method->public_key }}"/>
                        </div>
                    </div>
                    <div id="sandbox-keys-stripe">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxstripe()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" 
                            value="{{ $stripe_method->sandbox_private_key }}"/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" 
                             value="{{ $stripe_method->sandbox_public_key }}"/>
                        </div>
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
                <input id="sandbox_mode_openpay" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/openpay.png') }}" width="250" style="margin: 10px 0px;">

                    <div id="live-keys-openpay">
                        <h4>Estás en modo producción</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxopenpay()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Clave de Comerciante (Merchant ID)  (Producción)</label>
                            <input type="text" class="form-control" name="merchant_id" value="{{ $openpay_method->merchant_id}}" />
                        </div>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Producción)</label>
                            <input type="text" class="form-control" name="private_key" value="{{ $openpay_method->private_key}}" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Producción)</label>
                            <input type="text" class="form-control" name="public_key" value="{{ $openpay_method->public_key}}" />
                        </div>
                    </div>
                    <div id="sandbox-keys-openpay">
                        <h4>Estás en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxopenpay()">Cambiar a producción</a>
                        <div class="form-group mt-2">
                            <label>Clave de Comerciante (Merchant ID)  (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_merchant_id" 
                             value="{{ $openpay_method->sandbox_merchant_id}}"/>
                        </div>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" 
                             value="{{ $openpay_method->sandbox_private_key}}"/>
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" 
                            value="{{ $openpay_method->sandbox_public_key}}"/>
                        </div>
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
@endsection
@push('scripts')
<script type="text/javascript">

      function sandboxstripe() {
      var x = document.getElementById("live-keys-stripe");
      var y = document.getElementById("sandbox-keys-stripe");
      var z = document.getElementById("sandbox_mode_stripe");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }
    function sandboxconekta() {
      var x = document.getElementById("live-keys-conekta");
      var y = document.getElementById("sandbox-keys-conekta");
      var z = document.getElementById("sandbox_mode_conekta");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }   
    function sandboxopenpay() {
      var x = document.getElementById("live-keys-openpay");
      var y = document.getElementById("sandbox-keys-openpay");
      var z = document.getElementById("sandbox_mode_openpay");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }

    function sandboxoxxopay() {
      var x = document.getElementById("live-keys-oxxopay");
      var y = document.getElementById("sandbox-keys-oxxopay");
      var z = document.getElementById("sandbox_mode_oxxopay");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }    
        function sandboxmercadopago() {
      var x = document.getElementById("live-keys-mercadopago");
      var y = document.getElementById("sandbox-keys-mercadopago");
      var z = document.getElementById("sandbox_mode_mercadopago");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }
    function sandboxpaypal() {
      var x = document.getElementById("live-keys-paypal");
      var y = document.getElementById("sandbox-keys-paypal");
      var z = document.getElementById("sandbox_mode_paypal");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }  
    function sandboxkueski() {
      var x = document.getElementById("live-keys-kueski");
      var y = document.getElementById("sandbox-keys-kueski");
      var z = document.getElementById("sandbox_mode_kueski");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }  
    function sandboxaplazo() {
      var x = document.getElementById("live-keys-aplazo");
      var y = document.getElementById("sandbox-keys-aplazo");
      var z = document.getElementById("sandbox_mode_aplazo");
      if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
        z.value = 0;
      } else {
        x.style.display = "none";
        y.style.display = "block";
        z.value = 1;
      }
    }     

</script>

@endpush