<form method="get" action="{{ route('dynamic.filter.front') }}" id="product_filter_form">
    @php
        $popular_products = Nowyouwerkn\WeCommerce\Models\Product::where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = \Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = \Nowyouwerkn\WeCommerce\Models\Variant::orderBy('value', 'asc')->get();
    @endphp

    <aside class="shop-sidebar pr-5">
        <div class="d-flex align-items-center mb-20">
            <button type="submit" class="btn-link btn-block btn-sm mr-3"><i class="mdi mdi-filter"></i> Filtrar Búsqueda</button>

            <a href="{{ route('catalog.all') }}" id="clean_selection" class="btn-link btn-sm" data-toggle="tooltip" data-placement="top" title="Limpiar Selección"><i class="mdi mdi-refresh"></i> Refrescar</a>
        </div>

        <div class="widget">
            <h4 class="widget-title">Colecciones</h4>
            <div class="shop-cat-list">
                <ul>
                    @foreach($categories as $category)
                    <li class="form-check">
                        <input 
                        class="form-check-input"
                        type="checkbox" 
                        id="{{ $category->slug }}" 
                        name="category[]" 
                        value="{{ $category->slug }}"
                        @if(isset($selected_category))  
                            @if (in_array($category->slug, $selected_category))  
                                checked="checked"   
                            @endif 
                        @endif
                        >

                        <label for="{{ $category->slug }}" class="form-check-label d-flex align-items-center">
                            <span class="d-none d-md-inline-block">{{ $category->name }}</span>
                            <span class="badge badge-primary" style="padding: 2px 5px; margin-left: 10px;">{{ $category->productsIndex->count() ?? '0' }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="widget has-border">
            <div class="sidebar-product-size mb-30">
                <h4 class="widget-title">Variantes</h4>
                <div class="shop-cat-list">
                    <ul>
                        @foreach($variants as $variant)
                        <li class="form-check">
                            <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="variant_{{ $variant->id }}" 
                            name="variant[]" 
                            value="{{ $variant->value }}"
                            @if(isset($selected_variant))  
                                @if (in_array($variant->value, $selected_variant))  
                                    checked="checked"   
                                @endif 
                            @endif
                            >

                            <label for="variant_{{ $variant->id }}" class="form-check-label d-flex align-items-center">
                                <span class="d-none d-md-inline-block">{{ $variant->value }}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="widget">
            <h4 class="widget-title">Populares</h4>
            <div class="sidebar-product-list">
                <ul>
                    @foreach($popular_products as $product)
                    <li>
                        <div class="sidebar-product-thumb">
                            <a href="{{ route('detail', [$product->category->slug, $product->slug]) }}">
                                <img src="{{ asset('img/products/' . $product->image) }}" width="100%">
                            </a>
                        </div>
                        <div class="sidebar-product-content">
                            <h5><a href="{{ route('detail', [$product->category->slug, $product->slug]) }}">{{ $product->name }}</a></h5>
                            @if($product->has_discount == true)
                            <span>${{ number_format($product->discount_price, 2) }}</span>
                            <span class="price-discounted">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span>${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </aside>
</form>