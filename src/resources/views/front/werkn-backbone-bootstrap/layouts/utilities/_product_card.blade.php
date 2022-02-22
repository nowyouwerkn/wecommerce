<div class="card mb-4">
    <a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}">
        <img class="card-img-top" src="{{ asset('img/products/' . $product_info->image) }}" data-holder-rendered="true">
    </a>

    <div class="card-body">
        <h5 class="card-text mb-1">{{ $product_info->name }}</h5>

        <div class="rating d-flex mt-0 mb-3">
            @if(round($product_info->approved_reviews->avg('rating'), 0) == 0)
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
            @endif

            @if(round($product_info->approved_reviews->avg('rating'), 0) == 1)
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
            @endif
            
            @if(round($product_info->approved_reviews->avg('rating'), 0) == 2)
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
            @endif

            @if(round($product_info->approved_reviews->avg('rating'), 0) == 3)
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
            @endif

            @if(round($product_info->approved_reviews->avg('rating'), 0) == 4)
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star-outline"></ion-icon>
            @endif
            
            @if(round($product_info->approved_reviews->avg('rating'), 0) == 5)
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
                <ion-icon name="star"></ion-icon>
            @endif
        </div>

        <p class="card-text text-truncate">{{$product_info->description}}</p>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="eye-outline"></ion-icon></a>

                @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->id))
                    <a href="{{ route('wishlist.remove', $product_info->id) }}" class="btn btn-sm btn-outline-danger d-flex align-items-center"><ion-icon name="heart-dislike-outline"></ion-icon></a>
                @else
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center"><ion-icon name="heart-outline"></ion-icon></a>
                    @else
                    <a href="{{ route('wishlist.add', $product_info->id) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center"><ion-icon name="heart-outline"></ion-icon></a>
                    @endif
                @endif
            </div>

            @if($product_info->has_discount == true && $product_info->discount_end > Carbon\Carbon::today())
                <div class="wk-price">${{ number_format($product_info->discount_price, 2) }}</div>
                <div class="wk-price wk-price-discounted">${{ number_format($product_info->price, 2) }}</div>
            @else
                <div class="wk-price">${{ number_format($product_info->price, 2) }}</div>
            @endif
        </div>

        @php
            /* Double Variant System */
            $product_relationships = \Nowyouwerkn\WeCommerce\Models\ProductRelationship::where('base_product_id', $product_info->id)->orWhere('product_id', $product_info->id)->get();

            if ($product_relationships->count() == NULL) {
                $base_product = NULL;
                $all_relationships = NULL;
            }else{
                $base_product = $product_relationships->take(1)->first();
                $all_relationships = \Nowyouwerkn\WeCommerce\Models\ProductRelationship::where('base_product_id', $base_product->base_product_id)->get();
            }
        @endphp

        @if(!empty($all_relationships))
        <ul class="list-unstyled d-flex align-items-center wk-product-card-colors mb-2 mt-4">
            <li>
                <a href="{{ route('detail', [$base_product->base_product->category->slug, $base_product->base_product->slug]) }}" style="background-color: {{ $base_product->base_product->hex_color  }}; border-color:{{ $base_product->base_product->hex_color  }};" class="wk-product-card-color-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $base_product->base_product->color }}">{{ $base_product->base_product->color }}</a>
            </li>

            @foreach($all_relationships as $rs_variant)
                @if($rs_variant->product->status != 'Borrador')
                <li>
                    <a href="{{ route('detail', [$rs_variant->product->category->slug, $rs_variant->product->slug]) }}" style="background-color: {{ $rs_variant->product->hex_color  }};" class="wk-product-card-color-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $rs_variant->value }}">{{ $rs_variant->value }}</a>
                </li>
                @endif
            @endforeach
        </ul>
        @endif

        @if(request()->is('*/wishlist'))
        <div class="footer-card-wish">Solo quedan {{$product_info->product->stock}}</div>
        @endif
    </div>
</div>

@push('stylesheets')

@endpush