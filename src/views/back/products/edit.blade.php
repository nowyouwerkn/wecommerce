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
            <h4 class="mg-b-0 tx-spacing--1">Editar Producto</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('products.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Firts Column -->
            <div class="col-md-8">
                <!-- Infomation General -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Datos generales</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Datos generales.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea name="description" cols="10" rows="3" class="form-control">{{ $product->description }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="materials">Materiales</label>
                                <textarea name="materials" cols="10" rows="3" class="form-control">{{ $product->materials }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="color" name="color" class="form-control" value="{{ $product->color }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <label for="pattern">Patron</label>
                            <input type="text" name="pattern"class="form-control" value="{{ $product->pattern }}">
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="in_index">Mostrar en Inicio</label>
                                <select class="custom-select tx-13" name="in_index">
                                    <option selected>Mostrar en tienda</option>
                                    <option value="1" {{ $product->in_index == $product->in_index ? 'selected' : '' }}>Si</option>
                                    <option value="0" {{ $product->in_index == $product->in_index ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_favorite">Marca favorita</label>
                                <select class="custom-select tx-13" name="is_favorite">
                                    <option selected>Marca favorita</option>
                                    <option value="1" {{ $product->is_favorite == $product->is_favorite ? 'selected' : '' }}>Si</option>
                                    <option value="0" {{ $product->is_favorite == $product->is_favorite ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Multimedia Elements -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Archivos multimedia</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>
                    </div>

                    <!-- Form --
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image_main">Imagen principal</label>
                                <input type="file" name="image_main" class="form-control" >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image_galery">Imagen de carrete</label>
                                <input type="file" name="image_galery" class="form-control" multiple >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image_life">Estilo de vida</label>
                                <input type="file" name="image_life" class="form-control" multiple>
                            </div>
                        </div>
                    </div>-->
                </div>
    
                <!-- Price -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Precios</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Precios.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Precio</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost">Costo</label>
                                <input type="number" name="cost" class="form-control" value="{{ $product->cost }}">
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="has_discount">Descuento</label>
                                <select class="custom-select tx-13" name="has_discount" value="{{ $product->has_discount }}">
                                    <option selected>descuento</option>
                                    <option value="1" {{ $product->has_discount == $product->has_discount ? 'selected' : '' }}>Si</option>
                                    <option value="0" {{ $product->has_discount == $product->has_discount ? 'selected' : '' }}>no</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_price">Decuento</label>
                                <input type="number" name="discount_price" class="form-control" value="{{ $product->discount_price }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="has_iva">Iva- Impuestos</label>
                                <select class="custom-select tx-13" name="has_iva">
                                    <option selected>descuento</option>
                                    <option value="1" {{ $product->has_iva == $product->has_iva ? 'selected' : '' }}>Si</option>
                                    <option value="0" {{ $product->has_iva == $product->has_iva ? 'selected' : '' }}>no</option>
                                </select>
                            </div>
                            <div class="bd bg-gray-50 pd-y-15 pd-x-15 pd-sm-x-20">
                                <h6 class="tx-15 mg-b-3">Anuncio</h6>
                                <span class="tx-13 tx-color-03">banner informativos que diga que los productos deben de tener IVA</span>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Inventory -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Inventario</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Inventario.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Cantidad</label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sku">SKU</label>
                                <input type="number" name="sku" class="form-control" value="{{ $product->sku }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height">Alto</label>
                                <input type="number" name="height" class="form-control" value="{{ $product->height }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="width">Ancho</label>
                                <input type="number" name="width" class="form-control" value="{{ $product->width }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="lenght">Largo</label>
                                <input type="number" name="lenght" class="form-control" value="{{ $product->lenght }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="weight">Peso</label>
                                <input type="number" name="weight" class="form-control" value="{{ $product->weight }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Variants -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Variantes</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Variantes.</p>
                    </div>

                    <!-- Form --
                    <div class="card-body row">
                        <div class="col-md-12 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="variants">
                                <label class="custom-control-label" for="variants">Este producto tiene variantes</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="variant">Variante</label>
                                <input type="text" name="variant" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="options">Opciones</label>
                                <input type="text" name="options" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Variant Heade --
                    <div class="table-responsive">
                        <table class="table table-dashboard mg-b-0">
                            <thead>
                                <tr>
                                    <th>Variante</th>
                                    <th class="text-right">Precio</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Codigo SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tx-color-03 tx-normal">1</td>
                                    <td class="text-right">
                                        <input type="number" name="price_variant" class="form-control">
                                    </td>
                                    <td class="text-right">
                                        <input type="number" name="amount_variant" class="form-control">
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="sku_variant" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-md-12 my-3">
                            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                                Agregar otra variante
                            </a>
                        </div>
                    </div>-->
                </div>
            </div>
    
            <!-- Second -->
            <div class="col-md-4">
                <!-- Estatus product -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Categoria</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Categoria.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id">Estatus</label>
                                <select class="custom-select tx-13" name="category_id">
                                    <option selected>Categorias</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estatus product -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Estatus</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">estatus.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Estatus</label>
                                <select class="custom-select tx-13" name="status">
                                    <option selected>Estatus</option>
                                    <option value="1" {{ $product->id == $product->status ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ $product->id == $product->status ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Tags -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Etiquetas</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Etiquetas.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tsearch_tagsags">Etiquetas</label>
                                <input type="text" name="search_tags" class="form-control" value="{{ $product->search_tags }}">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Disponibility -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Disponibilidad</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Disponibilidad.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="disponibility">Disponibilidad</label>
                                <input type="date" name="disponibility" class="form-control" value="{{ $product->disponibility }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
@endsection