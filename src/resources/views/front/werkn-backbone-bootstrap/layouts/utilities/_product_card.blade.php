<div class="card product-card mb-4">
    <a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}">
        <img src="{{ asset('img/products/' . $product_info->image) }}" alt="{{ $product_info->name }}" class="img-fluid">
    </a>

    <div class="card-body">
        <ul class="list-inline">
            <li class="list-inline-item">
            @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->id))
                <a href="{{ route('wishlist.remove', $product_info->id) }}" class="wishlist-btn wishlist-btn-delete"><ion-icon name="heart-dislike"></ion-icon></a>
            @else
                @if(Auth::guest())
                <a href="{{ route('login') }}" class="wishlist-btn d-flex align-items-center text-center p-2"><ion-icon name="heart"></ion-icon></a>
                @else
                <a href="{{ route('wishlist.add', $product_info->id) }}" class="wishlist-btn d-flex align-items-center text-center p-2"><ion-icon name="heart"></ion-icon></a>
                @endif
            @endif
            </li>
            <li class="list-inline-item"><a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}"><ion-icon name="eye"></ion-icon></a></li>
        </ul>

        <h5><a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}">{{ $product_info->name }}</a></h5>
        @if($product_info->has_discount == true)
        <span class="price">${{ number_format($product_info->discount_price, 2) }}</span>
        <span class="price price-discounted">${{ number_format($product_info->price, 2) }}</span>
        @else
        <span class="price">${{ number_format($product_info->price, 2) }}</span>
        @endif
    </div>
</div>
@push('stylesheets')

@endpush