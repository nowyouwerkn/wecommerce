@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Variantes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Variantes</h4>
        </div>
        <div class="d-none d-md-block">
            <a data-toggle="modal" data-target="#modalCreate" href="javascript:void(0)" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i> Agregar Variante
            </a>
        </div>
    </div>
@endsection

@push('stylesheets')
<style type="text/css">
    .action-btns{
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
    }

    .action-btns .btn-rounded{
        padding: 0px;
        height: 20px;
        width: 20px;
        text-align: center;
        line-height: 19px;
        font-size: .8em;
        border-radius: 15px;
    }



    .list-group-item{
        padding: .75rem 1.5rem;
    }
</style>
@endpush

@section('content')
@if($variants->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay variantes guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar categorías en tu plataforma usando el botón superior.</p>
    <a href="{{ route('variants.create') }}" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Agregar Nueva Variante</a>
</div>
@else
<div class="row">
    @foreach($variants as $variant)
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="action-btns">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#editModal_{{ $variant->id }}" class="btn btn-rounded btn-icon btn-dark waves-effect waves-light"><i class="fa fa-wrench"></i></a></li>
                    <li class="list-inline-item"><a  data-toggle="tooltip" title="" data-original-title="Detalle" href="{{ route('variants.show', $variant->id) }}" class="btn btn-rounded btn-icon btn-dark waves-effect waves-light"><i class="fa fa-eye"></i></a></li>

                    @if($variant->products->count() === 0)
                    <li class="list-inline-item">
                        <form method="POST" action="{{ route('variants.destroy', $variant->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-rounded btn-icon btn-danger waves-effect waves-light" data-toggle="tooltip" data-original-title="Borrar">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </li>
                    @endif
                </ul>

                <div class="modal fade" id="editModal_{{ $variant->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('variants.update', $variant->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nombre de Variante</label>
                                                <input type="text" class="form-control" name="value" value="{{ $variant->value }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title display-4 mb-1">{{ $variant->value }}</h5>
                <p>Productos con esta variante: {{ $variant->products->count() }}</p>
                <p class="card-text mb-0 mt-3">
                    <small class="text-muted">Actualizado por última vez: <br>{{ Carbon\Carbon::parse($variant->updated_at)->translatedFormat('d M Y - h:ia') }}</small>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear Nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('variants.store') }}">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">

                        <div class="form-group col-12">
                            <label class="form-control-label" for="type">Tipo de Variante <span class="tx-danger">*</span></label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="Talla">Talla</option>
                                <option value="Color">Color</option>
                                <option value="Material">Material</option>
                                <option value="Estilo">Estilo</option>
                                <option value="Nombre">Nombre</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-control-label" for="value">Nombre de Variante <span class="tx-danger">*</span></label>
                            <input type="text" class="form-control" name="value" value="" required autofocus>
                        </div>

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

@push('scripts')
<script>
    $(".delete").on("submit", function(){
        return confirm("¿Estas seguro de querer eliminar este registro?");
    });

    $(function(){
        'use strict';

        // Initialize tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // colored tooltip
        $('[data-toggle="tooltip-primary"]').tooltip({
          template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-info"]').tooltip({
          template: '<div class="tooltip tooltip-info" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        $('[data-toggle="tooltip-danger"]').tooltip({
          template: '<div class="tooltip tooltip-danger" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });
    });
</script>
@endpush
