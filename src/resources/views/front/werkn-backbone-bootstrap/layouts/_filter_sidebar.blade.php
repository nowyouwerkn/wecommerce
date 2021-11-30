      

<div id="sidebar" class="sidebar-filter px-4">
<form method="get" action="{{ route('dynamic.filter.front') }}" id="product_filter_form">
    @php
        $popular_products = Nowyouwerkn\WeCommerce\Models\Product::where('is_favorite', true)->where('status', 'Publicado')->get();
        $categories = \Nowyouwerkn\WeCommerce\Models\Category::where('parent_id', 0)->orWhere('parent_id', NULL)->get();
        $variants = \Nowyouwerkn\WeCommerce\Models\Variant::orderBy('value', 'asc')->get();
    @endphp

    <div class="filter">

          <div class="accordion">
            <h4 class="">Order by</h4>
            <hr>
            <p class="">Order products by a variety of parameters</p>
              <div class="d-flex justify-content-between">
                       Price 
                       <div class="d-flex">
               <form action="{{route('catalog.orderby')}}" method="POST" >
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="price">
                    <input type="hidden" name="order" value="asc">
                    <button class="filter-btn" type="submit" style="display: none;">&#8615;</button>
                </form>
                <form action="{{route('catalog.orderby')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="price">
                    <input type="hidden" name="order" value="desc">
                    <button class="filter-btn" type="submit">&#8615;</button>
                </form>
                  <form action="{{route('catalog.orderby')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="price">
                    <input type="hidden" name="order" value="asc">
                    <button class="filter-btn" type="submit">&#8613;</button>
                </form>
                        </div>
                
                </div>
                        <div class="d-flex justify-content-between">
                       Alphabetical 
                       <div class="d-flex">
                    <form action="{{route('catalog.orderby')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="name">
                    <input type="hidden" name="order" value="asc">
                    <button class="filter-btn" type="submit">&#8613;</button>
                </form>
                <form action="{{route('catalog.orderby')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="filter" value="name">
                    <input type="hidden" name="order" value="desc">
                    <button class="filter-btn" type="submit">&#8615;</button>
                </form>
                       </div>
    
                </div>
        </div>
      

        <div class="accordion">
            <h4 class="">Filters</h4>
            <hr>
            <p class="">Filter or sort the catalog choosing one of the options</p>
        </div>

     

        <div class="accordion">
            <div class="accordion-item accordion_item">
                <div class="accordion-header">
                    <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="false" aria-controls="category">
                        Categories
                    </h4>
                   
                </div>
                <div id="category" class="accordion-collapse collapse">
                    <div class="accordion-body accordion_body">
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $category->slug }}" id="{{ $category->slug }}" name="category[]" @if(isset($selected_category)) @if (in_array($category->slug, $selected_category)) checked="checked" @endif  @endif>
                                <label class="form-check-label d-flex justify-content-between" for="{{ $category->slug }}">
                                    {{ $category->name }}
                                    <span class="badge badge_custom">{{ $category->productsIndex->count() ?? '0' }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="width: 100%;" class="accordion-item accordion_item">
                <div class="accordion-header">
                  <h4 class="accordion-button accordion_button collapsed" data-bs-toggle="collapse" data-bs-target="#variant" aria-expanded="false" aria-controls="category">
                        Sizes
                        
                    </h4>
                </div>
                <div id="variant" class="accordion-collapse collapse">
                    <div class="accordion-body accordion_body">
                        @foreach($variants as $variant)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $variant->value }}" id="variant_{{ $variant->id }}" name="variant[]" @if(isset($selected_variant)) @if (in_array($variant->value, $selected_variant)) checked="checked" @endif  @endif>
                                <label class="form-check-label d-flex justify-content-between" for="{{ $variant->slug }}">
                                    {{ $variant->value }}
                                    <span class="badge badge_custom">{{ $variant->count() ?? '0' }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-filter pe-1"></i>
            Filter search
        </button>
    </div>
</form>
                  







                    
                </div>


@push('scripts')
   
@endpush