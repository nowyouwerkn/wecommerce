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
            <h4 class="mg-b-0 tx-spacing--1">Gestión de Inventario</h4>
        </div>

        <div class="d-none d-flex align-items-center">
            <form role="search" action="{{ route('stocks.query') }}" class="search-form mr-3">
                <input type="search"  name="query" class="form-control" style="height: calc(1.5em + 0.9375rem - 2px);" placeholder="Buscar por nombre, SKU...">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>

            <div class="dropdown">
                <button class="btn pd-x-15 btn-white btn-uppercase dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-export"></i> Exportar Movimientos
                </button>
                <div class="dropdown-menu mr-5" aria-labelledby="dropdownMenuButton">
                    <form class="form-horizontal px-4 py-4">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mb-0 text-uppercase text-info">Rango:</p>
                                <hr class="mt-1">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="filter">Inicio <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="event_date_start">
                                        </div>
                                    </div>
        
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="filter">Final <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="event_date_end">
                                        </div>
                                    </div>
        
                                    <div class="col-md-12 mb-3">
                                        <small>Horario de Inicio 00:00 / Horario Final 23:59</small>
                                    </div>
                                </div>  
                            </div>
        
                            <div class="col-md-12 text-right mt-3">
                                <input type="submit" class="btn btn-success" formaction="{{ route('inventory.clients') }}" value="Descargar Reporte Excel"/>

                                <!--<button type="submit" class="btn btn-primary"><i class="far fa-copy"></i> Generar Reporte</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{--  
            <a href="{{ route('inventory.clients') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                <i class="fas fa-file-export"></i> Exportar Movimientos
            </a>
            --}}
        </div>
    </div>

    <style type="text/css">
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
    <!-- KPI's Generales -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-body p-3" style="background-color: #f1f5f7;">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="text-uppercase mb-0" style="font-size: .7rem;">Cantidad de piezas en inventario</h6>
                    <h5 class="mb-0" style="font-size: 1rem;">{{ number_format($size_total) }}</h5>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-body p-3" style="background-color: #f1f5f7;">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="text-uppercase mb-0" style="font-size: .7rem;">Valor total del inventario</h6>
                    <h5 class="mb-0" style="font-size: 1rem;">$ {{ number_format($inventory_value, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dashboard mg-b-0">
                        <thead>
                            <tr>
                                <th>Variantes</th>
                                <th>Imagen</th>
                                <th>       
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">SKU / UPC</span>
                                        <a class="filter-btn" href="{{route('filter.stock', ['asc', 'sku'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.stock', ['desc', 'sku'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Producto</span>
                                        <a class="filter-btn" href="{{route('filter.stock', ['asc', 'name'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.stock', ['desc', 'name'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Precio </span>
                                        <a class="filter-btn" href="{{route('filter.stock', ['asc', 'price'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.stock', ['desc', 'price'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Disponibilidad</span>
                                        <a class="filter-btn" href="{{route('filter.stock', ['asc', 'stock'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.stock', ['desc', 'stock'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>
                                <th>Total de valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($products as $product)
                            <tr class="parent" id="row{{ $product->id }}" title="Click to expand/collapse" style="cursor: pointer; position: relative;">
                                <td style="width:50px;">
                                    @if($product->has_variants == true)
                                    <span class="circle-icon bg-success text-white"><i class="fas fa-plus-circle"></i></span>
                                    <span style="font-weight: bold; font-size:1.2em;">{{ $product->variants->count() }}</span>
                                    @endif

                                    <span id="success-update-p{{ $product->id }}" class="success-update"><i class="fas fa-check mr-2"></i> Actualización exitosa </span>

                                    <span id="error-update-p{{ $product->id }}" class="error-update"><i class="fas fa-times mr-2"></i> Problema de datos. Inicia sesión nuevamente o refresca la pantalla. </span>
                                </td>
                                <td class="tx-color-03 tx-normal image-table td-tight">
                                    <img style="width: 100%; height: 100px;" src="{{ asset('img/products/' . $product->image ) }}" alt="{{ $product->name }}">
                                    <div class="text-center margin-top-10">
                                        <small><p>+ {{ $product->images->count() }} Imágen(es)</p></small>    
                                    </div>
                                </td>
                                <td style="width:160px;">
                                    {{ $product->sku }}
                                </td>
                                <td>
                                    <strong><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></strong> <br><p style="width: 200px; white-space: initial;">{{ substr($product->description, 0, 100)}} {{ strlen($product->description) > 100 ? "[...]" : "" }}</p>
                                </td>
                                
                                <td>
                                    @if($product->has_discount == true)
                                    $ {{ number_format($product->discount_price,2) }} <br>
                                    <span class="price-discounted">${{ number_format($product->price, 2) }}</span>
                                    @else
                                    $ {{ number_format($product->price,2) }}
                                    @endif
                                </td>

                                @if($product->has_variants == true)
                                <td>
                                    @php
                                        $total_qty = 0;

                                        foreach ($product->variants_stock as $v_stock) {
                                            $total_qty += $v_stock->stock;
                                        };

                                        $total_qty;
                                    @endphp
                                    {{ $total_qty }}
                                </td>
                                <td>
                                    @php
                                        $total_value = 0;

                                        foreach ($product->variants_stock as $v_price) {
                                            $total_value += ($v_price->stock * $v_price->new_price);
                                        };

                                        $total_value;
                                    @endphp
                                    ${{ number_format($total_value, 2) }}
                                </td>
                                <td></td>
                                @else
                                <td class="stock-incrementer">
                                    <div class="d-flex align-items-center">
                                        <a class="btn-stock stock-minus" href="javascript:void(0)">
                                            -
                                        </a>
                                        <span class="value">
                                            {{ $product->stock }}
                                        </span>
                                        <a class="btn-stock stock-plus" href="javascript:void(0)">
                                            +
                                        </a>

                                        <input type="hidden" name="stock_variant" class="variant-form-control" value="{{ $product->stock }}" id="productStockVariant{{ $product->id }}">
                                    </div>
                                </td>

                                <td>
                                    ${{ number_format($product->stock * $product->price, 2) }}
                                </td>

                                <td>
                                    <button id="productUpdateForm{{ $product->id }}" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5">
                                        <i class="fas fa-sync mr-1" aria-hidden="true"></i> Actualizar
                                    </button>

                                    {{-- 
                                    <button type="button" id="deleteVariant_{{ $product->id }}" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5">
                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                    </button>
                                    --}}

                                    @push('scripts')
                                    <form method="POST" id="deleteVariantForm_{{ $product->id }}" action="{{ route('stock.destroy', $product->id) }}" style="display: inline-block;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>

                                    <script type="text/javascript">
                                        $('#productUpdateForm{{ $product->id }}').on('click', function(){
                                            event.preventDefault();

                                            $.ajax({
                                                method: 'POST',
                                                url: "{{ route('product.stock.update', $product->id) }}",
                                                data:{
                                                    stock_variant: $('#productStockVariant{{ $product->id }}').val(),
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

                                        $('#deleteVariant_{{ $product->id }}').on('click', function(){
                                            event.preventDefault();
                                            $('#deleteVariantForm_{{ $product->id }}').submit();
                                        });
                                    </script>
                                    @endpush
                                </td>
                                @endif
                            </tr>
                                @foreach($product->variants_stock as $variant)
                                <tr class="bg-light child-row child-row{{ $product->id }}" style="display: none;">
                                    <form method="POST" id="form{{ $variant->id }}" action="{{ route('stock.update', $variant->id) }}" style="display: inline-block;">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <td style="width:50px;" class="tx-color-03 tx-normal image-table">
                                            <span id="success-update{{ $variant->id }}" class="success-update"><i class="fas fa-check mr-2"></i> Actualización exitosa </span>

                                            <span id="error-update{{ $variant->id }}" class="error-update"><i class="fas fa-times mr-2"></i> Problema de datos. Inicia sesión nuevamente o refresca la pantalla. </span>
                                        </td>

                                        <td>
                                            
                                        </td>
                                        <td>
                                            <input type="text" name="sku_variant" class="form-control variant-form-control" value="{{ $variant->sku }}" id="skuVariant{{ $variant->id }}" style="width: 150px;">
                                        </td>
                                        <td><strong>{{ $variant->variants->value }}</strong> <br><p>{{ $variant->variants->type ?? 'Talla'}}</p></td>
                                        <td>
                                            <div class="input-group" style="min-width: 80px;">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1" style="height:36px">$</span>
                                                 </div>
                                            
                                                @if($variant->new_price == NULL)
                                                <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $product->price }}" id="priceVariant{{ $variant->id }}" style="width:50px;">
                                                @else
                                                <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $variant->new_price }}" id="priceVariant{{ $variant->id }}" style="width:50px;">
                                                @endif
                                            </div>
                                        </td>

                                        <td class="stock-incrementer">

                                            <div class="d-flex align-items-center">
                                                <a class="btn-stock stock-minus" href="javascript:void(0)">
                                                    -
                                                </a>
                                                <span class="value">
                                                    {{ $variant->stock }}
                                                </span>
                                                <a class="btn-stock stock-plus" href="javascript:void(0)">
                                                    +
                                                </a>

                                                <input type="hidden" name="stock_variant" class="variant-form-control" value="{{ $variant->stock }}" id="stockVariant{{ $variant->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            ${{ number_format($variant->stock * $variant->new_price, 2) }}
                                        </td>
                                        <td>
                                            <button id="updateForm{{ $variant->id }}" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5">
                                                <i class="fas fa-sync mr-1" aria-hidden="true"></i> Actualizar
                                            </button>

                                            <button type="button" id="deleteVariant_{{ $variant->id }}" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5">
                                                <i class="fas fa-trash" aria-hidden="true"></i>
                                            </button>

                                            @push('scripts')
                                            <form method="POST" id="deleteVariantForm_{{ $variant->id }}" action="{{ route('stock.destroy', $variant->id) }}" style="display: inline-block;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>

                                            <script type="text/javascript">
                                                $('#updateForm{{ $variant->id }}').on('click', function(){
                                                    event.preventDefault();

                                                    $.ajax({
                                                        method: 'POST',
                                                        url: "{{ route('stock.update', $variant->id) }}",
                                                        data:{
                                                            sku_variant: $('#skuVariant{{ $variant->id }}').val(),
                                                            price_variant: $('#priceVariant{{ $variant->id }}').val(),
                                                            stock_variant: $('#stockVariant{{ $variant->id }}').val(),
                                                            _method: "PUT",
                                                            _token: "{{ Session::token() }}", 
                                                        },
                                                        success: function(msg){
                                                            console.log(msg['mensaje']);

                                                            $('#success-update{{ $variant->id }}').fadeIn();

                                                            setTimeout(function () {
                                                                $('#success-update{{ $variant->id }}').fadeOut();
                                                            }, 500);
                                                        },
                                                        error: function(msg){
                                                            $('#error-update{{ $variant->id }}').fadeIn();

                                                            console.log(msg);        
                                                        }
                                                    });
                                                });

                                                $('#deleteVariant_{{ $variant->id }}').on('click', function(){
                                                    event.preventDefault();
                                                    $('#deleteVariantForm_{{ $variant->id }}').submit();
                                                });
                                            </script>

                                            @endpush
                                        </td>
                                    </form>
                                </tr>
                                @endforeach
                            @endforeach

                            @php
                                $size_total = 0;

                                foreach ($products as $pr) {
                                    if($pr->variants_stock->count() == 0){
                                        $size_total += $pr->stock;
                                    }else{
                                        foreach($pr->variants_stock as $sz){
                                            $size_total += $sz->stock;
                                        }
                                    }  
                                };

                                $size_total;
                            @endphp

                            <tr style="background-color: #f1f5f7; color: #323a46;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total Stock</strong></td>
                                <td>{{ $size_total }}</td>
                                <td></td>
                                <td></td>
                            </tr>

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

@push('scripts')
<script type="text/javascript">  
    $(document).ready(function () {  
        $('tr.parent')  
            .css("cursor", "pointer")  
            .attr("title", "Da click para expandir/cerrar las variantes")  
            .click(function () {  
                $(this).siblings('.child-' + this.id).toggle("fast");  
            });  

        //$('tr[@class^=child-]').hide().children('td');  
    });  

    $('.stock-incrementer .stock-minus').on('click', function(e){
        var value = parseInt($(this).siblings('.value').text());

        if (value == 0) return;
        
        value--;
        
        $(this).siblings('.variant-form-control').val(value);
        $(this).siblings('.value').text(value);
    });

    $('.stock-incrementer .stock-plus').on('click', function(e){
        var value = parseInt($(this).siblings('.value').text());

        value++;

        $(this).siblings('.variant-form-control').val(value);
        $(this).siblings('.value').text(value);
    });
</script>  
@endpush