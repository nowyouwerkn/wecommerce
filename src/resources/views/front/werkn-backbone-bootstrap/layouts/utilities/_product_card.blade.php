<div class="card mb-4 box-shadow">
                <a href="{{ route('detail', [$product_info->category->slug, $product_info->slug]) }}">
                <img class="card-img-top" src="{{ asset('img/products/' . $product_info->image) }}" data-holder-rendered="true">
                </a>
                <div class="card-body">
                    <h5 class="card-text">{{$product_info->name}}</h5>
                  <p class="card-text">{{$product_info->description}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        @if(isset(Auth::user()->id) && Auth::user()->isInWishlist($product_info->id))
                         <a href="{{ route('wishlist.remove', $product_info->id) }}" class="btn-sm btn btn-outline-danger"><ion-icon name="heart-dislike"></ion-icon></a>
                        @else
                            @if(Auth::guest())
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary"><ion-icon name="heart"></ion-icon></a>
                            @else
                             <a href="{{ route('wishlist.add', $product_info->id) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="heart"></ion-icon></a>
                            @endif
                        @endif
                        @if($product_info->status == 'Publicado')
                        <a href="{{ route('add-cart', ['id' => $product_info->id, 'variant' => 'unique']) }}"  class="btn btn-sm btn-outline-secondary"><ion-icon name="cart"></ion-icon></a>
                        @else
                        <a href="#" class="btn btn-sm btn-outline-secondary">Disabled</a>
                        @endif
                    </div>
                         @if($product_info->has_discount == true)
        <span class="price">${{ number_format($product_info->discount_price, 2) }}</span>
        <span class="price price-discounted">${{ number_format($product_info->price, 2) }}</span>
        @else
        <span class="price">${{ number_format($product_info->price, 2) }}</span>
        @endif
                  </div>
                </div>
              </div>
@push('stylesheets')

@endpush