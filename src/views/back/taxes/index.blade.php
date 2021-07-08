@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Impuestos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Impuestos</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>

    <style type="text/css">
    .badge{
        padding: 9px 15px;
        border-radius: 20px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-1 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Regiones Fiscales</h3>
            <p>Gestiona el modo en el que tu tienda cobra los impuestos a las ventas en tu perfiles de envío. Consulta con un experto tributario para entender tus obligaciones.</p>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            @foreach($countries as $country)
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fas fa-globe"></i> {{ $country->name }}</h4>
                    <div class="d-flex align-items-center">
                        @if(!empty($country->taxes))
                            <span class="badge badge-success">Activado</span>
                            @php
                                $tax = App\Models\StoreTax::where('country_id', $country->id)->where('parent_tax_id', NULL)->first();
                            @endphp

                            @if(!empty($tax))
                            <a href="{{ route('taxes.show', $tax->id) }}" class="btn btn-outline-secondary btn-sm ml-3">Gestionar</a>     
                            @endif
                        
                        @else
                            <span class="badge badge-primary">Sin Configurar</span>
                            <a href="{{ route('taxes.create', $country->id) }}" class="btn btn-outline-secondary btn-sm ml-3">Configurar</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <div class="card-footer bg-gray-100 pt-4 pb-4">
                <p class="mb-0">Estas regiones provienen de tus perfiles de envío. Para agregar una región, edita tu configuración de envíos.</p>
            </div>
        </div>
    </div>
</div>
@endsection