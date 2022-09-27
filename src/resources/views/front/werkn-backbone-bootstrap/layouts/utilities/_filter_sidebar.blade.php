@push('stylesheets')

@endpush

<div id="sidebar" class="sidebar-filter px-4">
    <form method="get" action="{{ route('dynamic.filter.front') }}" id="product_filter_form">
        @php
            $popular_products = Nowyouwerkn\WeCommerce\Models\Product::where('is_favorite', true)->where('status', 'Publicado')->get();
            $categories = \Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
            $variants = \Nowyouwerkn\WeCommerce\Models\Variant::orderBy('value', 'asc')->get();

            $brands = \Nowyouwerkn\WeCommerce\Models\Product::where('brand', '!=', 'NULL')->get();
            $variants_styles = $brands->unique('brand');

            $genders = \Nowyouwerkn\WeCommerce\Models\Product::where('gender', '!=', 'NULL')->get();
            $variants_genders = $genders->unique('gender');

            $materials = \Nowyouwerkn\WeCommerce\Models\Product::where('materials', '!=', 'NULL')->get();
            $variants_materials = $materials->unique('materials');

            $colors = Nowyouwerkn\WeCommerce\Models\Product::where('color', '!=', 'NULL')->get();
            $variants_colors = $colors->unique('color');

            $conditions = Nowyouwerkn\WeCommerce\Models\Product::where('condition', '!=', 'NULL')->get();
            $variants_condition = $conditions->unique('condition');

            $age_groups = Nowyouwerkn\WeCommerce\Models\Product::where('age_group', '!=', 'NULL')->get();
            $variants_age = $age_groups->unique('age_group');
        @endphp

        <div class="filter">
            <div class="accordion">
                <h4 class="">Filtros</h4>
                @if (!empty($catalog))
                    <p>{{ $catalog }}</p>
                @endif
                <hr>
            </div>

            <div class="accordion">
                <div class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="false" aria-controls="category">
                            Categorías
                        </h4>

                    </div>
                    <div id="category" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $category->slug }}" id="{{ $category->slug }}" name="category[]" @if(isset($selected_category)) @if (in_array($category->slug, $selected_category)) checked="checked" @endif  @endif>
                                    <label class="form-check-label d-flex justify-content-between" for="{{ $category->slug }}">
                                        {{ $category->name }}
                                        <span class="badge bg-danger">{{ $category->productsIndex->count() ?? '0' }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#variant" aria-expanded="false" aria-controls="category">
                            Tallas
                        </h4>
                    </div>

                    <div id="variant" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach($variants as $variant)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $variant->value }}" id="variant_{{ $variant->id }}" name="variant[]" @if(isset($selected_variant)) @if (in_array($variant->value, $selected_variant)) checked="checked" @endif  @endif>
                                    <label class="form-check-label d-flex justify-content-between" for="{{ $variant->slug }}">
                                        {{ $variant->value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#gender" aria-expanded="false" aria-controls="category">
                            Género
                        </h4>
                    </div>

                    <div id="gender" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach($variants_genders as $product)
                                <div class="form-check">
                                        <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="variant_{{ $product->gender }}"
                                        name="gender[]"
                                        value="{{ $product->gender }}"
                                        @if(isset($selected_variant))
                                            @if (in_array($product->gender, $selected_variant))
                                                checked="checked"
                                            @endif
                                        @endif
                                        >
                                    <label for="variant_{{ $product->gender }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">
                                            @switch($product->gender)
                                                @case('unisex')
                                                Unisex
                                                @break

                                                @case('male')
                                                Hombres
                                                @break

                                                @case('female')
                                                Mujeres
                                                @break

                                                @default
                                            @endswitch
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#brand" aria-expanded="false" aria-controls="category">
                            Marcas
                        </h4>
                    </div>

                    <div id="brand" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach($variants_styles as $product)
                                <div class="form-check">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="variant_{{ Str::slug($product->brand) }}"
                                    name="brand[]"
                                    value="{{ $product->brand }}"
                                    @if(isset($selected_variant))
                                        @if (in_array($product->brand, $selected_variant))
                                            checked="checked"
                                        @endif
                                    @endif
                                    >
                                    <label for="variant_{{ Str::slug($product->brand) }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">{{ $product->brand }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#material" aria-expanded="false" aria-controls="category">
                            Materiales
                        </h4>
                    </div>

                    <div id="material" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach($variants_styles as $product)
                                <div class="form-check">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="variant_{{ Str::slug($product->materials) }}"
                                    name="materials[]"
                                    value="{{ $product->materials }}"
                                    @if(isset($selected_variant))
                                        @if (in_array($product->materials, $selected_variant))
                                            checked="checked"
                                        @endif
                                    @endif
                                    >
                                    <label for="variant_{{ Str::slug($product->materials) }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">{{ $product->materials }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#color" aria-expanded="false" aria-controls="category">
                            Color
                        </h4>
                    </div>

                    <div id="color" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach ($variants_colors as $product)
                                <div class="form-check">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="variant_{{ Str::slug($product->color) }}"
                                    name="color[]"
                                    value="{{ $product->color }}"
                                    @if(isset($selected_variant))
                                        @if (in_array($product->color, $selected_variant))
                                            checked="checked"
                                        @endif
                                    @endif
                                    >
                                    <label for="variant_{{ Str::slug($product->color) }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">{{ $product->color }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#condition" aria-expanded="false" aria-controls="category">
                            Condición
                        </h4>
                    </div>

                    <div id="condition" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach ($variants_condition as $product)
                                <div class="form-check">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="variant_{{ Str::slug($product->condition) }}"
                                    name="condition[]"
                                    value="{{ $product->condition }}"
                                    @if(isset($selected_variant))
                                        @if (in_array($product->condition, $selected_variant))
                                            checked="checked"
                                        @endif
                                    @endif
                                    >
                                    <label for="variant_{{ Str::slug($product->condition) }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">{{ $product->condition }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#age" aria-expanded="false" aria-controls="category">
                            Rango de Edad
                        </h4>
                    </div>

                    <div id="age" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            @foreach ($variants_age as $product)
                                <div class="form-check">
                                    <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="variant_{{ Str::slug($product->age_group) }}"
                                    name="age[]"
                                    value="{{ $product->age_group }}"
                                    @if(isset($selected_variant))
                                        @if (in_array($product->age_group, $selected_variant))
                                            checked="checked"
                                        @endif
                                    @endif
                                    >
                                    <label for="variant_{{ Str::slug($product->age_group) }}" class="form-check-label d-flex align-items-center">
                                        <span class="d-none d-md-inline-block">{{ $product->age_group }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!--
                <div style="width: 100%;" class="accordion-item accordion_item">
                    <div class="accordion-header">
                        <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#calification" aria-expanded="false" aria-controls="category">
                            Calificación
                        </h4>
                    </div>

                    <div id="calification" class="accordion-collapse collapse">
                        <div class="accordion-body accordion_body">
                            <div class="rate" style="float:inherit">
                                <input type="radio" id="star5" name="score" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="score" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="score" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="score" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="score" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>
                        </div>
                    </div>
                </div>
                -->

            </div>
            <br>
            <button type="submit" class="btn btn-primary w-100">
                <ion-icon name="filter-outline"></ion-icon>
                Filtrar Búsqueda
            </button>
        </div>
    </form>

    <form id="filterOrder" class="mt-4" action="{{route('catalog.orderby')}}" method="POST">
        @csrf
        <select name="filter" class="form-select order-product">
            <option selected="" value="0">Ordenar por</option>
            <option value="new">Lo más nuevo</option>
            <option value="old">Lo más antiguo</option>
            <option value="price_asc">Precio mayor a menor</option>
            <option value="price_desc">Precio de menor a mayor</option>
            <option value="name_asc">Alfabeticamente A a Z</option>
            <option value="name_desc">Alfabeticamente Z a A</option>
            <option value="promo">Ofertas y descuentos</option>
        </select>
    </form>

</div>

@push('scripts')
<script type="text/javascript">
    $('#filterOrder select').on('change', function(e){
        $('#filterOrder').submit();
    });
</script>

@endpush
