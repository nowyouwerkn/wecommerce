@extends('wecommerce::back.layouts.main')

@section('title')
    Cupones -
@endsection

@section('content')
    <div class="col-md-12 mb-4 text-start">
        <a href="{{ route('orders.index') }}" class="btn btn-primary">Regresar</a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <!-- Data -->
                <h3>Datos generales</h3>
                <p>Codigo</p>
                <p>Descripcion</p>
                <p>Tipo</p>
                <p>Cantidad</p>
                <p>Envío gratis</p>
                <p>Mostrar en inicio</p>

                <!-- Date -->
                <h3>Fecha de actividad</h3>
                <p>Fecha inicial</p>
                <p>Fecha final</p>

                <!-- Rules -->
                <h3>Reglas</h3>
                <p>Uso individual</p>
                <p>Excluir productos con descuentos</p>
                <ul>
                    <li></li>
                </ul>
                <p>Excluir categorias</p>
                <ul>
                    <li></li>
                </ul>
                <p>Excluir productos</p>
                <ul>
                    <li></li>
                </ul>

                <!-- Limit -->
                <h3>Limites</h3>
            </div>
        </div>
    </div>
@endsection