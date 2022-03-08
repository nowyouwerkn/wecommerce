@push('stylesheets')
	<style>
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

<div class="card mg-t-10 mb-4" id="variantCard">
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Variantes</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Puedes crear variantes para tus productos para determinar la talla, estilo o un nombre en específico.</p>
    </div>

    <!-- Form -->
    <div id="btnContainer" class="card-body row">
        <div class="col-md-12">
        	<a href="javascript:void(0)" id="openVariants" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Agregar Variantes
           	</a>
        </div>
    </div>

    <!-- Variant Header -->
    <div id="collapsedVariants" class="table-responsive hidden mt-3 mb-4">
    	<form method="POST" id="variantForm" action="{{ route('stock.store', $product->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}

	        <table class="table table-dashboard mg-b-0">
	            <thead>
	                <tr>
	                    <th>Tipo</th>
	                    <th class="text-right">Valor</th>
	                    <th class="text-right">Precio</th>
	                    <th class="text-right">Cantidad</th>
	                    <th class="text-right">Código SKU</th>
	                </tr>
	            </thead>
	            <tbody>
	                <tr>
	                    <td class="tx-color-03 tx-normal">
	                    	<select name="type_id" id="type" class="form-control">
	                            <option value="Talla">Talla</option>
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
	            <button type="button" id="saveVariant" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
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
	                <th class="text-right">Código SKU</th>
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
		                	<div class="input-group" style="min-width: 80px;">
		                		<div class="input-group-prepend">
								    <span class="input-group-text" id="basic-addon1" style="height:36px">$</span>
								 </div>
			                
			                    @if($variant->new_price == NULL)
			                    <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $product->price }}" style="width:50px;">
			                    @else
			                    <input type="text" name="price_variant" class="form-control variant-form-control" value="{{ $variant->new_price }}" style="width:50px;">
			                    @endif
		                    </div>
		                </td>
		                <td class="text-right">
		                	<input type="number" name="stock_variant" class="form-control variant-form-control" value="{{ $variant->stock }}" style="width:80px;">
		                </td>
		                <td class="text-right">
		                	<input type="text" name="sku_variant" class="form-control variant-form-control" value="{{ $variant->sku }}">
		                </td>

		                <td class="text-nowrap text-right">
		                	<button type="submit" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5">
		                        <i class="fas fa-sync mr-1" aria-hidden="true"></i> Actualizar
		                    </button>

		                    <button type="button" id="deleteVariant_{{ $variant->id }}" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5">
		                        <i class="fas fa-trash" aria-hidden="true"></i>
		                    </button>
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
	@foreach($variant_stock as $variant)
		<form method="POST" id="deleteVariantForm_{{ $variant->id }}" action="{{ route('stock.destroy', $variant->id) }}" style="display: inline-block;">
		    {{ csrf_field() }}
		    {{ method_field('DELETE') }}
		</form>

		<script type="text/javascript">
			$('#deleteVariant_{{ $variant->id }}').on('click', function(){
				event.preventDefault();
				$('#deleteVariantForm_{{ $variant->id }}').submit();
			});
		</script>
	@endforeach

	<script type="text/javascript">
		$('#openVariants').on('click', function(){
			event.preventDefault();
			$('#collapsedVariants').removeClass('hidden');
			$('#btnContainer').hide();
			$(this).toggle();
		});

		$('#saveVariant').on('click', function(){
			event.preventDefault();
			$('#variantForm').submit();
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