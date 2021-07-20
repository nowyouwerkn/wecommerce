@push('stylesheets')
	<style type="text/css">
		.size-box{
			display: inline-block;
			padding: 5px 10px;
			padding-right: 15px;
			padding-top: 7px;
			color: #fff;
			position: relative;
			border-radius: 5px;
		}

		.size-box span{
			position: absolute;
			top: -4px;
			right: -10px;
			background-color: red;
			color: #fff;
			font-size: .8em;
			width: 20px;
			height: 20px;
			border-radius: 100%;
			text-align: center;
			line-height: 20px;
		}

		.variant-form-control{
			width: 100px;
			text-align: center;
			margin-left: auto;
		}
	</style>
@endpush

<div class="card mg-t-10 mb-4">
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Variantes</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Puedes crear variantes para tus productos.</p>
    </div>

    <!-- Form -->
    <div id="btnContainer" class="card-body row">
        <div class="col-md-12">
        	<a href="javascript:void(0)" id="hasVariants"class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Agregar Variantes
           	</a>

           	<!--
            <div class="custom-control custom-checkbox" >
                <input type="checkbox" class="custom-control-input" id="variants">
                <label class="custom-control-label" for="variants">Este producto tiene variantes</label>
            </div>
        	-->
        </div>
    </div>

    <!-- Variant Header -->
    <div id="collapsedVariants" class="table-responsive hidden mt-3 mb-4">
    	<form method="POST" action="{{ route('stock.store', $product->id ?? '0') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
	        <table class="table table-dashboard mg-b-0">
	            <thead>
	                <tr>
	                    <th>Tipo</th>
	                    <th class="text-right">Valor</th>
	                    <th class="text-right">Precio</th>
	                    <th class="text-right">Cantidad</th>
	                    <th class="text-right">Codigo SKU</th>
	                </tr>
	            </thead>
	            <tbody>
	                <tr>
	                    <td class="tx-color-03 tx-normal">
	                    	<select name="type_id" id="type" class="form-control">
	                            <option value="Talla">Talla</option>
	                            <option value="Color">Color</option>
	                            <option value="Material">Material</option>
	                            <option value="Estilo">Estilo</option>
	                            <option value="Nombre">Nombre</option>
	                        </select>  
	                    </td>
	                    <td class="text-right">
	                        <input type="text" name="variant" id="variant" class="form-control">
	                    </td>
	                    <td class="text-right">
	                        <input type="number" name="price_variant" id="price_variant" class="form-control">
	                    </td>
	                    <td class="text-right">
	                        <input type="number" name="stock_variant" id="stock_variant" class="form-control">
	                    </td>
	                    <td class="text-right">
	                        <input type="text" name="sku_variant" id="sku_variant" class="form-control">
	                    </td>
	                </tr>
	            </tbody>
	        </table>

	        <div class="col-md-12 my-3">
	            <button type="submit" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
	                Guardar Variante
	           	</button>
	        </div>
	    </form>
    </div>

	@if($product->variants->count() != 0)
	<table class="table table-dashboard mg-b-0">
        <thead>
            <tr>
                <th>Tipo</th>
                <th class="text-right">Valor</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Codigo SKU</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($variant_stock as $variant)
            <form method="POST" action="{{ route('stock.update', $variant->id) }}" style="display: inline-block;">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
            
	            <tr>
	                <td>{{ $variant->variants->type ?? 'Talla'}}</td>
	                <td class="text-right">{{ $variant->variants->value }}</td>
	                <td class="text-right">
	                    @if($variant->new_price == NULL)
	                    <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $product->price }}">
	                    @else
	                    <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $variant->new_price }}">
	                    @endif
	                </td>
	                <td class="text-right">
	                	<input type="number" name="stock_variant" class="form-control variant-form-control" value="{{ $variant->stock }}">
	                </td>
	                <td class="text-right">{{ $variant->sku }}</td>

	                <td class="text-nowrap text-right">
	                	<button type="submit" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5">
	                        <i class="fas fa-sync mr-1" aria-hidden="true"></i> Actualizar
	                    </button>

	                    {{-- 
	                    <form method="POST" action="{{ route('stock.destroy', $variant->id) }}" style="display: inline-block;">
	                        <button type="submit" class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="tooltip" data-original-title="Borrar">
	                            <i class="fas fa-trash" aria-hidden="true"></i>
	                        </button>
	                        {{ csrf_field() }}
	                        {{ method_field('DELETE') }}
	                    </form>
	                    --}}
	                </td>
	            </tr>
            </form>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="text-center my-5">
            <h4 class="mb-0">¡No has determinado variantes para este producto!</h4>
            <p>¡Si no hay existencias de tu producto se mostrará en el catálogo pero no podrán comprarlo!</p>
        </div>
    @endif
</div>

				
@push('scripts')
<script type="text/javascript">
	$('#hasVariants').on('click', function(){
		event.preventDefault();
		$('#collapsedVariants').removeClass('hidden');
		$('#btnContainer').hide();
		$(this).toggle();
	});

	$('#variant').keyup(function(){
        event.preventDefault();

        var sku = $('input[name=sku]').val();
        var price = $('input[name=price]').val();
        var stock = $('input[name=stock]').val();

        $('#sku_variant').val(sku  + '01');
        $('#price_variant').val(price);
        $('#stock_variant').val(stock);
    });
</script>
@endpush

{{--
<!-- Variants -->
<div class="card mg-t-10 mb-4">
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Variantes</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Puedes crear variantes para tus productos.</p>
    </div>

    <!-- Form -->
    <div class="card-body row">
        <div class="col-md-12">
        	<a href="javascript:void(0)" id="hasVariants"class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Agregar Variantes
           	</a>

           	<!--
            <div class="custom-control custom-checkbox" >
                <input type="checkbox" class="custom-control-input" id="variants">
                <label class="custom-control-label" for="variants">Este producto tiene variantes</label>
            </div>
        	-->
        </div>
    </div>

    <div class="card-body pt-0">
		<style type="text/css">
			.size-box{
				display: inline-block;
				padding: 5px 10px;
				padding-right: 15px;
				padding-top: 7px;
				color: #fff;
				position: relative;
				border-radius: 5px;
			}

			.size-box span{
				position: absolute;
				top: -4px;
				right: -10px;
				background-color: red;
				color: #fff;
				font-size: .8em;
				width: 20px;
				height: 20px;
				border-radius: 100%;
				text-align: center;
				line-height: 20px;
			}
		</style>

		<div id="size-wrapper" class="d-flex align-items-center justify-content-start">
			<!--
			<div class="size-box bg-primary">
				<span>x</span>
				<p class="mb-0">24</p>
			</div>
			-->
		</div>
	</div>

    <!-- Variant Header -->
    <div id="collapsedVariants" class="table-responsive hidden">
        <table class="table table-dashboard mg-b-0">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Codigo SKU</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tx-color-03 tx-normal">
                    	<select name="type_id" id="type" class="form-control">
                            <option value="Talla">Talla</option>
                            <option value="Color">Color</option>
                            <option value="Material">Material</option>
                            <option value="Estilo">Estilo</option>
                            <option value="Nombre">Nombre</option>
                        </select>  
                    </td>
                    <td class="text-right">
                        <input type="text" name="variant" id="variant" class="form-control">
                    </td>
                    <td class="text-right">
                        <input type="number" name="price_variant" id="price_variant" class="form-control">
                    </td>
                    <td class="text-right">
                        <input type="number" name="stock_variant" id="stock_variant" class="form-control">
                    </td>
                    <td class="text-right">
                        <input type="text" name="sku_variant" id="sku_variant" class="form-control">
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="col-md-12 my-3">
            <a href="javascript:void(0)" id="saveVariant" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Guardar Variante
           	</a>
        </div>
    </div>
</div>

@php
	$product = \Nowyouwerkn\WeCommerce\Models\Product::orderBy('created_at', 'desc')->first();

	if(empty($product)){
		$product_id = 1;
	}else{
		$product_id = $product->id+1;
	}
@endphp

<input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">

@push('scripts')
<script type="text/javascript">
	$('#hasVariants').on('click', function(){
		event.preventDefault();
		$('#collapsedVariants').removeClass('hidden');

		$(this).toggle();

		$.ajax({
			method: 'POST',
	        url: "{{ route('products.store.dynamic') }}",
	        data:{ 
	        	name:$('input[name=name]').val(),
	        	description:$('textarea[name=description]').val(),
	        	price:$('input[name=price]').val(),
	        	status: 'Borrador',
	        	_token: '{{ Session::token() }}'
	        },
	        success: function(response){
	            console.log(response['mensaje']);

	            $('#product_id').val(response['product_id']);

	            $('.success-save').show();
	        },
	        error: function(response){
	            console.log(response['mensaje']);

	            $('.error-save').show();
	        }
		});
	});

	$('#variant').keyup(function(){
        event.preventDefault();

        var sku = $('input[name=sku]').val();
        var price = $('input[name=price]').val();
        var stock = $('input[name=stock]').val();

        $('#sku_variant').val(sku  + '01');
        $('#price_variant').val(price);
        $('#stock_variant').val(stock);
    });

	$('#saveVariant').on('click', function(){
		event.preventDefault();
		$(this).prop('disabled', true);

		$.ajax({
			method: 'POST',
	        url: "{{ route('stock.store.dynamic') }}",
	        data:{ 
	        	product_id:$('#product_id').val(),
	        	type:$('#type').val(),
	        	variant:$('#variant').val(),
	        	stock:$('#stock_variant').val(),
	        	price:$('#price_variant').val(),
	        	sku:$('#sku_variant').val(),
	        	_token: '{{ Session::token() }}'
	        },
	        success: function(response){
	            console.log(response['mensaje']);

	            $(this).prop('disabled', false);

	            ('#size-wrapper').append("<div class='size-box bg-primary'><span>x</span><p class='mb-0'>" + response['deposit'] + "</p></div>");

	            $('.success-variant').show();
	        },
	        error: function(response){
	            console.log(response['mensaje']);

	            $(this).prop('disabled', false);
	            $('.error-variant').show();
	        }
		});
	});
</script>
@endpush
--}}