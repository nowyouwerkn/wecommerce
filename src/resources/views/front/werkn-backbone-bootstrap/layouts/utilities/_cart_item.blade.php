@php
    $oldCart = Session::get('cart');
    $cart = new Nowyouwerkn\WeCommerce\Models\Cart($oldCart);

    $cart_products = $cart->items;
    $totalPrice = $cart->totalPrice;
@endphp

@foreach($cart_products as $cart_product)
    <li>
    	@php
		    $item_img = $cart_product['item']['image'];
		    $variant = $cart_product['variant'];
		@endphp

		<div class="cart-item-media d-flex mb-3">
		  	<div class="flex-shrink-0">
		    	<img alt="{{ $cart_product['item']['name'] }}" style="width: 100px;" src="{{ asset('img/products/' . $item_img ) }}">
		  	</div>

		  	<div class="flex-grow-1 ms-3">
		    	<h5 class="fs-6 mb-1">{{ $cart_product['item']['name'] }}</h5>

		    	@if($cart_product['item']['has_discount'] == true && $cart_product['item']['discount_end'] > Carbon\Carbon::today())
	                <div class="wk-price" style="font-size:.8em;">${{ number_format($cart_product['item']['discount_price'], 2) }}</div>
	                <div class="wk-price wk-price-discounted" style="font-size:.7em !important; ">${{ number_format($cart_product['item']['price'], 2) }}</div>
	            @else
	                <div class="wk-price" style="font-size:.8em;">${{ number_format($cart_product['item']['price'], 2) }}</div>
	            @endif

	            <div class="mt-1" style="font-size:.8em !important;">
	            	@if($cart_product['item']['color'] != NULL)
	            	<p class="mb-0">Color: {{ $cart_product['item']['color'] }}</p>
	            	@endif
	            	<p class="mb-0">Cantidad: {{ $cart_product['qty'] }}</p>
	            	<p class="mb-0">Talla: {{ $variant }}</p>
	            </div>
		 	</div>
		</div>
    </li>
@endforeach

<hr>

<div class="d-flex align-items-center justify-content-between mb-2">
    <p><strong>Subtotal:</strong></p>
    <p class="text-end">${{ number_format($totalPrice, 2) }}</p> 
</div>

<div class="d-block">
    <a class="btn p-3 d-block btn-primary mb-2" href="{{ route('checkout') }}"><ion-icon name="bag-check-outline"></ion-icon> Completar tu compra </a>
    <a class="btn d-block btn-outline-secondary mb-2" href="{{ route('cart') }}"><ion-icon name="bag-outline"></ion-icon> Ver tu bolsa</a>
</div>
@guest
<p class="alert alert-warning" style="display: inline-block;">
    <ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Estas comprando como <strong>invitado.</strong> Compra más rápido creando una cuenta <a href="{{ route('register') }}">Regístrate</a>
</p>
@endguest

