@extends('back.layouts.main')

@section('title')
    Categorias -
@endsection

@section('content')
    <div class="col-md-12 mb-4 text-start">
        <a href="{{ route('categories.index') }}" class="btn btn-primary">Regresar</a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <!-- Data -->
                <h3>Datos generales</h3>
                <p>Nombre</p>
                <p>Imagen</p>
                <img src="#" alt="">
                <p>Categoria padre</p>
            </div>
        </div>
    </div>
@endsection