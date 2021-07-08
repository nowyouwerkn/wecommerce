@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Agregar Producto</h4>
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
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="row">
            <!-- Firts Column -->
            <div class="col-md-8">
                <!-- Infomation General -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Datos generales</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Datos generales.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea name="description" cols="10" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="materials">Materiales</label>
                                <textarea name="materials" cols="10" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Ej. Negro">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <label for="pattern">Patron</label>
                            <input type="text" name="pattern"class="form-control" placeholder="Ej. Liso, Lunares">
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="in_index">
                                <label class="custom-control-label" for="in_index">Mostrar en Inicio</label>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_favorite">
                                <label class="custom-control-label" for="is_favorite">Este producto es un favorito</label>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Multimedia Elements -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Archivos multimedia</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="model_image">Imagen de Modelo</label>
                                <input type="file" name="model_image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Price -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Precios</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Precios.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="discount_price">Precio</label>
                                <div class="input-group mg-b-10">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">MX$</span>
                                  </div>
                                    <input type="number" name="price" class="form-control">
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <label for="discount_price">Precio en Descuento</label>
                                    <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">MX$</span>
                                    </div>
                                    <input type="number" name="discount_price" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-6">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                                  <label class="custom-control-label" for="customCheck1">Activar descuento</label><br>
                                </div>
                            </div> 
                        </div>
                        
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <label for="production_cost">Costo de Producción</label>
                                <div class="input-group mg-b-10">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">MX$</span>
                                  </div>
                                    <input type="number" name="production_cost" class="form-control">
                                </div>
                                <span class="tx-13 tx-color-03 d-block">Tus clientes no verán esto.</span>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-between pt-4">
                                    <div class="">
                                        <p class="mb-0">Margen</p>
                                        <h2>-</h2>
                                    </div>
                                    <div class="">
                                        <p class="mb-0">Ganancia</p>
                                        <h2>-</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="has_tax">
                                  <label class="custom-control-label" for="has_tax">Este producto tiene impuestos (I.V.A 16%)</label>
                                  <span class="tx-13 tx-color-03 d-block wd-60p">Aparecerá un anuncio informativo en el detalle de producto indicando los impuestos de acuerdo a tu configuración de cuenta.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    
                <!-- Inventory -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Inventario</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Inventario.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock">Cantidad</label>
                                <input type="number" name="stock" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc)</label>
                                <input type="text" name="barcode" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Características de Envío</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Inventario.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height">Alto</label>
                                <input type="number" name="height" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="width">Ancho</label>
                                <input type="number" name="width" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="lenght">Largo</label>
                                <input type="number" name="lenght" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="weight">Peso</label>
                                <input type="number" name="weight" class="form-control">
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

                    <!-- Form -->
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

                    <!-- Variant Heade -->
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
                    </div>
                </div>
            </div>
    
            <!-- Second -->
            <div class="col-md-4">
                <!-- Estatus product -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Estatus</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">estatus.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Estatus</label>
                                <select class="custom-select tx-13" name="status">
                                    <option value="Borrador" selected="">Borrador</option>
                                    <option value="Publicado">Publicado</option>
                                </select>

                                <span class="tx-13 tx-color-03 d-block mt-2">Este producto estará oculto de tu tienda pero aparecerá en tu listado de productos.</span>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Estatus product -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Categorización</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Categoria.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label for="category_id">Categoria Principal (Tipo)</label>
                                <select class="custom-select tx-13" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-1">
                                    <label for="tsearch_tagsags">Etiquetas</label>
                                    <input type="text" name="search_tags" class="form-control" placeholder="Algodón, Fresco, Verano">
                                </div>
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
                                <label for="available_date_start">Disponibilidad</label>
                                <input type="date" name="available_date_start" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="col-md-4 offset-md-8 text-center">
                <button type="submit" class="btn btn-primary btn-block">
                    Guardar Producto
                </button>
            </div>
        </div>
    </form>
@endsection