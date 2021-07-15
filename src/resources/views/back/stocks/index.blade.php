@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventario</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Inventario</h4>
        </div>
        <!--
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>
        </div>
        -->
    </div>
@endsection

@section('content')

@if($products->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_1.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Administra tu Inventario</h4>
        <p class="mb-4">Para poder administrar tus existencias debes tener productos creados. Comienza con el botón de abajo.</p>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Nuevo Producto</a>
    </div>
@else
    <!-- Table -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">

                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dashboard mg-b-0">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Imagen</th>
                            
                                <th>SKU</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Disponible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>Variantes: {{ $product->variants->count() }}</td>
                                <td class="tx-color-03 tx-normal image-table">
                                    <img style="width: 100%;" src="{{ asset('img/products/' . $product->image ) }}" alt="{{ $product->name }}">
                                    <div class="text-center margin-top-10">
                                        <small><p>+ {{ $product->images->count() }} Imágen(es)</p></small>    
                                    </div>
                                </td>
                                <td>
                                    {{ $product->sku }}
                                </td>
                                <td>
                                    <strong><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></strong> <br><p style="width: 200px;">{{ substr($product->description, 0, 100)}} {{ strlen($product->description) > 100 ? "[...]" : "" }}</p>
                                </td>
                                
                                <td>$ {{ number_format($product->price,2) }}</td>
                                <td>
                                    {{ $product->stock }}
                                    <!--<nav class="nav nav-icon-only justify-content-end">
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </nav>-->
                                </td>
                                <td></td>
                            </tr>

                                @foreach($product->variants as $variant)
                                <tr class="bg-light">
                                    <td class="tx-color-03 tx-normal image-table">
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>{{ $variant->pivot->sku }}</td>
                                    <td><strong>{{ $variant->value }}</strong> <br><p>{{ $variant->type }}</p></td>
                                    <td>
                                        <nav class="nav nav-icon-only">
                                            <div class="form-group w-50">
                                                @if($variant->pivot->new_price == NULL)
                                                <input type="number" name="amount" class="form-control" value="{{ $product->price }}">
                                                @else
                                                <input type="number" name="amount" class="form-control" value="{{ $variant->pivot->new_price }}">
                                                @endif
                                            </div>
                                        </nav>
                                    </td>

                                    <td>
                                        <nav class="nav nav-icon-only">
                                            <div class="form-group w-50">
                                                <input type="number" name="amount" class="form-control" value="{{ $variant->pivot->stock }}">
                                            </div>
                                        </nav>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-sm btn-success">Actualizar</a>
                                    </td>
                                </tr>
                                @endforeach
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