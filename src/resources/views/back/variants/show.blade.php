@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                    <li class="breadcrumb-item" aria-current="page">Variantes</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $variant->type . ' ' . $variant->value }}</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">{{ $variant->type . ' ' . $variant->value }}</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('variants.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@push('stylesheets')

@endpush

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="card card-body">
            <h5 class="card-title display-4 mb-1">{{ $variant->value }}</h5>               
            <p>Productos con esta variante: {{ $variant->products->count() }}</p>
            <p class="card-text mb-0 mt-3">
                <small class="text-muted">Actualizado por última vez: <br>{{ $variant->updated_at }}</small>
            </p>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card card-body">
            @if($products->count())
            <div class="table-responsive mt-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>SKU / UPC</th>
                                <th>Precio</th>
                                <th>Precio Descuento</th>
                                <th>Características</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $v)
                            <tr>
                                <td style="width: 150px; position: relative;">
                                    <img style="width: 100%;" src="{{ asset('img/products/' . $v->product->image ) }}" alt="{{ $v->product->name }}">
                                    <div class="text-center margin-top-10">

                                        <small>
                                            <p>
                                            + {{ $v->product->images->count() }}

                                            @if($v->product->images->count() >= 1)
                                            Imágenes
                                            @else
                                            Imagen
                                            @endif
                                            </p>
                                        </small>    
                                    </div>
                                </td>
                                <td style="width: 250px;">
                                    <strong><a href="{{ route('products.show', $v->product->id) }}">{{ $v->product->name }}</a></strong> <br><p style="width: 200px;" class="mb-1">{{ substr($v->product->description, 0, 100)}} {{ strlen($v->product->description) > 100 ? "[...]" : "" }}</p>

                                    <small class="badge badge-info mb-3" style="white-space: unset;">{{ $v->product->search_tags }}</small>
                                </td>
                                <td style="width: 100px;">
                                    {{ $v->product->sku }}
                                    <small><em>{{ $v->product->barcode }}</em></small>
                                </td>
                                <td>${{ number_format($v->product->price,2) }}</td>
                                <td>
                                    ${{ number_format($v->product->discount_price,2) }}
                                </td>

                                <td>
                                    <ul class="list-unstyled mb-0">

                                        <li>
                                            @if($v->product->in_index == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Mostrar en Inicio
                                        </li>
                                        <li>
                                            @if($v->product->is_favorite == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Favorito
                                        </li>
                                        <li>
                                            @if($v->product->has_discount == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Descuento Activo
                                        </li>
                                        <li>
                                            @if($v->product->has_tax == true)
                                            <i class="fas fa-check text-info"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                            Tiene impuestos
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    @if($v->product->status == 'Publicado')
                                        <span class="status-circle bg-success"></span> Publicado
                                    @else
                                        <span class="status-circle bg-danger"></span> Borrador
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    {{-- 
                                    <a href="{{ route('products.show', $v->product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    --}}

                                    <a href="{{ route('products.show', $v->product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Editar">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>

                                    <form method="POST" action="{{ route('products.destroy', $v->product->id) }}" style="display: inline-block;">
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
            @else
            <div class="text-center mt-5">
                <h4 class="mb-0">{{ $variant->type . ' ' . $variant->value }} no tiene productos relacionados.</h4>
                <p>¡Empieza a utilizar esta variante en tus <a href="{{ route('products.index') }}">productos</a>!</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush