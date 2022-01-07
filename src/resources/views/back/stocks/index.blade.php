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
            border: solid 1px;
            background-color: transparent;
            color: lightgrey ;
        }
    </style>
@endsection

@section('content')
    <div class="">
             <form role="search" action="{{ route('stocks.query') }}">
                <div class="input-group border-0">
                    <input type="search" name="query" class="form-control" placeholder="Busca tu producto">
                    <button class="btn btn-outline-secondary" type="submit">
                       <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <div>
                <a href="{{ route('inventory.clients') }}" class="btn btn-outline-primary">Exportar movimientos de inventario</a>
            </div>
    </div>
@if($products->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_1.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Administra tu Inventario</h4>
        <p class="mb-4">Para poder administrar tus existencias debes tener productos creados. Comienza con el botón de abajo.</p>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Nuevo Producto</a>
    </div>
@else

<div class="row">

    
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
                                    <div class="d-flex">
                                        SKU / UPC 
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="sku">
                                        <input type="hidden" name="order" value="asc">
                                        <button class="filter-btn"  type="submit">&#8613;</button>
                                    </form>
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="sku">
                                        <input type="hidden" name="order" value="desc">
                                        <button class="filter-btn"  type="submit">&#8615;</button>
                                    </form>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex">
                                           Producto 
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="name">
                                        <input type="hidden" name="order" value="asc">
                                        <button class="filter-btn"  type="submit">&#8613;</button>
                                    </form>
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="name">
                                        <input type="hidden" name="order" value="desc">
                                        <button class="filter-btn"  type="submit">&#8615;</button>
                                    </form>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex">
                                           Precio 
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="price">
                                        <input type="hidden" name="order" value="asc">
                                        <button class="filter-btn"  type="submit">&#8613;</button>
                                    </form>
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="price">
                                        <input type="hidden" name="order" value="desc">
                                        <button class="filter-btn"  type="submit">&#8615;</button>
                                    </form>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex">
                                           Disponibilidad
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="stock">
                                        <input type="hidden" name="order" value="asc">
                                        <button class="filter-btn" type="submit">&#8613;</button>
                                    </form>
                                    <form action="{{route('stocks.filter')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="filter" value="stock">
                                        <input type="hidden" name="order" value="desc">
                                        <button class="filter-btn"  type="submit">&#8615;</button>
                                    </form>
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
                                <td></td>
                                @else
                                <td>
                                    <input type="number" name="stock_variant" class="form-control variant-form-control" value="{{ $product->stock }}" id="productStockVariant{{ $product->id }}" style="width:80px;">
                                </td>
                                    <td>
                                      {{$product->stock * $product->price}}
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

                                        <td>
                                            <input type="number" name="stock_variant" class="form-control variant-form-control" value="{{ $variant->stock }}" id="stockVariant{{ $variant->id }}" style="width:80px;">
                                        </td>
                                        <td>
                                            {{$variant->stock * $variant->price}}
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
</script>  
@endpush