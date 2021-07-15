@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Werkn-Commerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Dashboard</h4>
        </div>
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-3">Acciones Recomendadas</h1>
    </div>
</div>

<div class="row row-xs">
    @if(empty($product))
    <div class="col-md-6">
        <div class="card card-body mb-2">
          <div class="media align-items-center">
            <img src="{{ asset('assets/img/new_1.svg') }}" class="wd-30p mg-l-20">

            <div class="media-body mg-l-40">
              <h6 class="mg-b-10">Crea tu primer producto</h6>
              <p class="tx-color-03 mg-b-10">Para que tus compradores puedan disfrutar de tu tienda y de tus productos tienes que dar de alta el primero. Comienza ahora.</p>
              <a href="{{ route('products.create') }}" class="btn btn-outline-primary btn-sm">Crear Producto</a>
            </div>
          </div><!-- media -->
        </div>
    </div>
    @endif

    @if(empty($payment))
    <div class="col-md-6">
        <div class="card card-body mb-2">
          <div class="media align-items-center">
            <img src="{{ asset('assets/img/new_2.svg') }}" class="wd-30p mg-l-20">

            <div class="media-body mg-l-40">
              <h6 class="mg-b-10">Configura tus métodos de pago</h6>
              <p class="tx-color-03 mg-b-10">Sin un método de pago configurado no se podrán procesar las compras que se hagan en tu sistema.</p>
              <a href="{{ route('payments.index') }}" class="btn btn-outline-primary btn-sm">Configurar Pagos</a>
            </div>
          </div><!-- media -->
        </div>
    </div>
    @endif

    @if(empty($shipment))
    <div class="col-md-6">
        <div class="card card-body mb-2">
          <div class="media align-items-center">
            <img src="{{ asset('assets/img/new_3.svg') }}" class="wd-30p mg-l-20">

            <div class="media-body mg-l-40">
              <h6 class="mg-b-10">Define tus costos de énvio</h6>
              <p class="tx-color-03 mg-b-10">El sistema puede calcular automáticamente costos de envío que tu definas. Si tu tienda está en EEUU puedes conectarla a una pasarla de envios como UPS</p>
              <a href="{{ route('shipments.index') }}" class="btn btn-outline-primary btn-sm">Configurar Envíos</a>
            </div>
          </div><!-- media -->
        </div>
    </div>
    @endif

    @if(empty($category))
    <div class="col-md-6">
        <div class="card card-body mb-2">
          <div class="media align-items-center">
            <img src="{{ asset('assets/img/new_4.svg') }}" class="wd-30p mg-l-20">

            <div class="media-body mg-l-40">
              <h6 class="mg-b-10">Crea tu primera colección de productos.</h6>
              <p class="tx-color-03 mg-b-10">Tener configurada una colección le permite a tus compradores encontrar más facilmente tus productos de acuerdo a sus preferencias de búsqueda.</p>
              <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-sm">Crear una Colección</a>
            </div>
          </div><!-- media -->
        </div>
    </div>
    @endif
</div>

<hr>

<div class="row row-xs">
    <div class="col-md-6">
        <div class="card card-body mb-2">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Ventas Totales</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Sesiones</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Orden Promedio</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0,00 MXN</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Ordenes Totales</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">0</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-body mb-2">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Top Producto</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">N/A</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Ventas Atribuidas a Marketing</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">$0,00 MXN</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mg-b-10">
            <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
              <div>
                <h6 class="mg-b-5">Conversión</h6>
                <p class="tx-13 tx-color-03 mg-b-0">Eventos registrados.</p>
              </div>
            </div><!-- card-header -->
            <div class="card-body pd-y-30">
              <div class="d-sm-flex">
                <div class="media">
                  <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                    <i data-feather="bar-chart-2"></i>
                  </div>
                  <div class="media-body">
                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Agregado al Carrito</h6>
                    <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">0</h4>
                  </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                  <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                    <i data-feather="bar-chart-2"></i>
                  </div>
                  <div class="media-body">
                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Checkout Iniciado</h6>
                    <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">0</h4>
                  </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                  <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                    <i data-feather="bar-chart-2"></i>
                  </div>
                  <div class="media-body">
                    <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Sesiones Convertidas</h6>
                    <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">0</h4>
                  </div>
                </div>
              </div>
            </div><!-- card-body -->
          </div><!-- card -->
    </div>
</div>
@endsection