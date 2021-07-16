@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Productos</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('export.products') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>

            <a href="{{ route('products.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Nuevo producto
            </a>
        </div>
    </div>
@endsection

@section('content')

@if($products->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_1.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Crea y administra tus productos</h4>
        <p class="mb-4">Empieza a cargar productos en tu plataforma usando el botón superior.</p>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Nuevo Producto</a>
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
                                <th>SKU</th>
                                <th>Precio</th>
                                <th>Precio Descuento</th>
                                <th>Existencias</th>
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
                                    <strong><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></strong> <br><p style="width: 200px;">{{ substr($product->description, 0, 100)}} {{ strlen($product->description) > 100 ? "[...]" : "" }}</p>
                                </td>
                                <td style="width: 80px;">{{ $product->sku }}</td>
                                <td>$ {{ number_format($product->price,2) }}</td>
                                <td>
                                    $ {{ number_format($product->discount_price,2) }}
                                </td>
                                <td class="sizes-td">
                                    
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-link" data-toggle="tooltip" data-original-title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-link" data-toggle="tooltip" data-original-title="Editar">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>

                                    <!--
                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-sm btn-icon btn-flat btn-default delete" data-toggle="tooltip" data-original-title="Borrar">
                                            <i class="simple-icon-trash" aria-hidden="true"></i>
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    -->
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

<div id="modalImport" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('import.products') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Selecciona tu Archivo <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="import_file" required="" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar Documento</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection