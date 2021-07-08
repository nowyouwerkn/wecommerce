@extends('back.layouts.main')

@section('stylesheets')
<style>
    @font-face {
        font-family: Reyhana;
        src: url(" {{ asset('fonts/Reyhana/Reyhana-script-webfont.woff2') }}") format("woff2"),
            url(" {{ asset('fonts/Reyhana/Reyhana-script-webfont.woff') }}") format("woff"),
            url(" {{ asset('fonts/Reyhana/Reyhana-Script.ttf') }}");
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: PTSans;
        src: url(" {{ asset('fonts/PT_Sans/PTSans-Regular.ttf') }}");
    }

    h5#title_ {
        font-family: Reyhana;
        font-size: 2.5rem;
        line-height: 0.8;
    }

    p#subtitle_ {
        font-family: PTSans;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #fff;
        letter-spacing: -1px;
        line-height: 0.95;
    }

    .btn#text_button_ {
        border-radius: 25px !important;
        font-size: 1rem;
        font-family: PTSans;
        color: #212529;
        padding: 8px 35px 8px 35px !important;
    }

    .btn-light {
        color: #212529;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    /* --- Slider card --- */
    .card-banner {
        height: 350px;
        width: 350px;
        border-radius: 25px;
        -webkit-box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        -moz-box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        text-align: center;
        color: #fff;
        padding: 2rem;
        position: relative;
        z-index: 1;

        background: #212529;
    }

    .card-banner-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
        border-radius: 24px;
        z-index: -1;
    }

    .card-banner .btn{
        color: #fff;
    }

</style>
@endsection

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Banners</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Banners</h4>
        </div>
    </div>
@endsection

@section('content')
<div class="row mb-4">
	    <div class="col-md-6 text-left">
	        <a href="{{ route('banners.index') }}" class="btn btn-info mr-2"><i class="simple-icon-arrow-left" aria-hidden="true"></i> Regresar</a>
	    </div>

	    <div class="col-md-6 text-right">
	        <a href="{{ route('banners.edit', $banner->id ) }}" class="btn btn-primary mr-2"><i class="simple-icon-pencil"></i> Editar</a>

	        <form method="POST" action="{{ route('banners.destroy', $banner->id) }}" style="display: inline-block;">
                <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-original-title="Borrar">
                    <i class="simple-icon-trash"></i> Eliminar
                </button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
	    </div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-body">
							<h4 class="mb-0">
								Información del Banner 

								@if($banner->active == true)
									<span class="badge badge-success">Activo</span>
								@else
									<span class="badge badge-danger">Desactivado</span>
								@endif
							</h4>
							<hr>
							
							<div class="row mt-5">
								
								<div class="col">
									<h5>Titulo</h5>
									<p>{{ $banner->title }}</p>

                                    <h5>Subtitle</h5>
									<p>{{ $banner->subtitle}}</p>

                                    <h5>Texto de boton</h5>
									<p>{{ $banner->text_button}}</p>

                                    <h5>Color</h5>
									<p>{{ $banner->hex}}</p>
								</div>
								<div class="col">
									<h5>Imagen</h5>
									<div class="card">
                                        <p class="badge badge-primary">Identificador de base de datos: {{ $banner->id }}</p>
                                        
                                        <div class="card-body">
                                            <img class="img-fluid mb-4" src="{{ asset('img/banners/' . $banner->image ) }}">
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Preview -->
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h4>Vista Previa</h4>
					<hr>
					<div class="d-flex">
						<div class="card-banner d-flex justify-content-center align-items-center" id="hex_" style="background: {{ $banner->hex }}">
							<div class="card-banner-content">
								<h5 id="title_">{{ $banner->title }}</h5>
								<p id="subtitle_">{{ $banner->subtitle}}</p>
								<a href="#" class="btn btn-light rounded" id="text_button_">{{ $banner->text_button }}</a>
							</div>
							<img src="{{ asset('img/banners/' . $banner->image ) }}" id="output" class="card-banner-image"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

@endsection