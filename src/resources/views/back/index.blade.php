@extends('wecommerce::back.layouts.main')

<style type="text/css">
  .btn-pagado {
        color: #fff;
        background-color: #10b759;
        border-color: #10b759;
        padding: 10px;
    }

    .btn-empaquetado {
        color: #1c273c;
        background-color: #ffc107;
        border-color: #ffc107;
        padding: 10px;
    }

    .btn-pendiente {
        color: #fff;
        background-color: #3b4863;
        border-color: #3b4863;
        padding: 10px;
    }

    .btn-enviado {
        color: #fff;
        background-color: #00b8d4;
        border-color: #00b8d4;
        padding: 10px;
    }

    .btn-entregado {
        color: #fff;
        background-color: #7987a1;
        border-color: #7987a1;
        padding: 10px;
    }

    .btn-cancelado {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        padding: 10px;
    }

    .btn-expirado {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        padding: 10px;
    }
</style>

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

@if(empty($product) || empty($payment) || empty($shipment) || empty($category))
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-3">Acciones Recomendadas</h1>
    </div>
</div>
@endif

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
    <div class="col-md-6 mb-2">
        <div class="card card-body h-100">
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
    <div class="col-md-6 mb-2">
        <div class="card card-body h-100">
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
    <div class="col-md-6 mb-2">
        <div class="card card-body h-100">
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

@if(empty($product) || empty($payment) || empty($shipment) || empty($category))
<hr>
@endif

<div class="row row-xs mb-3">
    <div class="col-md-3">
        <div class="card card-body mb-3">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Ventas Totales</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">${{ number_format($ven_total, 2) }} MXN</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success"><i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>

        <div class="card card-body mb-3">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Clientes Nuevos</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ $new_clients }} </h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-info">esta semana.</span></span></p>
            </div>
        </div>

        <div class="card card-body mb-3">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Orden Promedio</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">${{ number_format($avg_order, 2) }} MXN</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">0 <i class="icon ion-md-arrow-up"></i></span></p>
            </div>
        </div>

        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Órdenes</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ $new_orders->count() }}</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-info">esta semana.</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
              <h6 class="mg-b-0">Resumen de Ventas</h6>
              <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0">
                    <li class="list-inline-item d-flex align-items-center">
                      <span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span>
                      <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Semana en curso</span>
                    </li>
                    <li class="list-inline-item d-flex align-items-center mg-l-5">
                      <span class="d-block wd-10 ht-10 bg-df-2 rounded mg-r-5"></span>
                      <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Semana Anterior</span>
                    </li>
                  </ul>
            </div>
            <div class="card-body">
                
                @if($new_orders->count() == 0)
                <p>Esta semana no ha habido pedidos</p>
                @else 
                <div class="chart-container chart">
                    <canvas id="salesChart" style="height:310px;"></canvas>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!--
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
            </div>
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
            </div>
          </div>
    </div>
    -->
</div>

<div class="row row-xs">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mg-b-0">Inventario Total</h6>
            </div>

            <div class="card-body tx-center">
                <h4 class="tx-normal tx-rubik tx-40 tx-spacing--1 mg-b-0">{{ number_format($total_stock) }}</h4>
                <p class="tx-12 tx-uppercase tx-semibold tx-spacing-1 tx-color-02">Productos</p>
                <p class="tx-12 tx-color-03 mg-b-0">Esta es la cantidad de existencias totales de tus productos publicados (Se contabiliza el stock total de acuerdo a variantes o individuales)</p>
            </div>

            <div class="card-footer bd-t-0 pd-t-0">
                <a href="{{ route('stocks.index') }}" class="btn btn-sm btn-block btn-outline-primary btn-uppercase tx-spacing-1">Ir a Inventario</a>
            </div>
      </div>
    </div>
</div>
<br>
<div class="row row-xs">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mg-b-0">Status de ordenes</h6>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-6">
                   <p class="tx-12 tx-uppercase tx-spacing-1 tx-color-02">Entregado</p>
                </div>
                <div class="col-6">
                   <strong class="btn-entregado">{{$total_entregado}}</strong> 
                </div>
                <div class="col-10"><hr></div>
                  <div class="col-6">
                   <p class="tx-12 tx-uppercase tx-spacing-1 tx-color-02">Enviado</p>
                </div>
                <div class="col-6">
                   <strong class="btn-enviado">{{$total_enviado}}</strong> 
                </div>
                  <div class="col-10"><hr></div>
                  <div class="col-6">
                   <p class="tx-12 tx-uppercase tx-spacing-1 tx-color-02">Pagado</p>
                </div>
                <div class="col-6">
                   <strong class="btn-pagado">{{$total_pagado}}</strong>
                </div>
                  <div class="col-10"><hr></div>
                <div class="col-6">
                         <p class="tx-12 tx-uppercase tx-spacing-1 tx-color-02">Expirado</p>
                </div>
                <div class="col-6">
                    <strong class="btn-expirado">{{$total_expirado}}</strong> 
                </div>
                <div class="col-10"><hr></div>
                <div class="col-6">
                         <p class="tx-12 tx-uppercase tx-spacing-1 tx-color-02">Cancelado</p>
                </div>
                <div class="col-6">
                        <strong class="btn-cancelado">{{$total_cancelado}}</strong> 
                </div>
              </div>
               
                
          
                
                
            </div>

            <div class="card-footer bd-t-0 pd-t-0">
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-block btn-outline-primary btn-uppercase tx-spacing-1">Ir a ordenes</a>
            </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('lib/chart.js/Chart.bundle.min.js') }}"></script>

<script>
    var ctxData1 = [{{ $lun . ',' . $mar . ',' . $mie . ',' . $jue . ',' . $vie . ',' . $sab . ',' . $dom }}];
    var ctxData2 = [{{ $pre_lun . ',' . $pre_mar . ',' . $pre_mie . ',' . $pre_jue . ',' . $pre_vie . ',' . $pre_sab . ',' . $pre_dom }}];
    var ctxColor1 = '#0168fa';
    var ctxColor2 = '#69b2f8';

    // Line chart
      var ctx4 = document.getElementById('salesChart');
      new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            datasets: [
                {
                    data: ctxData1,
                    borderColor: ctxColor1,
                    borderWidth: 1,
                    fill: false
                },{
                    data: ctxData2,
                    borderColor: ctxColor2,
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false,
              labels: {
                display: false
              }
          },
          scales: {
            yAxes: [{
              gridLines: {
                color: '#e5e9f2'
              },
              ticks: {
                beginAtZero:true,
                fontSize: 10,
                @if($max == 0)
                stepSize: 5,
                @else
                stepSize: {{ $max/10 }},
                @endif
                min: 0,
                @if($max == 0)
                    max: 10,
                @else
                    max: {{ $max * 1.1 }},
                @endif
                padding: 20
              }
            }],
            xAxes: [{
              gridLines: {
                display: false
              },
              ticks: {
                beginAtZero:true,
                fontSize: 11
              }
            }]
          }
        }
      });
</script>
@endpush