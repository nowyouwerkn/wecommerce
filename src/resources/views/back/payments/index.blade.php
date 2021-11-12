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
                    <a href="" data-toggle="modal" data-target="#modalCreatePaypal" class="btn btn-outline-primary btn-sm">Configurar Paypal Checkout</a>
                     @if($paypal_method->is_active == true)
                        <a href="{{ route('payments.status', $paypal_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
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
                         <a href="{{ route('payments.status', $mercadopago_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
                    @endif
                </div>
            </div>
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
                             <a href="{{ route('payments.status', $conekta_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
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
                         <a href="{{ route('payments.status', $stripe_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
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
                        @if($paypal_method->is_active == true)
                            <a href="{{ route('payments.status', $openpay_method->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
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
                        @if($paypal_method->is_active == true)
                            <a href="{{ route('payments.status', $oxxo_pay->id) }}" class=" btn btn-danger" data-toggle="tooltip" data-original-title="Desactivar metodo de pago">Desactivar metodo de pago</a>  
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
                <input type="hidden" name="sandbox_mode" value="0">
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

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
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
                <input id="sandbox_mode_stripe" type="hidden" name="sandbox_mode" value="0">
                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/stripe.png') }}" width="250" style="margin: 10px 0px;">
                    <div id="live-keys-stripe">
                        <h4>Estas en modo produccion</h4>
                        <a class="btn btn-danger change-sandbox" onclick="sandboxstripe()">Cambiar a sandbox</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Produccion)</label>
                            <input type="text" class="form-control" name="private_key" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Produccion)</label>
                            <input type="text" class="form-control" name="public_key" />
                        </div>
                    </div>
                    <div id="sandbox-keys-stripe">
                        <h4>Estas en modo sandbox</h4>
                        <a class="btn btn-success change-sandbox" onclick="sandboxstripe()">Cambiar a proudccion</a>
                        <div class="form-group mt-2">
                            <label>Llave Privada (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_private_key" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Llave Pública (Sandbox)</label>
                            <input type="text" class="form-control" name="sandbox_public_key" />
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

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/openpay.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Clave de Comerciante (Merchant ID)</label>
                        <input type="text" class="form-control" name="merchant_id" />
                    </div>

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

</script>

@endpush