@extends('back.layouts.main')

@section('title')
    Orden -
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4 text-start">
            <a href="{{ route('reviews.index') }}" class="btn btn-primary">Regresar</a>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <!-- Data -->
                    <h3>Datos generales</h3>
                    <p>Usuario</p>
                    <p>Producto</p>
                    <p>Reseña</p>
                </div>
            </div>
        </div>
    </div>
@endsection