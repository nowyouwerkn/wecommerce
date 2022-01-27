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

<div class="card mg-t-10 mb-4" id="variantCard">
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Variantes</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Puedes crear variantes para tus productos para determinar la talla, estilo o un nombre en específico.</p>
    </div>

    <!-- Form -->
    <div id="btnContainer" class="card-body row">
        <div class="col-md-12">
        	<a href="javascript:void(0)" id="openVariants"class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Agregar Variantes
           	</a>
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

    <hr>
    <!-- Header -->
    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
        <h5 class="mg-b-5">Relaciones</h5>
        <p class="tx-12 tx-color-03 mg-b-0">Se pueden relacionar otros productos para tener múltiples opciones de tipo "Color" o "Material".</p>

        {{--
        @if(!empty($base_product))
            @if($base_product->id != $product->id)
            <a href="{{ route('products.show', $base_product->id) }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">Ir al producto base</a>
            @endif
            @else
            <a href="javascript:void(0)" data-target="#modalAddRelationship" data-toggle="modal" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><span class="fas fa-plus"></span> Agregar más relaciones</a>
        @endif
        --}}
    </div>

    <!-- Form -->
    <div id="btnContainerRelationships" class="card-body row">
        <div class="col-md-12">
        	<a href="javascript:void(0)" id="openRelationships" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Agregar Relaciones
           	</a>
        </div>
    </div>

    <!-- Variant Header -->
    <div id="collapsedRelationships" class="table-responsive hidden mt-3 mb-4">
    	<form method="POST" action="{{ route('relationship.store', $product->id ?? '0') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

	        <table class="table table-dashboard mg-b-0">
	            <thead>
	                <tr>
	                    <th>Tipo</th>
	                    <th class="text-right">Producto a relacionar</th>
	                    <th class="text-right">Valor / Nombre</th>
	                </tr>
	            </thead>
	            <tbody>
	                <tr>
	                    <td class="tx-color-03 tx-normal">
	                    	<select name="type" id="relationshipType" class="form-control">
	                            <option value="Color">Color</option>
	                            <option value="Material">Material</option>
	                        </select>  
	                    </td>

	                    <td class="text-right">
	                        <select class="form-control" name="product_id" id="productRelationshipId">
	                        	<option>Selecciona una opción</option>
		                        @foreach($related_products as $related)
		                        	<option value="{{ $related->id }}">{{ $related->name }}</option>
		                        @endforeach
		                    </select>
	                    </td>

	                    <td class="text-right">
	                        <input type="text" name="value" id="relationship_value" class="form-control">
	                    </td>
	                </tr>
	            </tbody>
	        </table>

	        <div class="col-md-12 my-3">
	            <button type="submit" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
	                Guardar Relación
	           	</button>
	        </div>
	    </form>
    </div>

    <div class="card-body">
    @if($product_relationships->count() != 0)
    	<div class="row">
	        @foreach($product_relationships as $rs_variant)
	        <div class="col-md-4">
	        	<div class="card">
	        		<img  class="img-fluid" src="{{ asset('img/products/' . $rs_variant->product->image ) }}">

	        		<div class="card-body">
	        			<h6 class="mb-2"><a href="{{ route('products.show', $rs_variant->product->id) }}">{{ $rs_variant->product->name }}</a></h6>
	        			<div class="d-flex align-items-center">
	        				<span class="badge badge-info mr-2">Valor: {{ $rs_variant->value }}</span>
	        				<span class="badge badge-secondary">Tipo: {{ $rs_variant->type }}</span>
	        			</div>
	        		</div>
	        	</div>
        	</div>
	        @endforeach
        </div>
	    @else
	        <div class="text-center my-2">
	            <h6>Este producto no está relacionado a ningún otro.</h6>
	        </div>
	    @endif
    </div>
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

		$('#openRelationships').on('click', function(){
			event.preventDefault();
			$('#collapsedRelationships').removeClass('hidden');
			$('#btnContainerRelationships').hide();
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

	    $('#productRelationshipId').on('change', function(){
			$('#relationship_value').val('Procesando...');

			$.ajax({
				method: 'POST',
	            url: "{{ route('fetch.color') }}",
	            data:{ 
	            	value: $('#productRelationshipId').val(),
	            	type: $('#relationshipType').val(), 
	            	_token: '{{ Session::token() }}', 
	            },
	            success: function(response){
		            console.log(response['product_color']);
		            $('#relationship_value').val(response['product_color']);
		        },
		        error: function(response){
	                $('.error-service').show();
		        }
			});
		});
	</script>
@endpush


@if(!empty($base_relationship))
<div class="modal fade" id="modalAddRelationship" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCreateLabel">Agregar producto a relacion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="base_product_id" value="{{ $product->id }}">
                <input type="hidden" name="type" value="{{ $base_relationship->type }}">
                <div class="form-group">
                    <label for="type">Tipo de relación</label>
                        <h5>{{$base_relationship->type}}</h5>
                </div>
                <div class="form-group">
                    <label for="value">Valor de la relación</label>
                    <input type="text" name="value" class="form-control">
                </div>
                <div class="form-group">
                    <label>Producto para agregar a la relación</label>
                    <select class="form-control" name="product_id" id="productRelationshipId">
                        @foreach($related_products as $related)
                        <option value="{{ $related->id }}">{{ $related->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Relacion</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@else
<div class="modal fade" id="modalAddRelationship" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCreateLabel">Crear una nueva relacion de producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="base_product_id" value="{{ $product->id }}">

                <div class="form-group">
                    <label>Tipo de relación</label>
                    <select class="form-control" name="type">
                        <option value="color">Color</option>
                        <option value="material">Material</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="value">Valor de la relación</label>
                    <input type="text" name="value" class="form-control">
                </div>
                <div class="form-group">
                    <label for="model_image">Producto inicial de la relacion</label>
                    <select class="form-control" name="product_id">
                        @foreach($related_products as $related)
                        <option value="{{$related->id}}">{{$related->name}}</option>
                        @endforeach
                    </select>
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
@endif