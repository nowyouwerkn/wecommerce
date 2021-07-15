@extends('wecommerce::back.layouts.main')

@section('title')
    Texto Legal -
@endsection

@section('content')
    <div class="col-md-12 mb-4 text-start">
        <a href="{{ route('seos.index') }}" class="btn btn-primary">Regresar</a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <!-- Data -->
                <h3>Datos generales</h3>
                <p>Titulo</p>
                <p>Descripción</p>
            </div>
        </div>
    </div>
@endsection