@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Envíos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Envíos</h4>
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

            <h3>Pasarelas de Envío</h3>
            <p>Genera guías y calcula automáticamente los envios usando pasarelas de pago.</p>

            <p>Tu tienda puede vincularse con: </p>

            <ul>
                <li>UPS (Cálculo de Énvio Solo Estados Unidos)</li>
                <li>FedEx <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>Estafeta <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>DHL <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>Gearcom <span class="badge badge-info">PROXIMAMENTE</span></li>
            </ul>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card card-body mb-4 payment-methods">
            <h4>Configuración Manual</h4>
            <p class="mb-4">Guarda tu configuración de envíos en tu plataforma.</p>
            <a href="" class="btn btn-outline-primary btn-sm">Configurar Manualmente</a>
        </div>

        <div class="card card-body mb-4">
            <h4>Pasarelas de Envío</h4>
            <p class="mb-4"><strong>(Solo puedes tener activado uno a la vez)</strong></p>

            <div class="row payment-methods">
                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($ups_method->is_active ?? '' == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/ups.png') }}" width="120" style="margin: 10px 0px;">

            
                        <a href="" data-toggle="modal" data-target="#modalCreateUPS" class="btn btn-outline-secondary btn-sm">Configurar UPS</a>
                        <a href="https://www.ups.com/mx/es/Home.page" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                </div>
            </div>
            <a href="{{ route('shipments.create') }}" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Agregar Otro Método</a>
        </div>
    </div>
</div>

<div id="modalCreateUPS" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con UPS</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="auto">
                <input type="hidden" name="supplier" value="UPS">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/ups.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de esta pasarela se activará automáticamente. Si tienes otro método de envío se desactivará.</p>
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