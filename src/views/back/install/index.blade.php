@extends('wecommerce::back.layouts.config')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Werkn-Commerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Instalador</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1"><i class="fas fa-cogs"></i> Instalador Automático</h4>
        </div>
    </div>

    <style>
        .decorative-image{
            position: fixed;
            top: 0px;
            right: 0px;
            height: 100vh;
            min-width: 40%;
            overflow:hidden;
            z-index: -10;
        }

        .decorative-image img{
            position: absolute;
            top:50%;
            left:50%;
            height: 100%;
            width: auto;

            transform: translate(-50%,-50%);
        }

        .spinner-border{
        	width: 1em;
        	height: 1em;
        }

        .hidden{
        	display: none;
        }
    </style>
@endsection

@section('content')

<div class="row row-xs">
    <div class="col-md-6">
        <div class="card card-body mb-2">
            <h4>Bienvenido a tu Plataforma de E-Commerce</h4>
            <p>Antes de comenzar necesitamos instalar unas cosas en tu servidor. Porfavor, ingresa la información de tu base de datos.</p>

            <div class="row">
            	<div class="col-md-8">
            		<div class="form-group">
	                    <label for="name">Nombre de tu Base de datos <span class="text-danger">*</span></label>
	                    <input type="text" class="form-control" id="db_database" name="db_database" value="{{ old('db_database') }}" required="" placeholder="werkndb" />
	                </div>
            	</div>
            	<div class="col-md-4">
            		<div class="form-group">
	                    <label for="name">Puerto <span class="text-danger">*</span></label>
	                    <input type="text" class="form-control" id="db_port" name="db_port" value="{{ old('db_port') }}" required="" placeholder="8889" />
	                </div>
            	</div>

            	<div class="col-md-6">
            		<div class="form-group">
	                    <label for="name">Usuario <span class="text-danger">*</span></label>
	                    <input type="text" class="form-control" id="db_username" name="db_username" value="{{ old('db_username') }}" required="" placeholder="root" />
	                </div>
            	</div>
            	<div class="col-md-6">
            		<div class="form-group">
	                    <label for="name">Contraseña <span class="text-info">(Opcional)</span></label>
	                    <input type="text" class="form-control" id="db_password" name="db_password" value="{{ old('db_password') }}" required="" placeholder="root" />
	                </div>
            	</div>
            </div>

            <a id="startInstall" class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            	<span>Comenzar Instalación</span>
            	<div class="spinner-border text-light hidden" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
            </a>

			<div class="collapse mg-t-5" id="collapseExample">
				<!--
				<div class="progress ht-20 mt-2">
				  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success wd-25p" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
				</div>
				-->

			  	<div class="list-group mt-3">
					<div class="list-group-item d-flex justify-content-between align-items-center">
						<span class="message">Creando Llave de Encriptación</span>
						<i class="far fa-check-circle hidden"></i>

						<div class="spinner-border text-dark" role="status">
							<span class="sr-only">Loading...</span>
						</div>

					</div>

					<div class="list-group-item d-flex justify-content-between align-items-center">
						Implementar Plantillas y Vistas
						<i class="far fa-check-circle hidden"></i>

					  	<div class="spinner-border text-dark" role="status">
						  <span class="sr-only">Loading...</span>
						</div>

					</div>
					<div class="list-group-item d-flex justify-content-between align-items-center">
						Creando Bases de Datos
						<i class="far fa-check-circle hidden"></i>

					  	<div class="spinner-border text-dark" role="status">
						  <span class="sr-only">Loading...</span>
						</div>

					</div>
					<div class="list-group-item d-flex justify-content-between align-items-center">
						Colocando Información Predeterminada
						<i class="far fa-check-circle hidden"></i>

					  	<div class="spinner-border text-dark" role="status">
						  <span class="sr-only">Loading...</span>
						</div>

					</div>

					<div class="list-group-item d-flex justify-content-between align-items-center">
						Limpiando el desorden
						<i class="far fa-check-circle hidden"></i>

					  	<div class="spinner-border text-dark" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="decorative-image">
            <img src="https://source.unsplash.com/920x1280/?nature,water,forest" alt="">
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function vistas() {
	$.ajax({
    	method: 'POST',
        url: "{{ route('install.views') }}",
        data:{
            db_port: $('#db_port').val(),
            db_database : $('#db_database').val(),
            db_username: $('#db_username').val(),
            db_password:$('#db_password').val(),
        },
        success: function(msg){
            console.log(msg['mensaje']);

            $('.list-group .list-group-item:nth-child(2)').addClass('active');

            $('.list-group .list-group-item:nth-child(2) .message').text(msg['mensaje']);

    		$('.list-group .list-group-item:nth-child(2) .spinner-border').addClass('hidden');
    		$('.list-group .list-group-item:nth-child(2) .fa-check-circle').removeClass('hidden');

            setTimeout(function() {
                migraciones();
            }, 1500);

    		
        },
        error: function(msg){
            console.log(msg);
            //$('.loader-standby').addClass('hidden');         
        }
    });
}

function migraciones() {

	$.ajax({
    	method: 'POST',
        url: "{{ route('install.migrations') }}",
        data:{
        	
        },
        success: function(msg){
            console.log(msg['mensaje']);

            $('.list-group .list-group-item:nth-child(3)').addClass('active');

            $('.list-group .list-group-item:nth-child(3) .message').text(msg['mensaje']);

    		$('.list-group .list-group-item:nth-child(3) .spinner-border').addClass('hidden');
    		$('.list-group .list-group-item:nth-child(3) .fa-check-circle').removeClass('hidden');

            setTimeout(function() {
                seeders();
            }, 1500);
        },
        error: function(msg){
            console.log(msg);
            //$('.loader-standby').addClass('hidden');         
        }
    });
}

function seeders() {
	$.ajax({
    	method: 'POST',
        url: "{{ route('install.seeders') }}",
        data:{

        },
        success: function(msg){
            console.log(msg['mensaje']);

            $('.list-group .list-group-item:nth-child(4)').addClass('active');

            $('.list-group .list-group-item:nth-child(4) .message').text(msg['mensaje']);

    		$('.list-group .list-group-item:nth-child(4) .spinner-border').addClass('hidden');
    		$('.list-group .list-group-item:nth-child(4) .fa-check-circle').removeClass('hidden');

    		setTimeout(function() {
		        $('.list-group .list-group-item:nth-child(5)').addClass('active');
		        $('.list-group .list-group-item:nth-child(5) .spinner-border').addClass('hidden');
		    	$('.list-group .list-group-item:nth-child(5) .fa-check-circle').removeClass('hidden');

		    	$('body').fadeOut();
		    	window.location.replace("{{ route('install.auth') }}");
		    }, 4000);

        },
        error: function(msg){
            console.log(msg);   
        }
    });
}

$('#startInstall').on('click', function(){
    event.preventDefault();

    $('#startInstall .spinner-border').removeClass('hidden');
    $('#startInstall span').addClass('hidden');
    $('#startInstall').fadeOut();

    setTimeout(function() {
    	$('.list-group .list-group-item:nth-child(1)').addClass('active');
    	$('.list-group .list-group-item:nth-child(1) .spinner-border').addClass('hidden');
    	$('.list-group .list-group-item:nth-child(1) .fa-check-circle').removeClass('hidden');

    	vistas();
	}, 2000);

    {{-- 
    // Comenzar Proceso Ajax
    /*
    $.ajax({
    	method: 'POST',
        url: "{{ route('install.key') }}",
        data:{
            
        },
        success: function(msg){
            console.log(msg['mensaje']);

            $('.list-group .list-group-item:nth-child(1)').addClass('active');

            $('.list-group .list-group-item:nth-child(1) .message').text(msg['mensaje']);

    		$('.list-group .list-group-item:nth-child(1) .spinner-border').addClass('hidden');
    		$('.list-group .list-group-item:nth-child(1) .fa-check-circle').removeClass('hidden');

    		vistas();
        },
        error: function(msg){
            console.log(msg);         
        }
    });
    */
	--}}
});
</script>
@endsection