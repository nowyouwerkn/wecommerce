<div class="we-co--pre-footer">
	<div class="d-flex justify-content-center">
		<p class="me-5 mb-0">Cualquier pregunta o problema contacta con nuestro soporte al cliente</p>

		@if($store_config->phone != NULL )
		<a href="" class="contact_action me-3"><ion-icon name="call"></ion-icon> {{ $store_config->phone }}</a>
		@endif

		@if($store_config->contact_email != NULL )
		<a href="" class="contact_action me-3"><ion-icon name="mail"></ion-icon> {{ $store_config->contact_email }}</a>
		@endif
	</div>
</div>

<footer class="we-co--footer text-center">
	<div class="we-co--reasurrence-links d-flex align-items-center justify-content-between">
        @if(!empty($card_payment))
        <div class="col mt-4">
            <img src="{{ asset('img/icons/card-info.png') }}" style="height: 33px; margin-bottom: 5px; width: auto !important;">
            <p>Aceptamos Todas las Tarjetas de Crédito</p>
        </div>
        @endif

        @if(!empty($paypal_payment))
        <div class="col mt-4">
            <img src="{{ asset('assets/img/brands/paypal.png') }}" style="height: 35px; width: auto !important;">
            <p>Aceptamos pagos por medio de Paypal</p>
        </div>
        @endif

        @if(!empty($mercado_payment))
        <div class="col mt-4">
            <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" style="height: 30px; margin-bottom: 5px; width: auto !important;">
            <p>Aceptamos pagos por medio de MercadoPago</p>
        </div>
        @endif

        @if(!empty($cash_payment))
        <div class="col mt-4">
            <img src="{{ asset('assets/img/brands/oxxopay.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
            <p>Aceptamos pagos en efectivo en Oxxo</p>
        </div>
        @endif
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<hr>
		        <ul class="we-co--menu-links d-flex list-unstyled justify-content-between">
		            <li><a href="{{ route('index') }}">Inicio</a></li>
		            <li><a href="{{ route('catalog.all') }}">Catálogo</a></li>
		            @foreach($legals as $legal)
		            <li>
		                <a href="{{ route('legal.text' , $legal->type) }}">
		                    @switch($legal->type)
		                        @case('Returns')
		                            Política de Devoluciones
		                            @break

		                        @case('Privacy')
		                            Política de Privacidad
		                            @break

		                        @case('Terms')
		                            Términos y Condiciones
		                            @break

		                        @case('Shipment')
		                            Política de Envíos
		                            @break

		                        @default
		                            Hubo un problema, intenta después.
		                    @endswitch 
		                </a>
		            </li>
		            @endforeach
		        </ul>
			</div>
		</div>
	</div>
</footer>