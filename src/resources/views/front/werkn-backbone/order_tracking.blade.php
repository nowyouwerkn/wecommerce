@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<h1>Da seguimiento a tu orden</h1>

<form action="{{ route('utilities.tracking.status') }}" method="POST">
	{{ csrf_field() }}
	<label>Numero de Orden</label>
	<input type="text" name="order_id">

	<label>Correo de Compra</label>
	<input type="email" name="email">

	<button type="submit">Buscar Orden</button>
</form>

@if(empty($order))

@else
	@include('front.theme.werkn-backbone.layouts._order_card')
@endif

@endsection

@push('scripts')

@endpush