@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">

<style type="text/css">
    .hidden{
        display: none;
    }

    .select2-container{
        display: block !important;
    }
</style>
@endpush

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promociones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Crear Promoción</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('promos.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>
@endsection

@section('content')
<form method="POST" action="{{ route('promos.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="card mg-t-10 mb-4">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Configuración de Promoción</h5>
                    <p class="tx-12 tx-color-03 mg-b-0">Determina un valor de descuento y selecciona los productos a los que quieres que aplique.</p>
                </div>

                <!-- Form -->
                <div class="card-body row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="value">Valor <span class="text-danger tx-12">*</span></label>
                            <input type="number" class="form-control" value="" name="value" placeholder="25">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="discount_type">Tipo <span class="text-danger tx-12">*</span></label>
                            <select class="form-control tx-13 select2" name="discount_type">
                                <option value="numeric" selected="">Valor numérico</option>
                                <option value="percentage">Porcentaje</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="tsearch_tagsags">Filtrar por <span class="text-danger tx-12">*</span></label>
                            <select id="filterBy" class="form-control tx-13 select2" name="filter_by">
                                <option value="all" selected="">Todos</option>
                                <option value="gender">Género</option>
                                <option value="brand">Marca</option>
                                <option value="category">Colecciones</option>
                            </select>
                        </div>
                    </div>

                    <div id="genderSelect" class="col-md-12" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="gender_id">Género <span class="text-danger">*</span></label>
                            <select class="form-control tx-13 select-search" name="gender_id">
                                <option value="unisex" selected="">Unisex</option>
                                    <option value="male">Hombres</option>
                                    <option value="female">Mujeres</option>
                            </select>
                        </div>
                    </div>

                    <div id="brandSelect" class="col-md-12" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="brand_id">Marca <span class="text-danger">*</span></label>
                            <select class="form-control tx-13 select-search" name="brand_id">
                                <option></option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="categorySelect" class="col-md-12" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="category_id">Colección <span class="text-danger">*</span></label>
                            <select id="firstLevelCategory" class="form-control tx-13 select-search category-select" data-level="first" name="category_id">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Sub-Categoría <span class="text-info tx-12">(Opcional)</span></label>
                            <select class="form-control tx-13 select-search category-select" name="subcategory" data-level="second" id="subcategory">

                            </select>
                        </div>
                    </div>

                    <hr>

                    <div id="productSelect" class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="product_id">Productos <span class="text-danger">*</span></label>
                            <select class="form-control tx-13 select-search" multiple name="product_id[]" required="">
                                <option></option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} | {{ $product->sku }}</option>
                                @endforeach
                            </select>
                            <small>Escribe en el campo el nombre o el SKU de tu producto para encontrarlo rápidamente.</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="condition">Estado: <span class="text-danger tx-12">*</span></label>
                                <select class="form-control tx-13 select2" name="is_active" required>
                                    <option value="1" selected="">Activado</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="condition">Activar hasta: <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-block p-3 btn-success btn-uppercase"><i class="far fa-save mr-2"></i> Guardar Promoción</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            placeholder: "Selecciona una opción...",
            allowClear: true
        });

        $('.select-search').select2({
            placeholder: 'Escoge una o varias opciones',
            minimumResultsForSearch: 5,
            searchInputPlaceholder: 'Busca por palabras clave',
            allowClear: true
        });
    });
</script>

<script>
    $('#filterBy').on('change', function(){
        event.preventDefault();

        var value = $('#filterBy').val();

        console.log(value);

        $('#genderSelect').hide();
        $('#brandSelect').hide();
        $('#categorySelect').hide();
        $('#productSelect').hide();

        switch(value){
            case 'all':
                $('#productSelect').fadeIn();
                break;

            case 'gender':
                $('#genderSelect').fadeIn();
                break;

            case 'brand':
                $('#brandSelect').fadeIn();
                break;

            case 'category':
                $('#categorySelect').fadeIn();
                break;

            default:
                $('#genderSelect').hide();
                $('#brandSelect').hide();
                $('#categorySelect').hide();
                $('#productSelect').hide();

                $('#productSelect select').empty();
                $('#subcategory').empty();
                $('#third_level').empty();

                break;
        }
    });

    /* Selector de Productos Prefiltrados */
    $('#genderSelect').on('change', function(){
        event.preventDefault();

        var value = $('#genderSelect select').val();

        $('#productSelect select').append('<option value="0" disabled selected>Procesando...</option>');

        $.ajax({
            method: 'POST',
            url: "{{ route('dynamic.promo.filter') }}",
            data:{
                value: value,
                type: 'gender',
                _token: '{{ Session::token() }}',
            },
            success: function(response){
                console.log(response);

                $('#productSelect').fadeIn();
                $('#productSelect select').empty();
                
                response.forEach(element => {
                    $('#productSelect select').append(`<option value="${element['id']}">${element['name']} | ${element['sku']}</option>`);
                });
            },
            error: function(response){
                //console.log(msg['mensaje']);
                $('.error-service').show();
            }
        });
    });

    $('#brandSelect').on('change', function(){
        event.preventDefault();

        var value = $('#brandSelect select').val();
        console.log(value);

        $('#productSelect select').append('<option value="0" disabled selected>Procesando...</option>');

        $.ajax({
            method: 'POST',
            url: "{{ route('dynamic.promo.filter') }}",
            data:{
                value: value,
                type: 'brand',
                _token: '{{ Session::token() }}',
            },
            success: function(response){
                console.log(response);
                $('#productSelect').fadeIn();
                $('#productSelect select').empty();
                
                response.forEach(element => {
                    $('#productSelect select').append(`<option value="${element['id']}">${element['name']} | ${element['sku']}</option>`);
                });
            },
            error: function(response){
                //console.log(msg['mensaje']);
                $('.error-service').show();
            }
        });
    });

    $('.category-select').on('change', function(){
        event.preventDefault();
        
        var value = $(this).val();
        var level = $(this).attr('data-level');

        console.log('Categoria ID: ' + value);
        console.log('Tipo: ' + level);

        $('#productSelect select').append('<option value="0" disabled selected>Procesando...</option>');

        $.ajax({
            method: 'POST',
            url: "{{ route('dynamic.promo.filter') }}",
            data:{
                value: value,
                type: 'category',
                level: level,
                _token: '{{ Session::token() }}',
            },
            success: function(response){
                console.log(response);
                $('#productSelect').fadeIn();
                $('#productSelect select').empty();
                
                response.forEach(element => {
                    $('#productSelect select').append(`<option value="${element['id']}">${element['name']} | ${element['sku']}</option>`);
                });
            },
            error: function(response){
                //console.log(msg['mensaje']);
                $('.error-service').show();
            }
        });
    });

    $('#firstLevelCategory').on('change', function(){
        event.preventDefault();

        var value = $('#firstLevelCategory').val();
        $('#subcategory').append('<option value="0" disabled selected>Procesando...</option>');

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
                $('#third_level').empty();
                $('#subcategory').append(`<option value="0" disabled selected>Selecciona una opción</option>`);
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
    /*
    $('#subcategory').on('change', function(){
        event.preventDefault();

        var value = $('#subcategory').val();
        $('#third_level').append('<option value="0" disabled selected>Procesando...</option>');
        console.log('Solicitando tercer nivel..');

        $.ajax({
            method: 'POST',
            url: "{{ route('dynamic.subcategory') }}",
            data:{
                value:value,
                _token: '{{ Session::token() }}',
            },
            success: function(response){
                console.log(response);
                $('#third_level').empty();
                $('#third_level').append(`<option value="0" disabled selected>Selecciona una opción</option>`);
                response.forEach(element => {
                    $('#third_level').append(`<option value="${element['id']}">${element['name']}</option>`);
                });
            },
            error: function(response){
                $('.error-service').show();
            }
        });
    });
    */
</script>
@endpush