<div class="new-arrival-item text-center mb-50">
    <div class="thumb mb-25">
        <a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}"><img src="{{ asset('img/products/' . $product_info->image) }}" alt=""></a>
        <div class="product-overlay-action">
            <ul>
                <li>
                @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->id))
                    <a href="{{ route('wishlist.remove', $product_info->id) }}" class="wishlist-btn wishlist-btn-delete"><i class="far fa-heartbeat"></i></a>
                @else
                    @if(Auth::guest())
                    <a href="{{ route('login') }}" class="wishlist-btn d-flex align-items-center text-center p-2"><i class="far fa-heart"></i></a>
                    @else
                    <a href="{{ route('wishlist.add', $product_info->id) }}" class="wishlist-btn d-flex align-items-center text-center p-2"><i class="far fa-heart"></i></a>
                    @endif
                @endif
                </li>
                <li><a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}"><i class="far fa-eye"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <h5><a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}">{{ $product_info->name }}</a></h5>
        <span class="price">${{ number_format($product_info->price, 2) }}</span>
    </div>
</div>