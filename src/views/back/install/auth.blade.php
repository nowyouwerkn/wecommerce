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
            <h4>Tu E-Commerce se configuró correctamente.</h4>
            <p>Para entrar al sistema necesitas crear una cuenta administrativa.</p>

            <form method="POST" action="{{ route('install.store') }}">
                @csrf

	            <div class="row">
	            	<div class="col-md-4">
	            		<div class="form-group">
		                    <label for="name">Nombre <span class="text-danger">*</span></label>
		                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required="" placeholder="Administración" />
		                </div>
	            	</div>
	            	<div class="col-md-8">
	            		<div class="form-group">
		                    <label for="name">Correo Electrónico <span class="text-danger">*</span></label>
		                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required="" placeholder="admin@test.com" />
		                </div>
	            	</div>
	            	<div class="col-md-6">
	            		<div class="form-group">
		                    <label for="name">Contraseña <span class="text-danger">*</span></label>
		                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required="" placeholder="*********" />
		                </div>
	            	</div>
	            	<div class="col-md-6">
	            		<div class="form-group">
		                    <label for="name">Confirmar Contraseña <span class="text-danger">*</span></label>
		                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" value="{{ old('password-confirm') }}" required="" placeholder="********" />
		                </div>
	            	</div>
	            </div>
           

	            <button type="submit" class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
	            	<span>Entrar al sistema <i data-feather="user-check" class="ml-2"></i></span>
	            	<div class="spinner-border text-light hidden" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
	            </button>
        	</form>
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

});
</script>
@endsection