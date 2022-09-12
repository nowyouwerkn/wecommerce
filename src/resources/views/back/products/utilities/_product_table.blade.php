<table class="table table-dashboard">
    <thead>
        <tr>
            <th>Imagen</th>
            <th> 
                <div class="d-flex align-items-center">
                    <span class="table-title">Nombre</span>
                    <a class="filter-btn" href="{{route('filter.products', ['asc', 'name'])}}">
                    <i class="icon ion-md-arrow-up"></i></a>
                    <a class="filter-btn" href="{{route('filter.products', ['desc', 'name'])}}">
                    <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th>Tipo</th>

            <th style="min-width:130px;">          
                <div class="d-flex align-items-center">
                    <span class="table-title">SKU / UPC</span>
                    <a class="filter-btn" href="{{route('filter.products', ['asc', 'sku'])}}">
                    <i class="icon ion-md-arrow-up"></i></a>
                    <a class="filter-btn" href="{{route('filter.products', ['desc', 'sku'])}}">
                    <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>          
                <div class="d-flex align-items-center">
                    <span class="table-title">Precio</span>
                    <a class="filter-btn" href="{{route('filter.products', ['asc', 'price'])}}">
                    <i class="icon ion-md-arrow-up"></i></a>
                    <a class="filter-btn" href="{{route('filter.products', ['desc', 'price'])}}">
                    <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>        
                <div class="d-flex align-items-center">
                    <span class="table-title">Descuento</span>
                    <a class="filter-btn" href="{{route('filter.products', ['asc', 'discount_price'])}}">
                    <i class="icon ion-md-arrow-up"></i></a>
                    <a class="filter-btn" href="{{route('filter.products', ['desc', 'discount_price'])}}">
                    <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>Características</th>
            <th>        
                <div class="d-flex align-items-center">
                    <span class="table-title">Estado</span>
                    <a class="filter-btn" href="{{route('filter.products', ['asc', 'status'])}}">
                    <i class="icon ion-md-arrow-up"></i></a>
                    <a class="filter-btn" href="{{route('filter.products', ['desc', 'status'])}}">
                    <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td style="width: 150px; position: relative;">
                <img style="width: 100%;" src="{{ asset('img/products/' . $product->image ) }}" alt="{{ $product->name }}">
                <div class="text-center margin-top-10">

                    <small>
                        <p>
                        + {{ $product->images->count() }}

                        @if($product->images->count() >= 1)
                        Imágenes
                        @else
                        Imagen
                        @endif
                        </p>
                    </small>    
                </div>
            </td>
            <td style="width: 250px;">
                <strong><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></strong> <br><p style="width: 200px;" class="mb-1">{{ substr($product->description, 0, 100)}} {{ strlen($product->description) > 100 ? "[...]" : "" }}</p>

                <small class="badge badge-info mb-3" style="white-space: unset;">{{ $product->search_tags }}</small>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    @switch($product->type)
                        @case('physical')
                            <img src="{{ asset('assets/img/physical-product.png') }}" width="15px" class="mr-1" alt="">
                            Físico
                            @break

                        @case('digital')
                            <img src="{{ asset('assets/img/digital-product.png') }}" width="15px" class="mr-1" alt="">
                            Digital
                            @break

                        @case('subscription')
                            <img src="{{ asset('assets/img/suscription-product.png') }}" width="15px" class="mr-1" alt="">
                            Suscripción
                            @break
                        @default
                            <img src="{{ asset('assets/img/physical-product.png') }}" width="15px" class="mr-1" alt="">
                            Físico
                    @endswitch
                </div>
            </td>

            <td style="width: 100px;">
                {{ $product->sku }}
                <small class="d-block"><em>{{ $product->barcode }}</em></small>
            </td>
            <td>${{ number_format($product->price,2) }}</td>
            <td>${{ number_format($product->discount_price,2) }}</td>

            <td>
                <ul class="list-unstyled mb-0">
                    <li>
                        @if($product->in_index == true)
                        <i class="fas fa-check text-info"></i>
                        @else
                        <i class="fas fa-times text-danger"></i>
                        @endif
                        Mostrar en Inicio
                    </li>
                    <li>
                        @if($product->is_favorite == true)
                        <i class="fas fa-check text-info"></i>
                        @else
                        <i class="fas fa-times text-danger"></i>
                        @endif
                        Favorito
                    </li>
                    <li>
                        @if($product->has_discount == true)
                        <i class="fas fa-check text-info"></i>
                        @else
                        <i class="fas fa-times text-danger"></i>
                        @endif
                        Descuento Activo
                    </li>
                </ul>
            </td>

            <td>
                @if($product->status == 'Publicado')
                    <span class="status-circle bg-success"></span> Publicado
                @else
                    <span class="status-circle bg-danger"></span> Borrador
                @endif
            </td>
            
            <td class="text-nowrap">
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Editar">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                </a>

                <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" data-toggle="tooltip" data-original-title="Borrar">
                        <i class="fas fa-trash" aria-hidden="true"></i>
                    </button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>