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
            <h4 class="mg-b-0 tx-spacing--1">Agregar Producto</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('products.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form method="POST" id="save-form" action="{{ route('products.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        {{-- 
        <div class="save-bar bg-success text-white d-flex align-items-center justify-content-between">
            <p class="mb-0">El sistema guarda como borrador ocasionalmente. Para hacerlo manual da click en el botón.</p>
            <button id="save-form" type="submit" class="btn-save-big btn btn-outline-light btn-sm text-white">Guardar cambios</button>
        </div>
        --}}
        
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
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required="">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Descripción <span class="text-danger">*</span></label>
                                <textarea name="description" cols="10" rows="3" class="form-control" required="">{{ old('description') }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="materials">Materiales <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea name="materials" cols="10" rows="3" class="form-control">{{ old('materiales') }}</textarea>
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">Color <span class="text-danger">*</span></label>
                                <input type="text" name="color" class="form-control" placeholder="Ej. Negro" value="{{ old('color') }}">
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <label for="pattern">Patrón</label>
                            <input type="text" name="pattern"class="form-control" placeholder="Ej. Liso, Lunares" value="{{ old('pattern') }}">
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="brand">Marca <span class="text-success tx-12">Recomendado</span></label>
                                <input type="text" name="brand" class="form-control" placeholder="" value="{{ old('brand') }}">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="in_index" name="in_index" value="1">
                                <label class="custom-control-label" for="in_index">Mostrar en Inicio</label>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_favorite" name="is_favorite" value="1">
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
                                <label for="model_image">Imagen de Modelo <span class="text-success tx-12">Recomendado</span></label>
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
                                <label for="discount_price">Precio <span class="text-danger">*</span></label>
                                <div class="input-group mg-b-10">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">MX$</span>
                                  </div>
                                    <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}" required="">
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <label for="discount_price">Precio en Descuento</label>
                                    <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">MX$</span>
                                    </div>
                                    <input type="text" id="discount_price" name="discount_price" value="{{ old('discount_price') }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-6">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" name="has_discount" id="customCheck1" value="1">
                                  <label class="custom-control-label" for="customCheck1">Activar descuento</label><br>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="discount_end">hasta:</label>
                                    <input type="date" id="discount_end" name="discount_end" value="{{ old('discount_end') }}" class="form-control">
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="production_cost">Costo de Producción</label>
                                <div class="input-group mg-b-10">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">MX$</span>
                                  </div>
                                    <input type="text" id="production_cost" name="production_cost" value="{{ old('production_cost') }}" class="form-control value-checker">
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
                                  <input type="checkbox" class="custom-control-input" id="has_tax" name="has_tax" value="1">
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
                                <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" value="1">
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sku">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc) <span class="text-info">(Opcional)</span></label>
                                <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="custom-control custom-checkbox" >
                                <input type="checkbox" class="custom-control-input" id="hasVariants" name="has_variants" value="1">
                                <label class="custom-control-label" for="hasVariants">Este producto tiene variantes</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Características de envío</h5>
                        <!--<p class="tx-12 tx-color-03 mg-b-0">Inventario.</p>-->
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height">Alto</label>
                                <input type="number" name="height" class="form-control" value="{{ old('height') }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="width">Ancho</label>
                                <input type="number" name="width" class="form-control" value="{{ old('width') }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="lenght">Largo</label>
                                <input type="number" name="lenght" class="form-control" value="{{ old('lenght') }}">
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="weight">Peso</label>
                                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @include('wecommerce::back.products.partials._variant_card') --}}
                        
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
                            <div class="form-group mb-3">
                                <label for="tsearch_tagsags">Género <span class="text-success tx-12">Recomendado</span></label>
                                <select class="custom-select tx-13" name="gender">
                                    <option value="unisex" selected="">Unisex</option>
                                    <option value="male">Hombres</option>
                                    <option value="female">Mujeres</option>
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <!--
                                <label for="category_id">Colección <span class="text-danger">*</span></label>
                                <select class="custom-select tx-13" name="category_id" required="">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                -->
                                @if($categories->count() != 0)
                                    <label for="category_id">Colección <span class="text-danger">*</span></label>
                                    <select class="custom-select tx-13 old-cat" id="main_category"  name="category_id" required="">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" name="category_name" class="form-control new-cat">

                                    <small><a href="javascript:void(0)" id="newCategory" class="btn-add original-state">Crear nueva categoría</a></small>
                                @else
                                    <label for="category_id">Colección <span class="text-danger">*</span></label>
                                    <input type="text" name="category_name" required="" class="form-control">
                                @endif
                            </div>

                            <div class="form-group">
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
                                    <label for="tsearch_tagsags">Etiquetas <span class="text-info tx-12">(Opcional)</span></label>
                                    <input type="text" name="search_tags" class="form-control" placeholder="Algodón, Fresco, Verano" value="{{ old('search_tags') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="condition">Condición <br> <span class="text-info tx-12">(Opcional)</span></label>
                                    <select class="custom-select tx-13" name="condition">
                                        <option value="new" selected="">Nuevo</option>
                                        <option value="used">Usado</option>
                                        <option value="refurbished">Renovado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="tsearch_tagsags">Rango de Edad <span class="text-success tx-12">Recomendado</span></label>
                                    <select class="custom-select tx-13" name="age_group">
                                        <option value="all ages" selected="">Todas las edades</option>
                                        <option value="adult">Adultos</option>
                                        <option value="teen">Adolescentes</option>
                                        <option value="kids">Niños/as</option>
                                        <option value="toddler">Bebes</option>
                                        <option value="infant">Infantes</option>
                                        <option value="newborn">Recien Nacidos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Disponibility -->
                {{-- 
                <div class="card mg-t-10 mb-4">
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Disponibilidad</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Disponibilidad.</p>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="available_date_start">Disponibilidad</label>
                                <input type="date" name="available_date_start" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                --}}
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
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
   <script src="{{ asset('lib/cleave.js/cleave.min.js') }}"></script>
<script type="text/javascript">
    var cleaveA = new Cleave('#price', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });

       var cleaveB = new Cleave('#discount_price', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });

        var cleaveC = new Cleave('#production_cost', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });
       
</script>

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
        var discount_price = $('#discount_price').replace(/,/g, "").val();
        var production_cost = $('#production_cost').replace(/,/g, "").val();

        var margin = ((parseFloat(price.replace(/,/g, "")) - parseFloat(production_cost.replace(/,/g, ""))) / 100);
        var profit = (parseFloat(price.replace(/,/g, "")) - parseFloat(production_cost.replace(/,/g, "")));

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
        $('#client_ip').append('<option value="0" disabled selected>Procesando...</option>');

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