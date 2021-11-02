@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<div class="legal-area">
    <div class="container">
    	<div class="row special-title text-center">
            <span class="text-background">Información Legal</span>
                <h1>@switch($text->type)
                        @case('Returns')
                            Cambios y Devoluciones
                            @break

                        @case('Privacy')
                            Aviso de Privacidad
                            @break

                        @case('Terms')
                            Términos de Uso
                            @break

                        @case('Shipment')
                            Envíos y Entregas
                            @break

                        @default
                            ...
                    @endswitch
                </h1>
        </div>

    </div>

    <div class="container my-5 mt-0">
		<div class="row">
			<div class="col-md-10 ml-auto mr-auto mt-2 px-5">
				<p><small>Última actualización: {{ $text->updated_at }}</small></p>
				<hr>

				<p><em>CLIENTE:</em> CLIENTE</p>

				<br>
				<br>
                
				{!! $text->description !!}

				<br>
				<br>

				<p><small>El presente aviso de privacidad cubre los requisitos contemplados en el artículo 16 de la Ley Federal de Protección de Datos Personales en Posesión de Particulares.</small></p>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

@endpush