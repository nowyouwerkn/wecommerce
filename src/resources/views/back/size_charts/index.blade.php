@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Guía de tallas</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Guía de tallas</h4>
        </div>

        <div class="d-none d-md-block">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i> Crear una nueva Guía de tallas
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

        .size-values {
            width: 100%;
            height: 100%;
        }



        .list-group-item{
            padding: .75rem 1.5rem;
        }

        .display-4{
            font-size: 2em;
        }
    </style>
@endsection

@section('content')

@if($size_chart->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_7.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay guías de talla guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar guías de talla en tu plataforma usando el botón superior.</p>
    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto"><i data-feather="plus"></i> Crear una nueva guía</a>
</div>
@else

<div class=" row">
    @foreach($size_chart as $size)
        <div class=" col-4 m-0 p-1">
            <div class="card">
                <div class="action-btns">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalEdit_{{ $size->id }}" class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-edit"></i></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalDelete_{{ $size->id }}" class="btn btn-rounded btn-icon btn-danger"><i class="fas fa-times" aria-hidden="true"></i></a></li>
                </ul>

                <!--MODAL EDIT-->
                <div id="modalEdit_{{ $size->id }}" class="modal fade">
                    <div class="modal-dialog modal-dialog-vertical-center" role="document">
                        <div class="modal-content bd-0 tx-14">
                            <div class="modal-header">
                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar Elemento</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('size_chart.update', $size->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="modal-body pd-25">
                                    <div class="form-group mt-2">
                                        <label>Nombre de Guía de Talla</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $size->name }}"/>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Imágen <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="image" name="image" />
                                    </div>

                                    <div class="form-group">
                                        <label>Asignarla a categoría <span class="text-danger">*</span></label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="0" selected="">Selecciona una opción..</option>
                                            @foreach($categories as $cat)
                                                @if($cat->parent_id == NULL || 0)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @else

                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <!--MODAL DELETE-->
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
                                <p>Al eliminar esta guía de talla <em>({{ $size->name }})</em> se eliminarán tambien cualquier valores de talla que tenga.
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

            <img class="card-img-top img-fluid" src="{{ asset('img/products/' . $size->image) }}" alt="">

            <div class="card-body pb-0">
                <h5 class="card-title display-4 mb-1">{{ $size->name }}</h5>
            </div>

            <div class="card-body">
                <p class="card-text mb-0">
                    <small class="text-muted">Creado: {{ $size->created_at }}</small>
                </p>
                <p class="card-text mb-0">
                    <small class="text-muted">Actualizado: {{ $size->updated_at }}</small>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif


<!--MODAL CREATE-->
<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('size_chart.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Nombre de Guía de Talla</label>
                        <input type="text" class="form-control" id="name" name="name" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Imágen <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>

                    <div class="form-group">
                        <label>Asignarla a categoría <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="0" selected="">Selecciona una opción..</option>
                            @foreach($categories as $cat)
                                @if($cat->parent_id == NULL || 0)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @else

                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
