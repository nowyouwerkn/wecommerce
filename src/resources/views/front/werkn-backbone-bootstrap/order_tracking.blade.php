@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')

<div class="container">
	<h1>Da seguimiento a tu orden</h1>

	<form action="{{ route('utilities.tracking.status') }}" class="row" method="POST">
		{{ csrf_field() }}
		<div class="col-6 mt-4">
			<label>Numero de Orden</label>
			<input type="text" name="order_id" class="form-control" required="">
		</div>

		<div class="col-6 mt-4">
			<label>Correo de Compra</label>
			<input type="email" name="email" class="form-control" required="">
		</div>
		<div class="col-12 mt-5">
			<button type="submit" class="btn btn-primary">Buscar Orden</button>
		</div>		
	</form>
</div>

<div class="container">
	<div class="row">
		@if(empty($order))

		@else
		<div class="col-md-6 offset-md-3 mt-5">
			@include('front.theme.werkn-backbone-bootstrap.layouts.utilities._order_card')
		</div>
		@endif
	</div>
</div>
@endsection

@push('scripts')

@endpush