@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Colecciones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Colecciones</h4>
        </div>
        @if(auth()->user()->can('admin_access'))
        <div class="d-none d-md-block">
            <a href="{{ route('categories.create') }}" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i>  Agregar Nueva Categoría
            </a>
        </div>
        @endif
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

@if($categories->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay Categorías guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar categorías en tu plataforma usando el botón superior.</p>
    <a href="{{ route('categories.create') }}" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Agregar Nueva Categoría</a>
</div>
@else
<div class="card-columns">
    @foreach($categories as $category)
        <div class="card">
            <div class="action-btns">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#editModal_{{ $category->id }}" class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-edit"></i></a></li>
                    <li class="list-inline-item"><a href="{{ route('categories.show', $category->id) }}"  data-toggle="tooltip" data-original-title="Detalle"class="btn btn-rounded btn-icon btn-dark"><i class="fas fa-eye"></i></a></li>

                    <li class="list-inline-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalDelete_{{ $category->id }}" class="btn btn-rounded btn-icon btn-danger"><i class="fas fa-times" aria-hidden="true"></i></a></li>                  
                </ul>

                <div class="modal fade" id="editModal_{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nombre del Elemento</label>
                                                <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                            </div>

                                            <div class="form-group mt-2">
                                                <label>Imágen <span class="text-info">(Opcional)</span></label>
                                                <input type="file" class="form-control" id="image" name="image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modalDelete_{{ $category->id }}" class="modal fade">
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
                                <p>Al eliminar esta colección <em>({{ $category->name }})</em> se eliminarán tambien cualquier subcategoría que tenga. Los productos relacionados serán cambiados a "Borrador" y perderán su categorización (<strong>NO</strong> elimina productos). Esta acción es irreversible.</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Regresar</button>
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}" style="display: inline-block;">
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

            @if($category->image == NULL)
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/no_category.jpg') }}" alt="Imagen para {{ $category->name }} no disponible">
            @else
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/' . $category->image) }}" alt="{{ $category->name }}">
            @endif

            <div class="card-body pb-0">
                <h5 class="card-title display-4 mb-1">{{ $category->name }}</h5> 

                <p class="card-text">Productos en esta categoría: <span class="badge badge-info">{{ $category->products->count() }}</span></p>

                <h5 class="card-title mt-3 mb-2">Sub-Categorías</h5>              
            </div>

            <ul class="mt-0 list-group list-group-flush">
                @foreach($category->children as $sub)
                <li class="d-flex align-items-center justify-content-between list-group-item">
                    <div>
                        <a href="#">{{ $sub->name }} 
                            <span class="badge badge-info">{{ $sub->products->count() }}</span>
                        </a>
                    </div>
                    <div style="transform: scale(.8);">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#editModalSub_{{ $sub->id }}" class="btn btn-rounded btn-icon btn-sm btn-dark"><i class="fas fa-edit"></i></a>

                        <form method="POST" action="{{ route('categories.destroy', $sub->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-rounded btn-icon btn-sm btn-danger" data-toggle="tooltip" data-original-title="Eliminar">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </li>
                <div class="modal fade" id="editModalSub_{{ $sub->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('categories.update', $sub->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <input type="hidden" name="parent_id" value="{{ $sub->parent_id }}">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name of Element</label>
                                                <input type="text" class="form-control" name="name" value="{{ $sub->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </ul>

            <div class="card-body">
                <p class="card-text mb-0">
                    <small class="text-muted">Creado: {{ $category->created_at }}</small>
                </p>
                <p class="card-text mb-0">
                    <small class="text-muted">Actualizado: {{ $category->updated_at }}</small>
                </p>
            </div>
        </div>    
    @endforeach
</div>

<div class="row justify-items-center">
    <div class="col text-center">
        {{ $categories->links() }}
    </div>
</div>
@endif

<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Nombre de Categoría o Sub-categoría</label>
                        <input type="text" class="form-control" id="name" name="name" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Imágen <span class="text-info">(Opcional)</span></label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>

                    <div class="form-group">
                        <label>Vincular con otra categoría <span class="text-info">(Opcional)</span></label>
                        <select class="form-control" id="parent_id" name="parent_id">
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