@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">{{ $product->name }}</h4>
    </div>
    @if(auth()->user()->can('admin_access'))
    <div class="d-none d-md-block">
        <a href="{{ route('products.edit', $product->id ) }}" class="btn btn-primary mr-2"><i class="simple-icon-pencil"></i> Editar</a>

        <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block;">
            <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-original-title="Borrar">
                <i class="simple-icon-trash"></i> Borrar
            </button>
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
        </form>

    </div>
    @endif
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <p class="badge badge-primary">ID Interno de Producto: {{ $product->id }}</p>
            
            <div class="card-body">
                <img class="img-fluid mb-4" src="{{ asset('img/products/' . $product->image ) }}">

                @foreach($product->images->chunk(4) as $imagenGroup)
                <div class="row">
                    @foreach($imagenGroup as $imagen)
                        <div class="col-md-3">
                            <img class="img-thumbnail" src="{{ asset('img/products/' . $imagen->image )  }}">
                            <p>{{ $imagen->descripcion }}</p>
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            
            <a href="javascript:void(0)" data-target="#modalNewImage" data-toggle="modal" class="mt-3 btn btn-primary default btn-block"><span class="simple-icon-plus"></span> Agregar más imagenes</a>

            <!-- Modal -->
            <div class="modal fade" id="modalNewImage" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Nueva Imágen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="form-group">
                            <label class="control-label" for="image">Imagen</label>
                            <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                            <input type="file" id="inputFile" name="image" />
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="description">Descripción</label>
                            <textarea class="form-control" name="description" rows="5"></textarea>
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
        </div>
    </div>


    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Información de Producto</h4>
                    </div>
                    <div class="col text-right">
                        
                    </div>
                </div>
                <hr>

                <div class="row mt-4">
                    <div class="col-md-7">
                        <div class="pr-5">
                            <h2>{{ $product->name }}</h2>
                            <h6>SKU: {{ $product->sku }}</h6>

                            <p class="mb-5">{!! $product->description !!}</p>

                            @if ($product->is_new == true)
                                <span class="badge badge-info mb-3">PRODUCTO NUEVO</span>
                                <br>
                            @endif

                            @if($product->has_discount == true)
                            <span class="badge badge-info">TIENE DESCUENTO</span>
                            <h6 class="price-line mt-2"><span class="line-discount"></span>$ {{ number_format($product->price, 2) }}</h6>
                            <h2 class="mb-3">$ {{ number_format($product->discount_price, 2) }}</h2>
                            <div class="row">
                                <div class="col">
                                    <p class="mb-0">Inicia</p>
                                    <p>{{ Carbon\Carbon::parse($product->discount_start)->format('d M, Y') }}</p>
                                </div>	
                                <div class="col">
                                    <p class="mb-0">Termina</p>
                                    <p>{{ Carbon\Carbon::parse($product->discount_end)->diffForHumans() }}</p>
                                </div>
                            </div>
                            @else
                            <h2>$ {{ number_format($product->price, 2) }}</h2>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-5">
                        <dl>
                            <dt>Categoría Principal</dt>
                            @if($product->category == NULL)
                            <dd>Sin Categoría</dd>
                            @else
                            <dd>{{ $product->category->name or 'Sin Categoria' }}</dd>
                            @endif
                            <hr>

                            <dt>Sub-Categorías</dt>
                            @foreach($product->subCategory as $cat)
                            <dd>{{ $cat->name or 'Sin Subcategoría' }}</dd>
                            @endforeach
                            <hr>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Inventario / Existencias</h4>
                    </div>
                    <div class="col text-right">
                        <a data-toggle="modal" data-target="#variantsModal" class="btn btn-outline-secondary"><i class="iconsminds-box-close"></i> Nueva Existencia</a>
                    </div>
                </div>
                <hr>

                @if($variant_stock->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Variante</th>
                                <th>Existencias</th>

                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($variant_stock as $variant)
                            <tr>
                                <td>{{ $variant->variants->type ?? 'Talla'}}</td>
                                <td>{{ $variant->variants->value }}</td>
                                <td>{{ $variant->stock }}</td>

                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="modal" data-target="#variantsModal_{{ $variant->id }}">
                                        <i class="fas fa-sync" aria-hidden="true"></i>
                                    </a>

                                    {{-- 
                                    <form method="POST" action="{{ route('tallas.stock.destroy', $product->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="tooltip" data-original-title="Borrar">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="text-center my-5">
                    <h4 class="mb-0">¡No has determinado variantes para este producto!</h4>
                    <p>¡Si no hay existencias de tu producto se mostrará en el catálogo pero no podrán comprarlo!</p>
                </div>
                @endif
            </div>
        </div>		
    </div>
</div>

<div class="modal fade" id="variantsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nueva Existencia de Variante</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="{{ route('stock.store', $product->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">							
							<div class="form-group">
                                <label for="size">Tipo</label>
                                <select name="type_id" id="type" class="form-control">
                                    <option value="Talla">Talla</option>
                                    <option value="Color">Color</option>
                                    <option value="Material">Material</option>
                                    <option value="Estilo">Estilo</option>
                                    <option value="Nombre">Nombre</option>
                                </select>
                            </div>
						</div>
						<hr>

						<div class="col-md-4">
							<div class="form-group">
		                        <label for="inputAddress">Valor</label>
                                <input type="text" class="form-control" name="variant" placeholder="---">
		                        <!--
                                <select name="size" id="variant" class="form-control">
                                    <option selected>Selecciona una Opción...</option>
                                </select>
                                -->
		                    </div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
		                        <label for="inputAddress">Existencias</label>
		                        <input type="text" class="form-control" name="stock" placeholder="---">
		                    </div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection