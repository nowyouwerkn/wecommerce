@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vista General</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Vista General</h4>
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

<style>
  .crypto-icon-sm{
    font-size:11px;
  }
</style>
<div class="row row-xs mb-3">
  <div class="col-md-3">
    <div class="card mb-3" style="height:515px;">
      <div class="card-header pd-y-20" style="border-bottom:0px;">
        <h6 class="mg-b-0">Estatus de Órdenes</h6>
      </div>

      <ul class="list-unstyled mb-4">
        <li class="list-item">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-pagado">
              <i class="fas fa-check"></i> 
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Pagado</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_pagado }}</p>
          </div>
        </li>
        <li class="list-item">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-empaquetado">
              <i class="fas fa-box"></i>
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Empaquetado</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_empaquetado }}</p>
          </div>
        </li>
        <li class="list-item">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-enviado">
              <i class="fas fa-truck"></i>
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Enviado</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_enviado }}</p>
          </div>
        </li>
        <li class="list-item">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-entregado">
              <i class="fas fa-dolly"></i>
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Entregado</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_entregado }}</p>
          </div>
        </li>
        <li class="list-label mb-3">Total de Ordenes Exitosas: {{ $total_entregado +  $total_enviado + $total_empaquetado + $total_pagado}}</li>

        <li class="list-item" style="border-top:0px;">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-sin-completar">
              <i class="fas fa-user-clock"></i>
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Sin Completar</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_sincompletar }}</p>
          </div>
        </li>
        <li class="list-item">
          <div class="media align-items-center">
            <div class="crypto-icon crypto-icon-sm btn-cancelado">
              <i class="fas fa-times"></i> 
            </div>
            <div class="media-body mg-l-15">
              <p class="tx-medium mg-b-0">Canceladas</p>
            </div>
          </div><!-- media -->
          <div class="text-right">
            <p class="tx-normal tx-rubik mg-b-0">{{ $total_cancelado }}</p>
          </div>
        </li>
      </ul>

      <div class="card-footer bd-t-0 pd-t-0">
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-block btn-outline-primary btn-uppercase tx-spacing-1">Ir a órdenes</a>
      </div>
    </div>

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

  <div class="col-md-9">
    <div class="card mb-3" style="height:515px;">
      <div class="card-header pd-y-20 d-md-flex align-items-center justify-content-between">
        <h6 class="mg-b-0">Resumen de Ventas</h6>
        <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0">
          <li class="list-inline-item d-flex align-items-center">
            <span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span>
            <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Semana en curso</span>
          </li>
          <li class="list-inline-item d-flex align-items-center mg-l-5">
            <span class="d-block wd-10 ht-10 bg-gray-600 rounded mg-r-5"></span>
            <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Semana Anterior</span>
          </li>
        </ul>
      </div>
      <div class="card-body pos-relative">
        <div class="t-20 l-20 wd-xl-100p z-index-10 mb-4">  
          <div class="row">
              <div class="col-sm-4">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5">${{ number_format($ven_total, 2) }}</h3>
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10">Ventas del Año</h6>
                  <p class="mg-b-0 tx-12 tx-color-03">Rango: {{ Carbon\Carbon::now()->startOfYear()->translatedFormat('d M Y') }} al {{ Carbon\Carbon::today()->translatedFormat('d M Y') }}</p>
                </div><!-- col -->
                <div class="col-sm-4">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5">${{ number_format($ven_semana, 2) }}
                    @if($ven_semana > $ven_semana_prev) 
                    <span class="tx-small tx-success"><i class="icon ion-md-arrow-up"></i></span>
                    @else
                    <span class="tx-small tx-danger"><i class="icon ion-md-arrow-down"></i></span>
                    @endif
                  </h3>
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10 d-flex align-items-center"><span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span> Ventas Semana en Curso</h6>
                  <p class="mg-b-0 tx-12 tx-color-03">Rango: {{ Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::MONDAY)->translatedFormat('d M Y') }} al {{ Carbon\Carbon::now()->endOfWeek(Carbon\Carbon::SUNDAY)->translatedFormat('d M Y') }}</p>
                </div><!-- col -->
                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                  <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5">${{ number_format($ven_semana_prev, 2) }} </h3>
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10 d-flex align-items-center"><span class="d-block wd-10 ht-10 bg-gray-600 rounded mg-r-5"></span> Ventas Semana Anterior</h6>
                  <p class="mg-b-0 tx-12 tx-color-03">Rango: {{ Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::MONDAY)->subWeek(1)->translatedFormat('d M Y') }} al {{ Carbon\Carbon::now()->endOfWeek(Carbon\Carbon::SUNDAY)->subWeek(1)->translatedFormat('d M Y') }}</p>
                </div><!-- col -->
              </div><!-- row -->
          </div>
          @if($new_orders == 0)
          <div class="d-block text-center mt-5 pt-2">
            <img src="{{ asset('assets/img/group_6.svg') }}" class="wd-30p mg-l-20">

            <div class="mg-l-40 mt-4">
              <h6 class="mb-2">Esta semana ni la anterior han tenido pedidos</h6>
              <p class="tx-color-03 mg-b-10">Promociona tus productos para llegar a mas gente interesada.</p>
            </div>
          </div>
          @else 
          <div class="chart-container chart">
              <canvas id="salesChart" style="height:310px;"></canvas>
          </div>
          @endif
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-md-4">
        <div class="card card-body mb-3">
          <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Clientes Nuevos</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
              <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ $new_clients }} </h3>
              <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-info">esta semana.</span></span></p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-body mb-3">
          <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Orden Promedio</h6>
          <div class="d-flex d-lg-block d-xl-flex align-items-end">
            <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">${{ number_format($avg_order, 2) }}</h3> 
          </div>
          
          <div class="tx-12 tx-color-03 mt-1">Rango: {{ Carbon\Carbon::now()->startOfYear()->translatedFormat('d M Y') }} al {{ Carbon\Carbon::today()->translatedFormat('d M Y') }}</div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-body">
            <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Órdenes</h6>
            <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ $new_orders }}</h3>
                <p class="tx-11 tx-color-03 mg-b-0">
                  @if($percent_diff_orders > 0)
                  <span class="tx-medium tx-success">{{ $percent_diff_orders }}% <i class="icon ion-md-arrow-up"></i></span>
                  @else
                  <span class="tx-medium tx-danger">{{ $percent_diff_orders }}% <i class="icon ion-md-arrow-down"></i></span>
                  @endif
                  que la semana anterior.
                </p>
            </div>
            <div class="tx-12 tx-color-03 mt-1">Comparativa semana en curso vs. anterior.</div>
        </div>
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
    var ctxColor2 = '#7987a1';

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
                    borderWidth: 3,
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