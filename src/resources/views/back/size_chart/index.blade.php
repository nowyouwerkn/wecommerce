@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Guia de tallas</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Guia de tallas</h4>
        </div>
        <div class="d-none d-md-block">

           <a href="{{ route('size_chart.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i>  Agregar Nueva Guia de talla
            </a>
        </div>
    </div>

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
@endsection

@section('content')

@if($size_chart->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay Guias de talla guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar guias de tallas en tu plataforma usando el botón superior.</p>
    <a href="{{ route('size_chart.create') }}"  class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Agregar Nueva Guia de talla</a>
</div>
@else
<div class="card-columns">
    @foreach($size_chart as $size)
        <div class="card">
            <div class="action-btns">
                <ul class="list-inline">
                     <li class="list-inline-item"><a href="{{ route('size_chart.edit', $size->id) }}"  data-toggle="tooltip" data-original-title="Editar"class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-edit"></i></a></li>
                    <li class="list-inline-item"><a href="{{ route('size_chart.show', $size->id) }}"  data-toggle="tooltip" data-original-title="Detalle"class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-eye"></i></a></li>

                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalDelete_{{ $size->id }}" class="btn btn-rounded btn-icon btn-danger"><i class="fas fa-times" aria-hidden="true"></i></a></li>                  
                </ul>


                <div id="modalDelete_{{ $size->id }}" class="modal fade">
                    <div class="modal-dialog modal-dialog-vertical-center" role="document">
                        <div class="modal-content bd-0 tx-14">
                            <div class="modal-header">
                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Aviso</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body pd-25">
                                <h4 class="text-warning">¡Atención!</h4>
                                <p>Al eliminar esta guia de talla <em>({{ $size->name }})</em> se eliminarán tambien cualquier valores de talla que tenga.

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Regresar</button>
                                <form method="POST" action="{{ route('size_chart.destroy', $size->id) }}" style="display: inline-block;">
                                    <button type="submit" class="btn btn-danger">
                                        Eliminar <i class="fas fa-times" aria-hidden="true"></i>
                                    </button>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>

                            </div>
                        </div>
                    </div><!-- modal-dialog -->
                </div><!-- modal -->
            </div>


            <img class="card-img-top img-fluid" src="{{ asset('img/categories/no_category.jpg') }}" alt="Imagen para {{ $size->name }} no disponible">

            <div class="card-body pb-0">
                <h5 class="card-title display-4 mb-1">{{ $size->name }}</h5> 
                @if($size->size_guide != NULL || 0)
                <p class="card-text">Tallas en esta guia: <span class="badge badge-info">{{ $size->size_guide->count() }}</span></p>
                @endif
            </div>

            <div class="card-body">
                @if($size->size_guide != NULL || 0)
                @foreach($size->size_guide as $size_guide)
                <p class="card-text">{{ $size_guide->size_value }}</p>
                @endforeach
                @endif
                <p class="card-text mb-0">
                    <small class="text-muted">Creado: {{ $size->created_at }}</small>
                </p>
                <p class="card-text mb-0">
                    <small class="text-muted">Actualizado: {{ $size->updated_at }}</small>
                </p>
            </div>
        </div>    
    @endforeach
</div>
@endif


@endsection