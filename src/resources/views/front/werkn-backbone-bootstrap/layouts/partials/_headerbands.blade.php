@php
  $headerbands = Nowyouwerkn\WeCommerce\Models\Headerband::where('is_active', true)->orderBy('priority', 'asc')->get();
@endphp

@if(!empty($headerbands))
	@foreach($headerbands as $hb)
	<style type="text/css">
		.wk-headerband-{{ Str::slug($hb->title) }}{
			background-color: {{ $hb->hex_background  }} !important;
			color: {{ $hb->hex_text  }} !important;
		}	
	</style>

	<div class="wk-headerband wk-headerband-{{ Str::slug($hb->title) }}">
		<div class="container">
			<div class="row">
				<div class=" d-flex align-items-center justify-content-center">
					<h6 class="mb-0 me-3">{{ $hb->title }}</h6>
					{!! $hb->text  !!}
				</div>
			</div>
		</div>
	</div>
	@endforeach
@endif