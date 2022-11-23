@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item active" aria-current="page">Canales de Venta</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Canales de Venta</h4>
    </div>
    <div class="d-none d-md-block">

    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Canales de Venta</h3>
            <p>Conecta "marketplaces" de terceros en tu plataforma para ver las ordenes que surgen de tus otros canales y verlas centralizadas aqui.</p>

            <p>Tu tienda puede vincularse con: </p>

            <ul>
                <li>Facebook</li>
                <li>Instagram</li>
                <li>MercadoLibre</li>
                <li>Amazon</li>
                <li>Ebay</li>
                <li>Walmart</li>
                <li>y mas...</li>
            </ul>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="media align-items-center mb-5">
                    <img src="{{ asset('assets/img/brands/amazon.jpg') }}" class="wd-100 rounded mg-r-20" alt="">
                    <div class="media-body">
                        <span class="badge badge-warning">PRÓXIMAMENTE</span>
                        <h5 class="mg-b-15 tx-inverse">Amazon</h5>
                        Uno de las empresas más grandes de venta por internet. Conecta tu catálogo por medio de la API para aprovechar sus beneficios.
                    </div>
                </div>

                <div class="media align-items-center mb-5">
                    <img src="{{ asset('assets/img/brands/mercadolibre.png') }}" class="wd-100 rounded mg-r-20" alt="">
                    <div class="media-body">
                        <span class="badge badge-warning">PRÓXIMAMENTE</span>
                        <h5 class="mg-b-15 tx-inverse">MercadoLibre</h5>
                        El portal latinoamericano de ventas. Conecta tu catálogo por medio de la API para aprovechar sus beneficios.
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-block pt-4">
                    <h5>¿No encuentras a tu proveedor?</h5>
                    <p>Nosotros podemos ayudarte a integrar la API.</p>
                </div>
                
                <a href="javascript:void(0)" class="btn btn-outline-secondary disabled btn-block">Solicita una integración</a>
            </div>
        </div>
    </div>
</div>
@endsection