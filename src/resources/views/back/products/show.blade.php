@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

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

    .btn-add{
        text-transform: uppercase;
        padding: 15px 0px;
        display: inline-block;
        font-size: .8em;
    }

    .new-aut,
    .new-cat{
        display: none;
    }

    .image-btn{
        border: 3px dotted rgba(72, 94, 144, 0.3);
        display: block;
        width: 100%;
        height: 100%;
        text-align: center;
        border-radius: 20px;
        min-height: 160px;
        text-transform: uppercase;
        color: rgba(72, 94, 144, 0.3);
        padding: 40px 0px;
    }

    .image-btn span{
        display: block;
        text-align: center;
        margin-bottom: 15px;
        font-size: 3em;
    }

    .image-btn: hover{
        border: 3px dotted rgba(72, 94, 144, 0.3);
        background-color: rgba(72, 94, 144, 0.3);
    }

    .thumbnail-wrap .btn{
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: .8em;
        padding: 1px 3px;
    }
</style>
@endpush

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
            <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block;">
                <button type="submit" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5" data-toggle="tooltip" data-original-title="Borrar">
                    <i class="fas fa-trash mr-1"></i> Borrar
                </button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <a href="{{ route('products.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
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
                            <label for="name">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Descripcion <span class="text-danger">*</span></label>
                            <textarea name="description" cols="10" rows="3" class="form-control">{{ $product->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="materials">Materiales</label>
                            <textarea name="materials" cols="10" rows="3" class="form-control">{{ $product->materials }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="color">Color<span class="text-danger">*</span></label>
                            <input type="text" name="color" class="form-control" placeholder="Ej. Negro" value="{{ $product->color }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="pattern">Patron</label>
                        <input type="text" name="pattern"class="form-control" placeholder="Ej. Liso, Lunares" value="{{ $product->pattern }}">
                    </div>

                    <div class="col-md-4">
                            <div class="form-group">
                                <label for="brand">Marca <span class="text-success tx-12">Recomendado</span></label>
                                <input type="text" name="brand" class="form-control" placeholder="" value="{{ $product->brand }}">
                            </div>
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
                    <div class="col-md-4">
                        <div class="thumbnail-wrap">
                            <a href="javascript:void(0)" data-target="#modalChangeImage" data-toggle="modal" class="btn btn-rounded btn-icon btn-info" data-toggle="tooltip" data-original-title="Cambiar Imágen"><i class="fas fa-edit" aria-hidden="true"></i></a>
                            <img class="img-fluid mb-4" src="{{ asset('img/products/' . $product->image ) }}">
                        </div>
                    </div>
                    @foreach($product->images as $image)
                        <div class="col-md-4">
                            <div class="thumbnail-wrap">
                                <button type="button" id="deleteImage_{{ $image->id }}" class="btn btn-rounded btn-icon btn-danger" data-toggle="tooltip" data-original-title="Borrar">
                                        <i class="fas fa-times" aria-hidden="true"></i>
                                    </button>

                                @push('scripts')

                                <form method="POST" id="deleteImageForm_{{ $image->id }}" action="{{ route('image.destroy', $image->id) }}" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>

                                <script type="text/javascript">
                                    $('#deleteImage_{{ $image->id }}').on('click', function(){
                                        event.preventDefault();
                                        $('#deleteImageForm_{{ $image->id }}').submit();
                                    });
                                </script>
                                @endpush
                                
                                
                                <img class="img-fluid mb-4" src="{{ asset('img/products/' . $image->image )  }}">
                            </div>
                            <p>{{ $image->descripcion }}</p>
                        </div>
                    @endforeach

                    <div class="col-md-4">
                        <a href="javascript:void(0)" data-target="#modalNewImage" data-toggle="modal" class="image-btn"><span class="fas fa-plus"></span> Agregar más imágenes</a>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalChangeImage" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalCreateLabel">Cambiar Imágen de Modelo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="form-group">
                                        <label for="model_image">Imagen de Modelo</label>
                                        <input type="file" name="model_image" class="form-control">
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Guardar Imagen</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalNewImage" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalCreateLabel">Nueva Imágen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="form-group">
                                        <label for="image">Imagen</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="description">Descripción</label>
                                        <textarea class="form-control" name="description" rows="5"></textarea>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Guardar Imagen</button>
                                    </div>
                                </form>
                                </div>
                            </div>
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
                            <label for="discount_price">Precio <span class="text-danger">*</span></label>
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

                            <div class="form-group mt-3">
                                <label for="discount_end">hasta:</label>
                                <input type="date" id="discount_end" name="discount_end" value="{{ $product->discount_end }}" class="form-control">
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
                              <input type="checkbox" class="custom-control-input" id="has_tax" name="has_tax" value="1" {{ ($product->has_tax == '1') ? 'checked' : '' }}>
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
                            <label for="stock">Cantidad <span class="text-danger">*</span></label>
                            @if($product->has_variants == true)
                            <input type="number" name="stock" class="form-control" value="{{ $total_qty }}" readonly="">
                            @else
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sku">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc) <span class="text-info">(Opcional)</span></label>
                            <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        @if($product->has_variants == true)
                        <div class="custom-control custom-checkbox" >
                            <input type="checkbox" class="custom-control-input" id="hasVariants" name="has_variants" checked="" value="1">
                            <label class="custom-control-label" for="hasVariants">Este producto tiene variantes</label>
                        </div>
                        @else
                        <div class="custom-control custom-checkbox" >
                            <input type="checkbox" class="custom-control-input" id="hasVariants" name="has_variants" value="1">
                            <label class="custom-control-label" for="hasVariants">Este producto tiene variantes</label>
                        </div>
                        @endif
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

            @if($product->has_variants == true)
                @include('wecommerce::back.products.partials._variant_card')
            @endif       
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
                        <div class="form-group mb-3">
                            <label for="tsearch_tagsags">Género <span class="text-success tx-12">Recomendado</span></label>
                            <select class="custom-select tx-13" name="gender">
                                <option value="unisex" {{ ($product->gender == 'unisex') ? 'selected' : '' }}>Unisex</option>
                                <option value="male" {{ ($product->gender == 'male') ? 'selected' : '' }}>Hombres</option>
                                <option value="female" {{ ($product->gender == 'female') ? 'selected' : '' }}>Mujeres</option>
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            @if($categories->count() != 0)
                                <label for="category_id">Colección <span class="text-danger">*</span></label>
                                <select class="custom-select tx-13 old-cat" id="main_category" name="category_id" required="">
                                    @foreach ($categories as $category)
                                        <option {{ ($category->id == $product->category_id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <input type="text" name="category_name" class="form-control new-cat">

                                <small><a href="javascript:void(0)" id="newCategory" class="btn-add original-state">Crear nueva categoría</a></small>
                            @else
                                <label for="category_id">Colección <span class="text-danger">*</span></label>
                                <input type="text" name="category_name" required="" class="form-control">
                            @endif
                        </div>

                        <div class="mt-4 mb-2">
                            <h6>Subcategorías actualmente seleccionadas</h6>
                            @if($product->subCategory->count() == 0)
                                <p class="text-danger">Este producto no está relacionado a ninguna subcategoría.</p>
                            @else
                                @foreach($product->subCategory as $fff)
                                <span class="badge badge-primary">{{ $fff->name }}</span>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label>Sub-Categorías</label>
                            <select class="form-control select2" name="subcategory[]" id="subcategory" data-plugin="select2" multiple="">

                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3 mt-2">
                                <label for="tsearch_tagsags">Etiquetas <span class="text-success">Recomendado</span></label>
                                <input type="text" name="search_tags" class="form-control" placeholder="Algodón, Fresco, Verano" value="{{ $product->search_tags }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="condition">Condición <br> <span class="text-info tx-12">(Opcional)</span></label>
                                    <select class="custom-select tx-13" name="condition">
                                        <option value="new" {{ ($product->condition == 'new') ? 'selected' : '' }}>Nuevo</option>
                                        <option value="used" {{ ($product->condition == 'used') ? 'selected' : '' }}>Usado</option>
                                        <option value="refurbished" {{ ($product->condition == 'refurbished') ? 'selected' : '' }}>Renovado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="tsearch_tagsags">Rango de Edad <span class="text-success tx-12">Recomendado</span></label>
                                    <select class="custom-select tx-13" name="age_group">
                                        <option value="all ages" {{ ($product->age_group == 'all ages') ? 'selected' : '' }}>Todas las edades</option>
                                        <option value="adult" {{ ($product->age_group == 'adult') ? 'selected' : '' }}>Adultos</option>
                                        <option value="teen" {{ ($product->age_group == 'teen') ? 'selected' : '' }}>Adolescentes</option>
                                        <option value="kids" {{ ($product->age_group == 'kids') ? 'selected' : '' }}>Niños/as</option>
                                        <option value="toddler" {{ ($product->age_group == 'toddler') ? 'selected' : '' }}>Bebes</option>
                                        <option value="infant" {{ ($product->age_group == 'infant') ? 'selected' : '' }}>Infantes</option>
                                        <option value="newborn" {{ ($product->age_group == 'newborn') ? 'selected' : '' }}>Recien Nacidos</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            {{-- 
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
            --}}

            <div class="text-center">
                <button type="submit" class="btn btn-block btn-big pd-x-15 btn-primary btn-uppercase mg-l-5">
                    <i class="fas fa-save mr-1"></i> Guardar Producto
                </button>
            </div>
        </div>
        <!-- Button -->
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Selecciona una opción..."
        });
    });

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

    $("#newCategory").click(function() {
        var $this = $(this);
        $(".new-cat").toggle("slow");
        $(".old-cat").toggle("slow");
        $this.toggleClass("original-state");

        if ($this.hasClass("original-state")) {
            $("#newCategory").text("Crear Nueva Categoría");
        }else{
            $("#newCategory").text("Seleccionar Categoría");
            
        }
    });

    $("#hasVariants").click(function() {
        $('#save-form').submit();
    });

    $('#main_category').on('click', function(){
        event.preventDefault();

        var value = $('#main_category').val();
        $('#client_ip').append('<option value="0" disabled selected>Processing...</option>');

        $.ajax({
            method: 'POST',
            url: "{{ route('dynamic.subcategory') }}",
            data:{ 
                value:value, 
                _token: '{{ Session::token() }}', 
            },
            success: function(response){
                //console.log(msg['mensaje']);
                $('#subcategory').empty();
                //$('#subcategory').append(`<option value="0" disabled selected>Select a Sub-category</option>`);
                response.forEach(element => {
                    $('#subcategory').append(`<option value="${element['id']}">${element['name']}</option>`);
                });
            },
            error: function(response){
                //console.log(msg['mensaje']);
                $('.error-service').show();
            }
        });
    });
</script>
@endpush