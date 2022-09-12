<div class="card mg-t-10 mb-4" id="variantCard">
	<!-- Header -->
	<div class="card-header pd-t-20 pd-b-0 bd-b-0">
	    <h5 class="mg-b-5">Relaciones</h5>
		@switch($product->type)
            @case('physical')
				<p class="tx-12 tx-color-03 mg-b-0">Se pueden relacionar otros productos para tener múltiples opciones de tipo "Color" o "Material".</p>
            @break

            @case('digital')
            	<p class="tx-12 tx-color-03 mg-b-0">Se pueden relacionar otros productos para tener múltiples opciones de "Tipo" o "Archivo"</p>
            @break

            @case('subscription')
            	<p class="tx-12 tx-color-03 mg-b-0">Se pueden relacionar otros productos para tener múltiples "Paquetes" y "Frecuencias".</p>
            @break
        @endswitch
	</div>

	<!-- Form -->
	@if($base_product == NULL || $base_product->base_product_id == $product->id)
	<div id="btnContainerRelationships" class="card-body row">
	    <div class="col-md-12">
	    	<a href="javascript:void(0)" id="openRelationships" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
	            Agregar Relaciones
	       	</a>
	    </div>
	</div>
	@else
	<div id="btnContainerRelationships" class="card-body row">
		<div class="col-md-12">
			<div class="alert alert-info d-flex align-items-center" role="alert">
				<p class="mb-0 mr-3"><i data-feather="alert-circle"></i></p>

				<p class="mb-0">Solamente puedes relacionar o eliminar productos desde el primero que configuraste en la relación. Accede a él con el botón de "Ir al producto base" o dando click en su tarjeta.</p>
			</div>
		</div>
	    <div class="col-md-12">
	    	<a href="{{ route('products.show', $base_product->base_product->id) }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
	            Ir al producto base
	       	</a>
	    </div>
	</div>
	@endif

	<!-- Variant Header -->
	<div id="collapsedRelationships" class="table-responsive hidden mt-3 mb-4">
		<form method="POST" id="relationshipForm" action="{{ route('relationship.store', $product->id ?? '0') }}" enctype="multipart/form-data">
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
								@switch($product->type)
									@case('physical')
										<option value="Color">Color</option>
										<option value="Material">Material</option>
									@break

									@case('digital')
										<option value="Archivo">Archivo</option>
										<option value="Tipo">Tipo</option>
									@break

									@case('subscription')
										<option value="Paquete">Paquete</option>
										<option value="Frecuencia">Frecuencia</option>
									@break
								@endswitch
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
	            <button type="button" id="saveRelationship" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
	                Guardar Relación
	           	</button>
	        </div>
	    </form>
	</div>

	<style>
		.btn-danger{
			position: absolute;
			top: 15px;
			right: 15px;
			width: 20px;
			height: 20px;
			border-radius: 100%;
			padding: 0px;
			text-align: center;
			line-height: 20px;
		}
	</style>

	<div class="card-body">
		@if(!empty($all_relationships))
		<div class="row">
			<div class="col-md-4">
	        	<div class="card mb-4">
	        		@if($base_product->base_product_id == $product->id)
	        		<div class="bg-info text-white d-flex align-items-center justify-content-center p-1">
	        			<p class="mb-0 mr-2"><i data-feather="eye" style="width:15px; position: relative; top: -2px;"></i></p> <p class="mb-0"> Viendo</p>
	        		</div>
	        		@endif
	        		<div class="bg-warning text-white d-flex align-items-center justify-content-center mb-1 p-1">
	        			<p class="mb-0 mr-2"><i data-feather="star" style="width:15px; position: relative; top: -2px;"></i></p> <p class="mb-0">Producto Base</p>
	        		</div>

	        		<img  class="img-fluid" src="{{ asset('img/products/' . $base_product->base_product->image ) }}">

	        		<div class="card-body">
	        			<h6 class="mb-2"><a href="{{ route('products.show', $base_product->base_product->id) }}">{{ $base_product->base_product->name }}</a></h6>
	        			<div class="d-flex align-items-center">
	        				<span class="badge badge-info mr-2">Valor: {{ $base_product->base_product->color }}</span>
	        				<span class="badge badge-secondary">Tipo: {{ $base_product->type }}</span>
	        			</div>
	        		</div>
	        	</div>
	    	</div>

	        @foreach($all_relationships as $rs_variant)
		        <div class="col-md-4">
		        	<div class="card mb-4">
		        		@if($rs_variant->product_id == $product->id)
		        		<div class="bg-info text-white d-flex align-items-center justify-content-center p-1">
		        			<p class="mb-0 mr-2"><i data-feather="eye" style="width:15px; position: relative; top: -2px;"></i></p> <p class="mb-0"> Viendo</p>
		        		</div>
		        		@endif
						
						<form method="POST" action="{{ route('relationship.destroy', $rs_variant->id) }}">
                            <button type="submit" class="btn btn-danger btn-delete" data-toggle="tooltip" data-original-title="Eliminar">
                                <i data-feather="x"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>

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
	<script type="text/javascript">
		$('#openRelationships').on('click', function(){
			event.preventDefault();
			$('#collapsedRelationships').removeClass('hidden');
			$('#btnContainerRelationships').hide();
			$(this).toggle();
		});

		$('#saveRelationship').on('click', function(){
			event.preventDefault();
			$('#relationshipForm').submit();
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