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
        <a href="{{ URL::previous() }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
            <i class="fas fa-undo mr-1"></i> Regresar
        </a>
    </div>
</div>
@endsection

@push('stylesheets')

@endpush

@section('content')
<div class="row">
	<div class="col-md-8 offset-md-2">
		<div id="printableArea" class="content tx-13">
		<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
		<div class="row">
		  <div class="col-sm-6">
		    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Enviar a</label>
		    <h6 class="tx-15 mg-b-10">{{ $order->client_name }}</h6>

		    <p class="mg-b-0">{{ $order->street }} {{ $order->street_num }} - {{ $order->suburb }}</p>
		    <p class="mg-b-0">{{ $order->city }}, {{ $order->state }}, {{ $order->country }}</p>
		    <p class="mg-b-0">{{ $order->postal_code }}</p>
		  </div>


		  <div class="col-sm-6 tx-right d-none d-md-block">
		    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Número de Orden</label>
		    <h1 class="tx-normal tx-color-04 mg-b-10 tx-spacing--2">
		        @if(strlen($order->id) == 1)
		        #00{{ $order->id }}
		        @endif
		        @if(strlen($order->id) == 2)
		        #0{{ $order->id }}
		        @endif
		        @if(strlen($order->id) > 2)
		        #{{ $order->id }}
		        @endif
		    </h1>
		  </div><!-- col -->
		</div><!-- row -->

		@if(!empty($shipping_option) && $shipping_option->type == 'pickup')
		<div class="row justify-content-between mt-4 mb-5">
			<div class="col-sm-6 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0 mt-3">
				<label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Recolección en Sucursal</label>
				<ul class="list-unstyled lh-7">
				<li class="d-flex justify-content-between">
					<span>{{ $shipping_option->name }}</span>
				</li>
				</ul>
			</div>
		</div>
		@else
			@if($order->trackings->count())
			<div class="row justify-content-between mt-4 mb-5">
				<div class="col-sm-6 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0 mt-3">
					<label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Guía de Seguimiento</label>
					<ul class="list-unstyled lh-7">
						<li class="d-flex justify-content-between">
							@foreach($order->trackings as $tracking)
								<p class="small-title">Número de Guía</p>
								<div class="tracking-number">
									<h4 class="mb-0">{{ $tracking->tracking_number }}</h4>
								</div>
							@endforeach
						</li>
					</ul>
				</div>
			</div>
			@endif
		@endif
		
		@if($order->cart == NULL)
		<div class="table-responsive mg-t-40">
		  <table class="table table-invoice bd-b">
		    <thead>
		      <tr>
		        <th>Producto</th>
		        <th>Variante</th>
		        <th class="tx-center">Cantidad</th>
		        <!--<th class="tx-right">Unit Price</th>
		        <th class="tx-right">Amount</th>-->
		      </tr>
		    </thead>
		    <tbody>
		    </tbody>
		</table>
    	<p class="alert alert-warning" style="margin-top: -17px;">Esta orden proviene de una importación de otro sistema. El "módulo carrito" no es compatible con la información y no puede mostrar los detalles.</p>
        @else
		<div class="table-responsive mg-t-40">
		  <table class="table table-invoice bd-b">
		    <thead>
		      <tr>
		        <th>Producto</th>
		        <th>Variante</th>
		        <th class="tx-center">Cantidad</th>
		        <!--<th class="tx-right">Unit Price</th>
		        <th class="tx-right">Amount</th>-->
		      </tr>
		    </thead>
		    <tbody>
		    @foreach($order->cart->items as $item)
		      <tr>
		        <td class="tx-nowrap">
		    	    <img height="40px" alt="{{ $item['item']['name'] }}" src="{{ asset('img/products/' . $item['item']['image'] ) }}" class="list-thumbnail responsive border-0 card-img-left">
		    	    {{ $item['item']['name'] }}
		    	</td>
		        <td class="d-none d-sm-table-cell tx-color-03">Talla: {{ $item['variant'] }}</td>
		        <td class="tx-center">{{ $item['qty'] }} Par</td>
		        <!--
		        <td class="tx-right">$150.00</td>
		        <td class="tx-right">$300.00</td>
		    	-->
		      </tr>
		      @endforeach
		    </tbody>
		  </table>
		</div>
		@endif

		<div class="row justify-content-between mt-4 mb-5">
			<div class="col-sm-6 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0 mt-3">
				<label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Información Adicional</label>
				<ul class="list-unstyled lh-7">
				<li class="d-flex justify-content-between">
					<span>Fecha de Compra</span>
					<span>{{ Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y - h:ia') }}</span>
				</li>
				<li class="d-flex justify-content-between">
					<span>Empaquetado:</span>
					<span>{{ Carbon\Carbon::now()->translatedFormat('d M Y - h:ia') }}</span>
				</li>
				</ul>
			</div><!-- col -->

			<div class="col-sm-6 col-lg-4 order-1 order-sm-0">
				<ul class="list-unstyled lh-7 pd-r-10">
				<li class="d-flex justify-content-between">
					<span>Subtotal</span>
					<span>${{ number_format($order->sub_total,2) }}</span>
				</li>
				<li class="d-flex justify-content-between">
					<span>Descuentos</span>
					<span>-${{ number_format($order->discounts ?? '0',2) }}</span>
				</li>
				<li class="d-flex justify-content-between">
					<strong>Total</strong>
					<strong>${{ number_format($order->payment_total,2) }}</strong>
				</li>
				</ul>
			</div>
		</div>

		<button id="print" class="btn btn-sm pd-x-15 btn-dark btn-uppercase mg-l-5 btn-block p-3" type="button"> <span><i class="fa fa-print"></i> Imprimir Lista de Empaque</span></button>
	</div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>

<script>
$(document).ready(function() {
    $("#print").click(function() {
        var options = {
            mode: 'iframe',
            strict: false,
            popClose: true,
            extraCss : "{{ asset('assets/css/PrintArea.css') }}"
        };

        $("#printableArea").printArea(options);
    });
});
</script>
@endpush 