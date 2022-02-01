@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush
@section('content')
    <!-- Profile -->
    <section>
        <div class="container catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Tus foto de Perfil</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <section class="col-md-8">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3>Cambiar tu imagen de perfil</h3>
                                </div>
                                <div class="col">
                                    <a href="{{ route('profile') }}" class="btn btn-info float-right"><i class="fa fa-chevron-left"></i> Regresar</a>
                                </div>
                            </div>
                            
                            <hr>

                            <form role="form" method="POST" action="{{ route('profile.image.update', $user->id) }}" enctype="multipart/form-data">
					      		{{ csrf_field() }}
					      		{{ method_field('PUT') }}
					      		<div class="row">
					      			<div class="col-md-6">
					      				<h6>Imagen Actual</h6>
					      				<hr>

					      				@if( Auth::user()->image == NULL)
											<img class="card-img-top" src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( Auth::user()->email))) . '?d=retro&s=300' }}" alt="{{ Auth::user()->name }}" style="width: 100%;">
										@else
											<img class="card-img-top" src="{{ asset('img/users/' . Auth::user()->image ) }}" alt="{{ Auth::user()->name }}">
										@endif
					      			</div>
					      			<div class="col-md-6">
					      				<h6>Subir Nueva Imagen</h6>
					      				<hr>

					      				<input class="form-control-file" id="user_image" name="user_image" aria-describedby="fileHelp" type="file">
				      					<small id="fileHelp" class="form-text text-muted">Esta es la imagen que te define. Que sea algo cool.</small>
					      			</div>
					      		</div>

					      		<hr>

					      		<div class="row">
					      			<div class="col-md-12">
					      				<button type="submit" class="btn btn-primary float-right">Subir Imagen</button>
					      				<a href="{{ route('profile') }}" class="btn btn-link btn-sm float-right">Cancelar</a>
					      			</div>
					      		</div>
					      	</form>
                        </section>          
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection