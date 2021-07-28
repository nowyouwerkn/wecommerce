@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
    <!-- Error -->

    <!-- Profile -->
    <section>
        <div class="container catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Tus direcciones</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row align-items-center">
				    		<div class="col">
				    			<h3>Editar Dirección</h3>
				    		</div>
				    		<div class="col">
				    			<a href="{{ route('address') }}" class="btn btn-grey float-right"><i class="fa fa-chevron-left"></i> Regresar</a>
				    		</div>
				    	</div>
						<hr>
						
				      	<form role="form" id="formAddress" method="POST" action="{{ route('address.update', $address->id) }}">
				      		{{ csrf_field() }}
				      		{{ method_field('PUT') }}
				      		<div class="row">
				      			<div class="col-md-12">
				      				<div class="form-group">
										<label for="name">Nombre para tu Dirección <span style="color: red;">*</span></label>
										<input type="text" name="name" class="form-control" required="" value="{{ $address->name }}">
									</div>
				      			</div>
				      			<div class="col-md-8">
				      				<div class="form-group">
										<label for="street">Calle <span style="color: red;">*</span></label>
										<input type="text" name="street" class="form-control" required="" value="{{ $address->street }}">
									</div>
				      			</div>
				      			<div class="col-md-4">
				      				<div class="form-group">
										<label for="street_num">Número <span style="color: red;">*</span></label>
										<input type="text" name="street_num" class="form-control" required="" value="{{ $address->street_num }}">
									</div>
				      			</div>

				      			<div class="col-md-12">
				      				<div class="form-group">
										<label for="suburb">Colonia / Delegación <span style="color: red;">*</span></label>
										<input type="text" name="suburb" class="form-control" required="" value="{{ $address->suburb }}">
									</div>
				      			</div>

				      			<div class="col-md-12">
				      				<div class="form-group">
										<label for="references">Referencias <span style="color: red;">*</span></label>
										<textarea name="references" class="form-control" required="" rows="4">{{ $address->references }}</textarea>
									</div>
				      			</div>

				      			<div class="col-md-12">
				      				<div class="form-group">
										<label for="between_streets">Entre Calles <span style="color: red;">*</span></label>
										<input type="text" name="between_streets" class="form-control" required="" value="{{ $address->between_streets }}">
									</div>
				      			</div>

				      			<div class="col-md-4">
				      				<div class="form-group">
										<label for="postal_code">Código Postal <span style="color: red;">*</span></label>
										<input type="text" name="postal_code" class="form-control" required="" value="{{ $address->postal_code }}">
									</div>
				      			</div>

				      			<div class="col-md-4">
				      				<div class="form-group">
										<label for="city">Ciudad <span style="color: red;">*</span></label>
										<input type="text" name="city" class="form-control" required="" value="{{ $address->city }}">
									</div>
				      			</div>
				      			<div class="col-md-4">
				      				<div class="form-group">
										<label for="state">Estado <span style="color: red;">*</span></label>
										@php
											$states = Nowyouwerkn\WeCommerce\Models\State::all();
										@endphp
										<select class="form-control" id="state" name="state" required="">
				            				@foreach($states as $state)
			                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
			                                @endforeach
				            			</select>
									</div>
				      			</div>

				      			<div class="col-md-6">
				      				<div class="form-group">
										<label for="country">País <span style="color: red;">*</span></label>
										<input type="text" name="country" class="form-control" required="" value="{{ $address->country }}">
									</div>
				      			</div>

				      			<div class="col-md-6">
				      				<div class="form-group">
										<label for="phone">Teléfono <span style="color: red;">*</span></label>
										<input type="text" name="phone" class="form-control" required="" value="{{ $address->phone }}">
									</div>
				      			</div>
				      		</div>

		      				<input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}" required="" readonly="">

		      				<button type="submit" form="formAddress" class="btn btn-auth">Guardar Dirección</button>
		      				<a href="{{ route('address') }}" class="btn btn-link btn-sm">Cancelar</a>
				      	</form>
                </div>
            </div>
        </div>
    </section>
@endsection