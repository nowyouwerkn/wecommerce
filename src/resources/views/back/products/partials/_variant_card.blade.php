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