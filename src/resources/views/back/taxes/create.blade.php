@extends('wecommerce::back.layouts.main')

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
                <a href="{{ route('taxes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>
            

            <h3>Impuestos Base</h3>
            <p>Usa los impuestos base si tienes una obligación fiscal en el país. Se usarán estas tasas de impuestos a menos que se especifiquen anulaciones.</p>
            
            <a href="" class="btn btn-secondary mt-3 wd-80p">Restablecer las tasas de impuestos predeterminadas</a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <form method="POST" action="{{ route('taxes.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="country_id" value="{{ $country->id }}">
                <input type="hidden" name="tax_id" value="{{ $tax->id ?? '' }}">

                <div class="card-header card-body">
                    <h6 class="text-uppercase">Impuestos Nacionales</h6>

                    <div class="d-flex">
                        <div class="input-group wd-150">
                            <input type="text" class="form-control" name="tax_rate" placeholder="0.0" value="{{ $tax->tax_rate ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <button class="btn btn-success btn-icon ml-3" type="submit"><i class="fas fa-save"></i></button>
                    </div>
                </div>
            </form>

            <div class="card-header card-body">
                <h6 class="text-uppercase">Regiones</h6>
                <p>Registra aqui cualquier impuesto adicional de acuerdo a una región dentro del país. (Estado, Comunidad, Etc.)</p>

                @if(!empty($tax->regions))
                    @foreach($tax->regions as $region)
                        <div class="d-flex align-items-center justify-content-between px-2 py-3" style="border-top: 1px solid rgba(0, 0, 0, .1);">
                            <h5 class="mb-0">
                                <i class="fas fa-map-pin"></i>
                                {{ $region->description }} 
                            </h5>
                            <div class="d-flex align-items-center">
                                <p class="mb-0">{{ $region->tax_rate }} %</p>
                            </div>
                        </div>
                    @endforeach
                @endif
                <a href="javascript:void(0)" class="btn btn-outline-secondary btn-block btn-sm mt-4" data-toggle="modal" data-target="#modalCreate">Crear nueva región</a>
            </div>
        </div>
    </div>
</div>

<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('taxes.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="country_id" value="{{ $country->id }}">
                <input type="hidden" name="parent_tax_id" value="{{ $tax->id ?? '' }}">

                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="form-group col-md-6 mt-2">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="description" name="description" />
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Impuesto</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="tax_rate" placeholder="0.0">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Esta valor sobreescribirá el valor base de los impuestos cuando, durante la compra, el usuario ponga un termino relacionado al nombre de la región (Estado, Colonia, etc)</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

@endsection