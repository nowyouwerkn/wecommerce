<table class="table">
    <thead>
        <tr>
            <th>Imagen</th>
            <th> 
                <div class="d-flex">
                       Nombre 
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="name">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit">&#8613;</button>
                </form>
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="name">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit">&#8615;</button>
                </form>
                </div>
             </th>
            <th>          
                <div class="d-flex">
                       SKU / UPC 
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="sku">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit">&#8613;</button>
                </form>
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="sku">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit">&#8615;</button>
                </form>
                </div>
            </th>
            <th>          
                <div class="d-flex">
                       Precio 
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="price">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit">&#8613;</button>
                </form>
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="price">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit">&#8615;</button>
                </form>
                </div>
            </th>
            <th>        
                <div class="d-flex">
                       Precio de descuento
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="discount_price">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit">&#8613;</button>
                </form>
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="discount_price">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit">&#8615;</button>
                </form>
                </div>
            </th>
            <th>Características</th>
            <th>        
                <div class="d-flex">
                       Estado 
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="status">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit">&#8613;</button>
                </form>
                <form action="{{route('products.filter')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="status">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit">&#8615;</button>
                </form>
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
            <td style="width: 100px;">
                {{ $product->sku }}
                <small><em>{{ $product->barcode }}</em></small>
            </td>
            <td>${{ number_format($product->price,2) }}</td>
            <td>
                ${{ number_format($product->discount_price,2) }}
            </td>

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
                    <li>
                        @if($product->has_tax == true)
                        <i class="fas fa-check text-info"></i>
                        @else
                        <i class="fas fa-times text-danger"></i>
                        @endif
                        Tiene impuestos
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
                {{-- 
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm btn-icon" data-toggle="tooltip" data-original-title="Ver Detalle">
                    <i class="fas fa-eye"></i>
                </a>
                --}}

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