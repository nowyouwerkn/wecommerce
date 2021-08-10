@foreach($products as $product)
    @php
        $item_img = $product['item']['image'];
        $variant = $product['variant'];
    @endphp
    <!--List product -->
    <div class="card-product-checkout">
        <div class="row align-items-center text-black order-numbers mt-4">
            <div class="col-md-3">
                <img src="{{ asset('img/products/' . $item_img ) }}" class="img-fluid" alt="{{ $product['item']['name'] }}">
            </div>
            <div class="d-flex">
                <div class="w-75">
                    <h6>{{ $product['item']['name'] }}</h6>
                    <p class="mt-2 mb-2">{{ $type ?? 'Variante' }}: {{ $variant }} x <span class="qty-circle">{{ $product['qty'] }}</span></p>
                </div>
                <div class="w-50 d-flex align-items-center justify-content-center">
                    <p class="price-card">$ {{ number_format($product['price']) }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="card-product-checkout">
    <div class="row">
        <div class="col-md-6">
            <p  style="font-size: 15px;"><ion-icon name="cube-outline"></ion-icon> Envío</p>
        </div>
        <div class="col-md-6 text-right">
            <p  style="font-size: 15px;">$ <span id="shippingRate">{{ number_format($shipping, 2) }}</span></p>
            <input type="hidden" name="shipping_rate" id="shippingInput" value="0">
        </div>
    </div>
</div>

<div class="row text-black order-numbers mt-4">
    <div class="col-md-6">
        <p>Sub total <ion-icon data-toggle="tooltip" data-placement="left" title="Productos + Envío sin I.V.A" name="information-circle-outline"></ion-icon ></p>
    </div>
    <div class="col-md-6 text-right">
        <p>$ <span id="cartTotal">{{ number_format($subtotal, 2) }}</span></p>
        <input type="hidden" name="sub_total" id="subTotal" value="0">
    </div>

    <div class="col-md-6">
        <p>Cupones</p>
    </div>
    <div class="col-md-6 text-right">
        <p>$ <span id="discountValue">0.00</span></p>
        <input type="hidden" name="discounts" value="" id="discount">
    </div>
    

    <!-- DISCOUNT DIV -->
    @if(!empty($store_tax))
    <div class="col-md-6">
        <p class="text-muted small">IVA (16%) <ion-icon data-toggle="tooltip" data-placement="left" title="Desglose de I.V.A" name="information-circle-outline"></ion-icon ></p>
    </div>
    <div class="col-md-6 text-right">
        <p class="text-muted small">$ <span id="taxValue">{{ number_format($tax, 2) }}</span></p>
        <input type="hidden" name="tax_rate" value="" id="taxRate">
    </div>
    @else
    <div class="col-md-6">
        <p class="text-muted small">IVA (16%) <ion-icon data-toggle="tooltip" data-placement="left" title="Desglose de I.V.A" name="information-circle-outline"></ion-icon ></p>
    </div>
    <div class="col-md-6 text-right">
        <p class="text-muted small">$ <span id="taxValue">{{ number_format($tax, 2) }}</span></p>
        <input type="hidden" name="tax_rate" value="" id="taxRate">
    </div>
    @endif

    
    <div class="border col-md-12 mb-3"></div>

    <div class="col-md-6">
        <h4>Total</h4>
    </div>
    <div class="col-md-6 text-right">
        <h4>$ <span id="totalPayment">{{ number_format($total,2) }}</span></h4>
        <input type="hidden" name="final_total" value="{{ $total }}" id="finalTotal">
    </div>
</div>