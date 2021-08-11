@php
    $theme = Nowyouwerkn\WeCommerce\Models\StoreTheme::where('is_active', 1)->first();
@endphp

@extends('front.theme.' . $theme->name . '.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    .error-text{
        padding-top: 100px;
        padding-bottom: 100px;
        padding-left: 10%;
        padding-right: 10%;
    }

    .error-subtitle{
    	margin-bottom: -20px;
		font-size: 1.5em;
    }

    .error-title{
    	font-size: 10em !important;
    }

    .error-special{
		color: #c1a28b;
		font-weight: bold;
		position: relative;
		z-index: 2;
		margin-top: -65px;
		font-size: 5em;
		margin-left: 150px;
    }

    .error-p{
    	font-size: 1.5em;
    	line-height: 1.5;
    	padding-right: 10%;
    }

    .error-text a{
    	color: #c1a28b;
    	display: flex;
    	-webkit-box-align: center !important;
		-ms-flex-align: center !important;
		align-items: center !important;
		margin-right: 15px;
    }

    .error-text ion-icon{
    	margin-right: 5px;
    }

    .error-text:hover{
    	text-decoration: none;
    }

    .btn-error{
    	background-color: #212a3b;
    	color: #fff !important;
    	padding: 6px 30px;
    	border-radius: 18px;
    }
</style>
@endpush

@section('content')

<!-- Information -->
<div class="container error-text">
    <div class="row align-items-center">
    	<div class="col-md-4">
    		<div>
    			<img class="img-fluid" src="{{ asset('img/errors/401.svg') }}">
    		</div>
    	</div>
		<div class="col-md-8">
    		<div class="p-5">
    			<h6 class="error-subtitle">¡Oh no!</h6>
    			<h1 class="error-title">401</h1>
    			<h3 class="error-special">error</h3>
    			<p class="error-p">No estas autorizado para realizar esta acción. Te dejamos unos links que podrían ser útiles.</p>
    			<div class="d-flex align-items-center mt-4">
    				<a href="{{ route('index') }}" class="btn btn-error"><ion-icon name="home-outline"></ion-icon> Regresa al Inicio</a> 
    			</div>
    		</div>
    	</div>
    </div>
</div>

@endsection

@push('scripts')

@endpush