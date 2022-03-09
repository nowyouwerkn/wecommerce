@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<div class="legal-area mt-5 pt-5t">
    <div class="container">
    	<div class="row special-title text-center">
            <span class="text-background">Ayuda</span>
            <h1>Preguntas Frecuentes</h1>
        </div>
    </div>

    <div class="container my-5 mt-0">
		<div class="row">
			<div class="col-md-8 ms-auto me-auto mt-5">
				<div class="card card-body bg-light py-3">
					<div class="accordion accordion-flush" id="accordionFaqs">
						@foreach($faqs as $faq)
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-{{ $faq->id }}">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ $faq->id }}-collapse" aria-expanded="false" aria-controls="flush-{{ $faq->id }}-collapse">
								{{ $faq->question }}
								</button>
							</h2>

							<div id="flush-{{ $faq->id }}-collapse" class="accordion-collapse collapse" aria-labelledby="flush-{{ $faq->id }}" data-bs-parent="#accordionFaqs">
								<div class="accordion-body">
									{!! $faq->answer !!}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

@endpush