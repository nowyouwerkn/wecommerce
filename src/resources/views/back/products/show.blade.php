@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<style>
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

    .image-btn:hover{
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

    .update {
        color: green;
        background: none;
        border:  1px solid green;
        text-align: center;
    }

    .priority-badge {
        position: absolute;
        top: 10px;
        left: 20px;
        background-color: grey;
        color: white;
        text-align: center;
        margin-top: 0;
        margin-bottom: 0;
        padding: 0.5rem;
        width: 30px;
        border-radius: 30px;
    }

    .digital-btn{
        background-color: #fff;
        border: 1px solid;
        border-color: #c0ccda;
        color: rgba(27, 46, 75, 0.7);
        padding: 30px 20px;
        display: inline-block;
        border-radius: 10px;
        width: 100%;
        transition: all .2s ease-in-out;
    }

    .digital-btn img{
        width: 50px;
        margin-bottom: 15px;
    }

    .digital-btn h5{
        font-size: 1em;
        margin-bottom: 0px;
    }

    .digital-btn:hover{
        background-color: #dfe6e9;
    }

    .digital-btn.active{
        background-color: #dfe6e9;
    }

    .btn-eliminate{
        width: 20px;
        height: 20px;
        background-color: red;
        color: #fff;
        display: inline-block;
        border-radius: 100%;
        text-align: center;
        line-height: 20px;
        font-size: .8em;
    }

    .btn-save{
        width: 20px;
        height: 20px;
        background-color: green;
        color: #fff;
        display: inline-block;
        border-radius: 100%;
        text-align: center;
        line-height: 20px;
        font-size: .8em;
        border: none;
    }

    .btn-save-2{
        width: 20px;
        height: 20px;
        background-color: rgb(29, 157, 242);
        color: #fff;
        display: inline-block;
        border-radius: 100%;
        text-align: center;
        line-height: 20px;
        font-size: .8em;
        border: none;
    }

    .dropzone{
        min-height: 10rem;
        border: 3px dotted #d9d9d9;
        position: relative;
        border-radius: 15px;
        margin-bottom: 20px;
    }

    .icon-box{
        text-align: center;
        padding: 10px;
        height: 100%;
        border:1px dotted grey;
        border-radius: 5px;
        margin-right: 10px;
    }

    .icon-box i{
        color: grey;
    }

    .price-discounted{
        text-decoration: line-through;
        color: rgba(0, 0, 0, 0.8);
        font-size: .9em;
    }

    .circle-icon{
        border-radius: 100%;
        text-align: center;
        width: 22px;
        height: 22px;
        display: inline-flex;
        padding: 4px 5px;
    }

    .success-update{
        background-color: #10b759;
        width: 100%;
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        z-index: 2;
        color: #fff;
        opacity: .7;
        padding: 27px 0px;
        display: none;
    }

    .error-update{
        background-color: #ff7675;
        width: 100%;
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        z-index: 2;
        color: #fff;
        opacity: .9;
        padding: 27px 0px;
        display: none;
    }

    .child-row{
        position: relative;
        overflow: hidden;
    }

    .filter-btn{
        border: none;
        background-color: transparent;
        color: rgba(27, 46, 75, 0.7);
        font-size: 12px;
        padding: 0px 2px;
    }

    .table .table-title{
        margin-right: 6px;
    }

    .filter-btn:hover{
        color: #000;
    }

    .btn-stock{
        display: inline-block;
        width: 20px;
        height: 20px;
        line-height: 16px;
        border-radius: 100%;
        margin: 0 5px;
        border: 1px solid #c0ccda;
        text-align: center;
        color: #000;
    }

    .btn-stock:hover{
        background-color: #c0ccda;
        color: #000;
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

            <a href="{{ route('products.duplicate', $product->id) }}" data-toggle="modal" data-target="#duplicateModal" class="btn btn-sm pd-x-15 btn-outline-secondary btn-uppercase mg-l-5">
                <i class="far fa-copy mr-1"></i> Duplicar Producto
            </a>

            <a href="{{ route('products.show.preview', $product->id) }}" class="btn btn-sm pd-x-15 btn-outline-secondary btn-uppercase mg-l-5">
                <i class="far fa-eye"></i> Vista Previa
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>

    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Duplicar {{ $product->name }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('products.duplicate', $product->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="name">Nombre del nuevo producto <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }} (Copia)">
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="duplicate_images" name="duplicate_images" value="1">
                            <label class="custom-control-label" for="duplicate_images">Duplicar fotos</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="far fa-copy mr-1"></i> Duplicar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
<!-- Form -->
<form method="POST" id="save-form" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    @switch($product->type)
        @case('physical')
            <div class="row">
                <!-- Firts Column -->
                <div class="col-md-8">
                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Datos generales</h5>
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Descripción <span class="text-danger">*</span></label>
                                    <textarea name="description" cols="10" rows="3" class="form-control">{{ $product->description }}</textarea>
                                    <small class="text-muted">Debe contener al menos 30 caracteres.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="materials">Materiales</label>
                                    <textarea name="materials" cols="10" rows="3" class="form-control">{{ $product->materials }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="form-group me-2">
                                        <label for="color">Color <span class="text-danger">*</span></label>
                                        <input type="text" name="color" class="form-control" placeholder="Ej. Negro" value="{{ $product->color }}" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="hex_color"># <span class="text-danger">*</span></label>
                                        <input type="color" name="hex_color" class="form-control" value="{{ $product->hex_color ?? '#17A2B8'}}" style="width:50px;" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="pattern">Patrón</label>
                                <input type="text" name="pattern" class="form-control" placeholder="Ej. Liso, Lunares" value="{{ $product->pattern }}">
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
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                <div id="dropzoneForm" class="dropzone">
                                    <div class="dz-message" data-dz-message><span>
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 3em; margin-bottom:10px;"></i><br>
                                        Arrastra y suelta aqui tus archivos o da click para buscar
                                    </span></div>
                                </div>
                                <div align="center">
                                    <button type="button" class="btn btn-info" id="submit-all">Subir</button>
                                </div>
                                <hr>

                                <h5 class="mg-b-5">Imagenes Asociadas</h5>
                                <div id="uploaded_image">
          
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="link">Identificador del Video <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control video-input" name="video_background" value="{{ $product->video_link }}" />
        
                                <p class="mb-0 mt-2">Ejemplo:</p>
                                <p class="example-url">https://www.youtube.com/watch?v=<span class="video-identifier">SMKP21GW083c</span></p>
                            </div>
        
                            <style type="text/css">
                                .video-identifier{
                                    display: inline-block;
                                    padding: 3px 3px;
                                    border: 2px solid red;
                                }
        
                                .example-url{
                                    font-size: .8em;
                                }
                            </style>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Precios</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="discount_price">Precio <span class="text-danger">*</span></label>
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">MX$</span>
                                        </div>
                                        <input type="number" id="price" name="price" class="form-control" value="{{ $product->price }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_price">Precio en Descuento</label>
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">MX$</span>
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
                                            <span class="input-group-text">MX$</span>
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

                                <!--IVA->
                                <div class="col-md-12 mt-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="has_tax" name="has_tax" value="1" {{ ($product->has_tax == '1') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="has_tax">Este producto incluye impuestos</label>
                                        <span class="tx-13 tx-color-03 d-block wd-60p">Seleccionar esta casilla si el valor ingresado en el campo de "Precio" ya incluye I.V.A. De lo contrario, la plataforma agregará el impuesto automáticamente (Para tiendas configuradas en MXN).</span>
                                    </div>
                                </div>
                                <!--iva-->
                            </div>
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="card mg-t-10 mb-3">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Inventario</h5>
                        </div>

                        <div class="card-body row">
                            @if($branches->count() == 0)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock">Cantidad <span class="text-danger">*</span></label>
                                    @if($product->has_variants == true)
                                    <input type="number" name="stock" class="form-control" value="{{ $total_qty }}" readonly="" required>
                                    @else
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="col">
                                <div class="form-group">
                                    <label for="sku">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc) <span class="text-info">(Opcional)</span></label>
                                    <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
                                </div>
                            </div>

                            @if($branches->count() != 0)
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mg-b-5 text-uppercase">Cantidad <span class="text-danger">*</span></h6>
                            </div>

                            <div class="col-md-6 text-right">
                                <a href="{{ route('branches.index') }}">Editar Sucursales</a>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive mt-3 mb-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Entrante</th>
                                                <th>Comprometido</th>
                                                <th>Disponible</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($branches as $branch)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="icon-box">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $branch->name }}</strong><br>
                                                            <small>{{ $branch->street . ' ' . $branch->street_num . ' ' . $branch->postal_code . ' ' . $branch->city . ' ' . $branch->state . ', ' . $branch->country_id }}</small>
                                                        </div>
                                                    </div>

                                                    <span id="success-update-p{{ $product->id }}" class="success-update"><i class="fas fa-check mr-2"></i> Actualización exitosa </span>
                                                    <span id="error-update-p{{ $product->id }}" class="error-update"><i class="fas fa-times mr-2"></i> Problema de datos. Inicia sesión nuevamente o refresca la pantalla. </span>
                                                </td>
                
                                                <td>
                                                    <input type="number" style="width:80px" name="entry_stock" class="form-control" value="{{ $branch->inventory->entry_stock ?? '0'}}" required>
                                                </td>
                                                    
                                                <td>
                                                    <input type="number" style="width:80px" name="commited_stock" class="form-control" value="{{ $branch->inventory->commited_stock ?? '0'}}" required>
                                                </td>

                                                <td>
                                                    <input type="number" style="width:80px" name="stock" id="branchStock_{{ $branch->id }}" class="form-control" value="{{ $branch->inventory->stock ?? '0'}}" required>
                                                </td>
                                                <td>
                                                    <button id="branchStockUpdate{{ $branch->id }}" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5">
                                                        <i class="fas fa-sync mr-1" aria-hidden="true"></i> Actualizar
                                                    </button>
                                                </td>
                                            </tr>

                                            @push('scripts')
                                            <script type="text/javascript">
                                                $('#branchStockUpdate{{ $branch->id }}').on('click', function(){
                                                    event.preventDefault();

                                                    $.ajax({
                                                        method: 'POST',
                                                        url: "{{ route('branch.stock.update', $branch->id) }}",
                                                        data:{
                                                            stock: $('#branchStock_{{ $branch->id }}').val(),
                                                            product_id: '{{ $product->id }}',
                                                            _method: "PUT",
                                                            _token: "{{ Session::token() }}", 
                                                        },
                                                        success: function(msg){
                                                            console.log(msg['mensaje']);

                                                            $('#success-update-p{{ $product->id }}').fadeIn();

                                                            setTimeout(function () {
                                                                $('#success-update-p{{ $product->id }}').fadeOut();
                                                            }, 500);
                                                        },
                                                        error: function(msg){
                                                            $('#error-update-p{{ $product->id }}').fadeIn();

                                                            console.log(msg);        
                                                        }
                                                    });
                                                });
                                            </script>
                                            @endpush
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

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
                </div>

                <div class="col-md-4">
                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Estatus</h5>
                        </div>

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

                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Categorización</h5>
                        </div>

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

                                @php
                                    $subcategories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', $product->category_id)->get();
                                @endphp

                                <div class="form-group mt-3">
                                    <label>Sub-Categorías</label>
                                    <select class="form-control select2" name="subcategory[]" id="subcategory" data-plugin="select2" multiple="">
                                        @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @endforeach
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

                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Características de Envío</h5>
                        </div>

                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height">Alto</label>
                                    <input type="number" name="height" class="form-control" value="{{ $product->height }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">Ancho</label>
                                    <input type="number" name="width" class="form-control" value="{{ $product->width }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lenght">Largo</label>
                                    <input type="number" name="lenght" class="form-control" value="{{ $product->lenght }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight">Peso</label>
                                    <input type="number" name="weight" class="form-control" value="{{ $product->weight }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-block btn-big pd-x-15 btn-primary btn-uppercase mg-l-5">
                            <i class="fas fa-save mr-1"></i> Guardar Producto
                        </button>
                    </div>
                </div>
            </div>
        @break

        @case('digital')
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
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Descripción <span class="text-danger">*</span></label>
                                    <textarea name="description" cols="10" rows="3" class="form-control" required="">{{ $product->description }}</textarea>
                                    <small class="text-muted">Debe contener al menos 30 caracteres.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="terms_conditions">Términos y Condiciones <span class="text-info tx-12">(Opcional)</span></label>
                                    <textarea name="terms_conditions" cols="10" rows="3" class="form-control">{{ $product->terms_conditions }}</textarea>
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
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                <div id="dropzoneForm" class="dropzone">
                                    <div class="dz-message" data-dz-message><span>
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 3em; margin-bottom:10px;"></i><br>
                                        Arrastra y suelta aqui tus archivos o da click para buscar
                                    </span></div>
                                </div>
                                <div align="center">
                                    <button type="button" class="btn btn-info" id="submit-all">Subir</button>
                                </div>
                                <hr>

                                <h5 class="mg-b-5">Imagenes Asociadas</h5>
                                <div id="uploaded_image">
          
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="link">Identificador del Video <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control video-input" name="video_background" value="{{ $product->video_link }}" />
        
                                <p class="mb-0 mt-2">Ejemplo:</p>
                                <p class="example-url">https://www.youtube.com/watch?v=<span class="video-identifier">SMKP21GW083c</span></p>
                            </div>
        
                            <style type="text/css">
                                .video-identifier{
                                    display: inline-block;
                                    padding: 3px 3px;
                                    border: 2px solid red;
                                }
        
                                .example-url{
                                    font-size: .8em;
                                }
                            </style>
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
                                        <input type="text" id="price" name="price" class="form-control" value="{{ $product->price }}" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_price">Precio en Descuento</label>
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">MX$</span>
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
                            <div class="col-md-4" style="display: none;">
                                <div class="form-group">
                                    <label for="stock">Cantidad <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" class="form-control" value="1" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sku">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="barcode">Código de Barras (ISBN, UPC, GTIN, etc) <span class="text-info">(Opcional)</span></label>
                                    <input type="text" name="barcode" class="form-control" value="{{ $product->barcode }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files -->
                    <div class="card mg-t-10 mb-4">
                        <!-- Header -->
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Descargable</h5>
                            <!--<p class="tx-12 tx-color-03 mg-b-0">Inventario.</p>-->
                        </div>

                        <!-- Form -->
                        <div class="card-body">
                            <div class="row downloadable-btns">
                                <div class="col-md-4 pr-2">
                                    <button type="button" id="imageType" class="text-center digital-btn">
                                        <img src="{{ asset('assets/img/image-type.png') }}" alt="">
                                        <h5>Imágen</h5>
                                    </button>
                                </div>
                                <div class="col-md-4 px-2">
                                    <button type="button" id="docType" class="text-center digital-btn">
                                        <img src="{{ asset('assets/img/doc-type.png') }}" alt="">
                                        <h5>Documento</h5>
                                    </button>
                                </div>
                                <div class="col-md-4 pl-2">
                                    <button type="button" id="linkType" class="text-center digital-btn">
                                        <img src="{{ asset('assets/img/link-type.png') }}" alt="">
                                        <h5>Enlace</h5>
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 input-type-group" id="imageInput" style="display: none;">
                                    <div class="form-group">
                                        <input type="file" name="image_file" class="form-control" accept=".jpg, .jpeg, .png">
                                        <small>Formato admitidos: .jpeg, .jpg, .gif y .png</small>
                                    </div>
                                </div>

                                <div class="col-md-12 input-type-group" id="docInput" style="display: none;">
                                    <div class="form-group">
                                        <input type="file" name="doc_file" class="form-control">
                                        <small>Formato admitidos: .pdf, .doc, .pptx, .xlsx y .zip</small>
                                    </div>
                                </div>

                                <div class="col-md-12 input-type-group" id="linkInput" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="download_link" class="form-control" placeholder="URL (Dirección del enlace)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second -->
                <div class="col-md-4">
                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Estatus</h5>
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

                                @php
                                    $subcategories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', $product->category_id)->get();
                                @endphp

                                <div class="form-group mt-3">
                                    <label>Sub-Categorías</label>
                                    <select class="form-control select2" name="subcategory[]" id="subcategory" data-plugin="select2" multiple="">
                                        @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @endforeach
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

                                <div class="col-md-12">
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

                    <button type="submit" class="btn btn-lg pd-x-15 btn-primary btn-uppercase btn-block">
                        <i class="fas fa-save mr-1"></i> Guardar Producto
                    </button>
                </div>
            </div>
        @break

        @case('subscription')
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
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Descripción <span class="text-danger">*</span></label>
                                    <textarea name="description" cols="10" rows="3" class="form-control" required="">{{ $product->description }}</textarea>
                                    <small class="text-muted">Debe contener al menos 30 caracteres.</small>
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
                        </div>

                        <div class="card-body row">
                            <div class="col-md-12">
                                <div id="dropzoneForm" class="dropzone">
                                    <div class="dz-message" data-dz-message><span>
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 3em; margin-bottom:10px;"></i><br>
                                        Arrastra y suelta aqui tus archivos o da click para buscar
                                    </span></div>
                                </div>
                                <div align="center">
                                    <button type="button" class="btn btn-info" id="submit-all">Subir</button>
                                </div>
                                <hr>

                                <h5 class="mg-b-5">Imagenes Asociadas</h5>
                                <div id="uploaded_image">
          
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="link">Identificador del Video <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control video-input" name="video_background" value="{{ $product->video_link }}" />
        
                                <p class="mb-0 mt-2">Ejemplo:</p>
                                <p class="example-url">https://www.youtube.com/watch?v=<span class="video-identifier">SMKP21GW083c</span></p>
                            </div>
        
                            <style type="text/css">
                                .video-identifier{
                                    display: inline-block;
                                    padding: 3px 3px;
                                    border: 2px solid red;
                                }
        
                                .example-url{
                                    font-size: .8em;
                                }
                            </style>
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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="payment_frequency">Cantidad<span class="text-danger">*</span></label>
                                            <input type="number" id="pay_time" class="form-control" name="payment_frequency_qty" value="{{ $product->payment_frequency_qty }}" required>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="payment_frequency">Frecuencia de Pago <span class="text-danger">*</span></label>
                                            <select class="custom-select tx-13" id="pay_frequency" name="payment_frequency" required>
                                                <option value="weekly" {{ ($product->payment_frequency == 'weekly') ? 'selected' : '' }}>Semanal</option>
                                                <option value="monthly" {{ ($product->payment_frequency == 'monthly') ? 'selected' : '' }}>Mensual</option>
                                                <option id="annual" value="annual" {{ ($product->payment_frequency == 'annual') ? 'selected' : '' }}>Anual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <label for="payment_frequency">Tiempo para Cancelación<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="time_for_cancellation" value="{{ $product->time_for_cancellation }}" required>
                                            <small>Se calcula de acuerdo a la frecuencia de pago. Es decir, la suscripción se cancelará automáticamente en "X" meses a partir de la fecha de contración del cliente.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_price">Precio <span class="text-danger">*</span></label>
                                    <div class="input-group mg-b-10">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">MX$</span>
                                        </div>
                                        <input type="text" id="price" name="price" class="form-control" value="{{ $product->price }}" required="">
                                    </div>

                                    <div class="mt-4">
                                        <label for="discount_price">Precio en Descuento</label>
                                        <div class="input-group mg-b-10">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">MX$</span>
                                            </div>
                                            <input type="text" id="discount_price" name="discount_price" value="{{ $product->discount_price }}" class="form-control">
                                        </div>
                                    </div>

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
                    </div>

                    <!-- Inventory -->
                    <input type="hidden" name="stock" class="form-control" value="1">
                </div>

                <!-- Second -->
                <div class="col-md-4">
                    <div class="card mg-t-10 mb-4">
                        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                            <h5 class="mg-b-5">Estatus</h5>
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

                                @php
                                    $subcategories = Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', $product->category_id)->get();
                                @endphp

                                <div class="form-group mt-3">
                                    <label>Sub-Categorías</label>
                                    <select class="form-control select2" name="subcategory[]" id="subcategory" data-plugin="select2" multiple="">
                                        @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @endforeach
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

                                <div class="col-md-12">
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


                    <button type="submit" class="btn btn-lg pd-x-15 btn-primary btn-uppercase btn-block">
                        <i class="fas fa-save mr-1"></i> Guardar Producto
                    </button>
                </div>
            </div>
        @break
    @endswitch
</form>

<div class="row">
    <div class="col-md-8">
        @switch($product->type)
            @case('physical')
                @if($product->has_variants == true)
                    @include('wecommerce::back.products.partials._variant_card')
                @endif

                @include('wecommerce::back.products.partials._relationship_card')
            @break

            @case('digital')
                @include('wecommerce::back.products.partials._relationship_card')
            @break

            @case('subscription')
                @include('wecommerce::back.products.partials._characteristics_card')
                @include('wecommerce::back.products.partials._relationship_card')
            @break
        @endswitch

        @include('wecommerce::back.products.partials._links_card')

        <div class="card mg-t-10 mb-4">
            <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                <h6 class="mg-b-5">Histórico de este producto</h6>
                @php
                    $logs = Nowyouwerkn\WeCommerce\Models\Notification::where('type', 'Producto')->where('model_id', $product->id)->get();
                @endphp
            </div>

            @if($logs->count() != 0)
                @include('wecommerce::back.layouts.partials._notification_table')
            @else
            <div class="card-body">
                <h6 class="mb-0">No hay cambios en este producto todavía.</h6>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lib/spectrum-colorpicker/spectrum.js') }}"></script>

<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

<script type="text/javascript">
    function slugify(str){
        str = str.replace(/^\s+|\s+$/g, '');
        str = str.toLowerCase();

        var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
        var to   = "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') 
        .replace(/\s+/g, '-') 
        .replace(/-+/g, '-'); 

        return str;
    }

    var myDropzone = new Dropzone("#dropzoneForm", {
        url: "{{ route('dropzone.upload', $product->id) }}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        autoProcessQueue : false,
        parallelUploads: 20,
        acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
        autoDiscover:false,
        maxFilesize: 2,
        addRemoveLinks: true,
        init:function(){
            var submitButton = document.querySelector("#submit-all");
            myDropzone = this;

            submitButton.addEventListener('click', function(){
                myDropzone.processQueue();
            });

            this.on("complete", function(){
                if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                {
                var _this = this;
                _this.removeAllFiles();
                }
                load_images();
            });

        },
    });

    load_images();

    function load_images()
    {
        $.ajax({
            url:"{{ route('dropzone.fetch', $product->id) }}",
            success:function(data)
            {
                $('#uploaded_image').html(data);
            }
        })
    }

    $(document).on('click', '.remove_image', function(){
        var name = $(this).attr('id');
        $.ajax({
            url:"{{ route('dropzone.delete', $product->id) }}",
            data:{
                name : name
            },
            success:function(data){
                load_images();
            }
        })
    });

</script>

<script type="text/javascript">
    $('#colorpicker').spectrum({
      color: '#17A2B8'
    });
</script>

@if ($product->type == 'subscription')
    @if ($product->payment_frequency == 'annual')
        <script>
        $(document).ready(function () {
            if ($('#annual').prop('selected', true)) {
                $('#pay_time').attr("readonly", true);
            }
        });
    </script>
    @endif

    <script>
        $(document).ready(function(){

            $("#pay_frequency").change(function(){
            var values = $("#pay_frequency option:selected").text();

            if (values == 'Anual') {
                $('#pay_time').val(1);
                $('#pay_time').attr("readonly", true);
            } else{
                $('#pay_time').attr("readonly", false);
            }

            });
        });
    </script>
@endif


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
        $('#subcategory').append('<option value="0" disabled selected>Processing...</option>');

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

@switch($product->type)
    @case('physical')

    @break

    @case('digital')
        <script>
            $("#imageType").click(function() {
                $('.input-type-group').hide();
                $('.downloadable-btns button').removeClass('active');

                $('#imageInput').show();
                $(this).addClass('active');
            });

            $("#docType").click(function() {
                $('.input-type-group').hide();
                $('.downloadable-btns button').removeClass('active');

                $('#docInput').show();
                $(this).addClass('active');
            });

            $("#linkType").click(function() {
                $('.input-type-group').hide();
                $('.downloadable-btns button').removeClass('active');

                $('#linkInput').show();
                $(this).addClass('active');
            });
        </script>
    @break

    @case('subscription')
        <script>
            $(document).ready(function () {
                $('#char-new').hide();
            });

            $('#newCharacteristic').on('click', function(e){
                $('#char-new').fadeIn();
            });

            $('.btn-eliminate').on('click', function(e){
                $('#char-new').fadeOut();
            });

            $('.btn-save-2').click(function (e) {

                $('#char-u').submit();
            });
        </script>

    @break
@endswitch

<script>
    $(document).ready(function () {
        $('#link-new').hide();
    });

    $('#newLink').on('click', function(e){
        $('#link-new').fadeIn();
    });

    $('.btn-eliminate').on('click', function(e){
        $('#link-new').fadeOut();
    });

    $('.btn-save-2').click(function (e) {

        $('#link-u').submit();
    });
</script>
@endpush
