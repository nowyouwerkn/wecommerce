@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
<div class="legal-area mt-5 pt-5t">
    <div class="container">
        <div class="row special-title text-center">
            <span class="text-background">Información Legal</span>
            <h1>{{ $text->title }}</h1>
        </div>
    </div>

    <div class="container my-5 mt-0">
        <div class="row">
            <div class="col-md-10 ms-auto me-auto mt-5 px-5">
                <p><small>Última actualización: {{ $text->updated_at }}</small></p>
                <hr>

                <p><em>CLIENTE:</em> BRIMONT MÉXICO S.A de C.V</p>

                <br>
                
                {!! $text->description ?? '' !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush