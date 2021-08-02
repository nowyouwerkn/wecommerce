@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Búsqueda General</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Búsqueda General</h4>
        </div>
        <div class="d-none d-md-block">
            <!--
            <a href="{{ route('dashboard') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Dashboard
            </a>
            -->
        </div>
    </div>
@endsection

@section('content')

<h2 class="margin-text-2">Resultados para: {{ Request::input('query') }}</h2>
<p>Encontrado {{ $products->count() }} resultado(s) que concuerdan con tu búsqueda</p>

@if($products->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_6.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>No se encontró nada en tu búsqueda</h4>
    </div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
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
                                <td>${{ number_format($product->price,2) }}</td>
                                <td>
                                    ${{ number_format($product->discount_price,2) }}
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

                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
@endsection