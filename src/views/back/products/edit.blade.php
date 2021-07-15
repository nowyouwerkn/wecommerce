@extends('wecommerce::back.layouts.main')

@section('stylesheets')
<style type="text/css">
    .save-bar{
        position: fixed;
        width: calc(100% - 240px);
        bottom: -55px;
        left: 240px;
        padding: 10px 40px;
        z-index: 99;

        transition: all .2s ease-in-out;
    }

    .show-bar{
        bottom: 0px;
    }

    .custom-control{
        display: inline-block;
    }

    .hidden{
        display: none;
    }
</style>
@endsection

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
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form method="POST" id="save-form" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="save-bar bg-success text-white d-flex align-items-center justify-content-between">
            <p class="mb-0">El sistema guarda como borrador ocasionalmente. Para hacerlo manual da click en el botón.</p>
            <button id="save-form" type="submit" class="btn-save-big btn btn-outline-light btn-sm text-white">Guardar cambios</button>
        </div>
        
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
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea name="description" cols="10" rows="3" class="form-control">{{ $product->description }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="materials">Materiales</label>
                                <textarea name="materials" cols="10" rows="3" class="form-control">{{ $product->materials }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Ej. Negro" value="{{ $product->color }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <label for="pattern">Patron</label>
                            <input type="text" name="pattern"class="form-control" placeholder="Ej. Liso, Lunares" value="{{ $product->pattern }}">
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="in_index" name="in_index" value="1" {{ ($product->in_index == '1') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="in_index">Mostrar en Inicio</label>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_favorite" name="is_favorite" value="1" {{ ($product->is_favorite == '1') ? 'checked' : '' }} >
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
                                    <input type="number" id="price" name="price" class="form-control" value="{{ $product->price }}">
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <label for="discount_price">Precio en Descuento</label>
                                    <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">MX$</span>
                                    </div>
                                    <input type="number" id="discount_price" name="discount_price" class="form-control" value="{{ $product->discount_price }}">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-6">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" name="has_discount" id="customCheck1" value="1" {{ ($product->has_discount == '1') ? 'checked' : '' }}>
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
                                    <input type="number" id="production_cost" name="production_cost" class="form-control value-checker" value="{{ $product->production_cost }}">
                                </div>
                                <span class="tx-13 tx-color-03 d-block">Tus clientes no verán esto.</span>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-between pt-4">
                                    <div class="">
                                        <p class="mb-0">Margen</p>
                                        <h2><span id="margin">-</span>%</h2>
                                    </div>
                                    <div class="">
                                        <p class="mb-0">Ganancia</p>
                                        <h2>$<span id="profit">-</span></h2>
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
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc)</label>
                                <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
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

                @include('wecommerce::back.products.partials._variant_card')
                        
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
                                    <option {{ ($product->status == 'Borrador') ? 'selected' : '' }} value="Borrador">Borrador</option>
                                    <option {{ ($product->status == 'Publicado') ? 'selected' : '' }} value="Publicado">Publicado</option>
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
                                    <input type="text" name="search_tags" class="form-control" placeholder="Algodón, Fresco, Verano" value="{{ $product->search_tags }}">
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
                                <input type="date" name="available_date_start" class="form-control" value="{{ $product->available_date_start }}">
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

@push('scripts')
<script type="text/javascript">
    // Value Checker
    $('.value-checker').keyup(function(){
        event.preventDefault();

        var price = $('#price').val();
        var discount_price = $('#discount_price').val();
        var production_cost = $('#production_cost').val();

        var margin = ((parseFloat(price) - parseFloat(production_cost)) / 100);
        var profit = (parseFloat(price) - parseFloat(production_cost));

        $('#margin').text(parseFloat(margin).toFixed(2));
        $('#profit').text(parseFloat(profit).toFixed(2));
    });

    $('.form-control').keyup(function(){
        event.preventDefault();

        if ($(this).val().length === 0 ) {
            $('.save-bar').removeClass('show-bar');
        }else{
            $('.save-bar').addClass('show-bar');
        }
    });

</script>
@endpush