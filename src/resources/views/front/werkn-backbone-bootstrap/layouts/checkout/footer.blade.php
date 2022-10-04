<div class="we-co--pre-footer">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-6">
				<p class="me-5 mb-0">Cualquier pregunta o problema contacta con nuestro soporte al cliente</p>
			</div>
			
			<div class="col-12 col-md-6">
				<div class="d-flex align-items-center justify-content-end">
					@if($store_config->phone != NULL )
					<a href="" class="contact_action me-3"><ion-icon name="call"></ion-icon> {{ $store_config->phone }}</a>
					@endif

					@if($store_config->contact_email != NULL )
					<a href="" class="contact_action me-3"><ion-icon name="mail"></ion-icon> {{ $store_config->contact_email }}</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<footer class="we-co--footer text-center">
	<div class="container">
		<div class="we-co--reasurrence-links row align-items-center justify-content-between">
	        @if(!empty($card_payment))
	        <div class="col-6 col-md-3 mt-4">
	            <img src="{{ asset('img/icons/card-info.png') }}" style="height: 33px; margin-bottom: 5px; width: auto !important;">
	            <p>Aceptamos Todas las Tarjetas de Crédito</p>
	        </div>
	        @endif

	        @if(!empty($paypal_payment))
	        <div class="col-6 col-md-3 mt-4">
	            <img src="{{ asset('assets/img/brands/paypal.png') }}" style="height: 35px; width: auto !important;">
	            <p>Aceptamos pagos por medio de Paypal</p>
	        </div>
	        @endif

	        @if(!empty($mercado_payment))
	        <div class="col-6 col-md-3 mt-4">
	            <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" style="height: 30px; margin-bottom: 5px; width: auto !important;">
	            <p>Aceptamos pagos por medio de MercadoPago</p>
	        </div>
	        @endif

	        @if(!empty($cash_payment))
	        <div class="col-6 col-md-3 mt-4">
	            <img src="{{ asset('assets/img/brands/oxxopay.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
	            <p>Aceptamos pagos en efectivo en Oxxo</p>
	        </div>
	        @endif
		</div>
	
		<div class="row">
			<div class="col-12">
				<hr>
		        <ul class="we-co--menu-links row list-unstyled justify-content-between">
		            <li class="col-md col-12" ><a href="{{ route('index') }}">Inicio</a></li>
		            <li class="col-md col-12" ><a href="{{ route('catalog.all') }}">Catálogo</a></li>
		            @foreach($legals as $legal)
		            <li class="col-md" >
		                <a href="{{ route('legal.text' , $legal->slug) }}"> {{ $legal->title }}</a>
		            </li>
		            @endforeach
		        </ul>
			</div>
		</div>
	</div>
</footer>