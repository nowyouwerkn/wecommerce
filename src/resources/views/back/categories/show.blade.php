@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Colecciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Colecciones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Colecciones</h4>
        </div>

        <div class="d-none d-md-block">
            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" style="display: inline-block;">
                <button type="submit" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5" data-toggle="tooltip" data-original-title="Borrar">
                    <i class="fas fa-trash mr-1"></i> Borrar
                </button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <a href="{{ route('categories.index') }}" data-toggle="modal" data-target="#editModal_{{ $category->id }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-edit mr-1"></i> Editar
            </a>

            <a href="{{ route('categories.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>
@endsection

@section('content')
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

<div class="row">
    <div class="col-md-4">
        <div class="card">
            @if($category->image == NULL)
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/no_category.jpg') }}" alt="Imagen para {{ $category->name }} no disponible">
            @else
            <img class="card-img-top img-fluid" src="{{ asset('img/categories/' . $category->image) }}" alt="{{ $category->name }}">
            @endif

            <div class="card-body pb-0">
                <h5 class="card-title display-4 mb-1">{{ $category->name }}</h5> 

                <p class="card-text">Productos en esta categoría: <span class="badge badge-info">{{ $products->count() }}</span></p>

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
                            <button type="submit" class="btn btn-rounded btn-icon btn-sm btn-danger" data-toggle="tooltip" data-original-title="Delete">
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
                                                <label>Nombre de Elemento</label>
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
    </div>

    <div class="col-md-8">
        <div class="card">
            <!-- Header -->
            <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                <h5 class="mg-b-5">Productos en esta colección</h5>
                <p class="tx-12 tx-color-03 mg-b-0">Estos son todos los productos que haz asociado a esta colección.</p>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>SKU / UPC</th>
                                <th>Precio</th>
                                <th>Precio Descuento</th>
                                <!--<th>Existencias</th>-->
                                <th>Caracteristicas</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->products as $product)
                            <tr>
                                <td style="width: 150px; position: relative;">
                                    <img style="width: 100%;" src="{{ asset('img/products/' . $product->image ) }}" alt="{{ $product->name }}">
                                    <div class="text-center margin-top-10">
                                        <small><p>+ {{ $product->images->count() }} Imágen(es)</p></small>    
                                    </div>
                                </td>
                                <td style="width: 250px;">
                                    <strong><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></strong> <br><p style="width: 200px;" class="mb-1">{{ substr($product->description, 0, 100)}} {{ strlen($product->description) > 100 ? "[...]" : "" }}</p>

                                    <small class="badge badge-info mb-3" style="white-space: unset;">{{ $product->search_tags }}</small>
                                </td>
                                <td style="width: 100px;">
                                    {{ $product->sku }}
                                    <small><em>{{ $product->barcode }}</em></small>
                                </td>
                                <td>$ {{ number_format($product->price,2) }}</td>
                                <td>
                                    $ {{ number_format($product->discount_price,2) }}
                                </td>
                                <!--
                                <td class="sizes-td">
                                    
                                </td>
                                -->
                                <td>
                                    <ul class="list-unstyled mb-0">

                                        <li>
                                            @if($product->in_index == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Mostrar en Inicio
                                        </li>
                                        <li>
                                            @if($product->is_favorite == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Favorito
                                        </li>
                                        <li>
                                            @if($product->has_discount == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Descuento Activo
                                        </li>
                                        <li>
                                            @if($product->has_tax == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Tiene impuestos
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    @if($product->status == 'Publicado')
                                        <span class="status-circle bg-success"></span> Publicado
                                    @else
                                        <span class="status-circle bg-danger"></span> Borrador
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    {{-- 
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    --}}

                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Editar">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>

                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" data-toggle="tooltip" data-original-title="Borrar">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection