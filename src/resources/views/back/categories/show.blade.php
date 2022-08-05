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
                                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png" />
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
                @if($category->parent_id == NULL || 0)
                <p class="card-text">Productos en esta categoría: <span class="badge badge-info">{{ $category->products->count() }}</span></p>
                @endif
                @if($category->parent_id != NULL || 0)
                <p class="card-text">Productos en esta categoría: <span class="badge badge-info">{{ $products->count() }}</span></p>
                @endif
            </div>

            <div class="card-body">
                <p class="card-text mb-0">
                    <small class="text-muted">Creado: {{ Carbon\Carbon::parse($category->created_at)->translatedFormat('d M Y - h:ia') }}</small>
                </p>
                <p class="card-text mb-0">
                    <small class="text-muted">Actualizado: {{ Carbon\Carbon::parse($category->updated_at)->translatedFormat('d M Y - h:ia') }}</small>
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
                                <th>Características</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($category->parent_id == NULL || 0)
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
                            @endif

                        @if($category->parent_id != NULL || 0)
                            @foreach($products as $product)
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
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                @php

                $notifications = Nowyouwerkn\WeCommerce\Models\Notification::with('user')->orderBy('created_at', 'desc')->where('type', 'Colección')->where('model_id', $category->id)->get();
            @endphp

             <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">Listado de cambios realizados</h4>
                            </div>
                        </div>
                        <hr>

                        @if($notifications->count() != 0)

                            @foreach($notifications as $notification)
                            <div class="note-row row align-items-center mb-3">
                                <div class="col-2">
                                    <div class="user-image text-center mr-3">
                                        @if($notification->model_action == 'update')
                                        <ion-icon style = "font-size: 2rem;" name="create-outline"></ion-icon>
                                        @endif
                                        @if($notification->model_action == 'create')
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                         @endif
                                        <p class="mb-0" style="font-size: 0.8rem;">{{ $notification->model_action}}</p>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="speech-wrap">
                                        <div class="">
                                            <p>{{ $notification->data }}</p>
                                               @php

                                                $user = Nowyouwerkn\WeCommerce\Models\User::where('id' , $notification->action_by)->first();
                                            @endphp
                                            <p class="mb-0"><small>{{ $user->name }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center my-5">

                            <h4 class="mb-0">No hay cambios en esta categoria todavía.</h4>
                        </div>
                        @endif
                    </div>
                </div>
                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    </div>
</div>
@endsection
