@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Textos Legales</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Textos Legales</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-1 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Páginas legales</h3>
            <p>Puedes crear tus propias páginas legales.</p>
            <p>Tus políticas guardadas se vincularán en el pie de página de tu pantalla de pago y los menús de tu tienda.</p>
            <!--<p>Al usar estas plantillas, aceptas que has leído y aceptado el descargo de responsabilidad.</p>-->
        </div>
        
    </div>
    <div class="col-md-8">
        @if($legals->count() == 0)
        <div class="card card-body text-center" style="padding:50px 0px 50px 0px;">
            <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
            <h4>¡No hay textos legales guardadas en la base de datos!</h4>
            <a href="" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto mt-4">Reparar</a>
        </div>
        @else
            @foreach($legals as $legal)
            <form method="POST" action="{{ route('legals.update', $legal->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>
                            @switch($legal->type)
                                @case('Returns')
                                    Política de Devoluciones
                                    @break

                                @case('Privacy')
                                    Política de Privacidad
                                    @break

                                @case('Terms')
                                    Términos y Condiciones
                                    @break

                                @case('Shipment')
                                    Política de Envíos
                                    @break

                                @default
                                    Hubo un problema, intenta después.
                            @endswitch
                        </h4>

                        <div class="form-group">
                            <input type="hidden" name="type" value="{{ $legal->type }}">
                            <textarea name="description" id="" class="form-control" cols="30" rows="10">{!! $legal->description ?? '' !!}</textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-success"><i class="far fa-save"></i> Guardar información</a>
                    </div>
                </div>
            </form>
            @endforeach
        @endif
    </div>
</div>
@endsection