@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')

<section class="wk-cart-wrapper">
    <div class="container">
        <!-- title -->
        <div class="row">
            <div class="col-md-12">
                <div class="wk-cart-title">
                    <h1>Tu Carrito de compra</h1>
                    <p>Tu elección</p>
                </div>
            </div>
        </div>

        <!-- cart -->
        <div class="row mt-5">
            @if(Session::has('cart'))
            <div class="col-12">
                <div class="wk-cart-table d-flex justify-content-between">
                    <p class="mb-0 flex-shrink-0" style="width:100px;">Producto</p>
                    <p class="mb-0 flex-grow-1 ms-3">Descripción</p>
                    <p class="mb-0 text-end">Total</p>
                </div>

                <ul class="wk-cart-item list-unstyled">
                    @foreach($products as $cart_product)
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

                                <div class="wk-desc-list mt-1" style="font-size:.8em !important;">
                                    @if($cart_product['item']['color'] != NULL)
                                    <p class="mb-0">Color: {{ $cart_product['item']['color'] }}</p>
                                    @endif
                                    <p class="mb-0">Cantidad: {{ $cart_product['qty'] }}</p>
                                    <p class="mb-0">Talla: {{ $variant }}</p>
                                </div>

                                <div class="btn-group align-items-center">
                                    @if($cart_product['qty'] == 1)
                                    @else
                                    <a href="{{ route( 'cart.substract', [ 'id' => $cart_product['item']['id'], 'variant' => $cart_product['variant'] ] ) }}" class="btn btn-qty">-</a>
                                    @endif
                                    <p class="h-100 mb-0 px-2">{{ $cart_product['qty'] }}</p>
                                    <a href="{{ route( 'cart.add-more', [ 'id' => $cart_product['item']['id'], 'variant' => $cart_product['variant'], 'qty' => $cart_product['qty'] ] ) }}" class="btn btn-qty">+</a>
                                </div>
                            </div>

                            <div class="wk-total-list text-end">
                                <a href="{{ route( 'cart.delete', ['id' => $cart_product['item']['id'], 'variant' => $variant ] ) }}" class="btn btn-danger btn-sm">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a>

                                <p class="mb-0">$ {{ number_format($cart_product['price'], 2) }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                {{-- 
                <div class="table-responsive">
                    <table class="table align-middle mb-4">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            @php
                                $item_img = $product['item']['image'];
                                $variant = $product['variant'];
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('catalog.all') }}">
                                        <img src="{{ asset('img/products/' . $item_img ) }}" alt="" width="100">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('catalog.all') }}" class="title_small">
                                        {{ $product['item']['name'] }}
                                    </a>
                                    <p class="subtitle">Talla: {{ $variant }}</p>
                                </td>
                                @if($product['item']['has_discount'] == true)
                                    <td>${{ number_format($product['item']['discount_price'],2) }}</td>
                                @else
                                    <td>${{ number_format($product['item']['price'],2) }}</td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                          @if($product['qty'] == 1)
                                        @else
                                        <a href="{{ route( 'cart.substract', [ 'id' => $product['item']['id'], 'variant' => $product['variant'] ] ) }}" class="btn d-flex align-items-center">-</a>
                                         @endif
                                        <p class="btn d-flex align-items-center h-100">{{ $product['qty'] }}</p>
                                        <a href="{{ route( 'cart.add-more', [ 'id' => $product['item']['id'], 'variant' => $product['variant'], 'qty' => $product['qty'] ] ) }}" class="btn d-flex align-items-center">+</a>
                                    </div>
                                </td>
                                <td><span>$ {{ number_format($product['price'], 2) }} </span></td>

                                <td>
                                    <a href="{{ route( 'cart.delete', ['id' => $product['item']['id'], 'variant' => $variant ] ) }}" class="btn">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                --}}
            </div>

            <div class="col-12">
                <div class="row justify-content-between wk-cart-info">
                    <div class="col-12 col-md-4 order-5 order-md-1">
                        @php
                            $card_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', '!=','Paypal')->where('type', 'card')->where('is_active', true)->first();
                            $cash_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
                            $paypal_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();
                            $mercado_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();
                        @endphp

                        <div class="card px-4 pt-3 pb-3 mb-4">
                            <div class="row">
                                @if(!empty($card_payment))
                                    <div class="col-6">
                                        <img src="{{ asset('img/icons/card-info.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        <p>Aceptamos Todas las Tarjetas de Crédito</p>
                                    </div>
                                @endif

                                <div class="col-6">
                                    <!--<img src="{{ asset('img/icons/ssl.png') }}">-->
                                    <div style="width: 90%; height: 50px;">
                                        <script type="text/javascript"> //<![CDATA[
                                            var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
                                            document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
                                        //]]></script>
                                        <script language="JavaScript" type="text/javascript">
                                            TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_md_167x42.png", "POSDV", "none");
                                        </script>
                                    </div>
                                    <p>Sitio Seguro con Encriptación de 256-Bits</p>
                                </div>

                                @if(!empty($paypal_payment))
                                    <div class="col-6 mt-4">
                                        <img src="{{ asset('assets/img/brands/paypal.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        <p>Aceptamos pagos por medio de Paypal</p>
                                    </div>
                                @endif

                                @if(!empty($mercado_payment))
                                    <div class="col-6 mt-4">
                                        <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        <p>Aceptamos pagos por medio de MercadoPago</p>
                                    </div>
                                @endif

                                @if(!empty($cash_payment))
                                    <div class="col-6 mt-4">
                                        <img src="{{ asset('assets/img/brands/oxxopay.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        <p>Aceptamos pagos en efectivo en Oxxo</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 order-md-5">
                        <div class="card px-4 pt-3 pb-3 mb-3">
                            <h5>Total del Carrito</h5>
                            <div class="list_custom">
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span class="subtitle">Subtotal</span> ${{ number_format($subtotal,2) }}
                                    </li>

                                    <li class="d-flex justify-content-between">
                                        <span class="subtitle">Envío</span>
                                        @if($shipping == '0')
                                        Gratis
                                        @else
                                        ${{ number_format($shipping,2) }}
                                        @endif
                                    </li>

                                    @php
                                    $rule = Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule::where('is_active', true)->first();
                                    @endphp

                                    @if (!empty($rule))
                                    <div class="alert alert-info d-block">
                                        <span style="margin-right: 2px"><strong>{{ $rule->type }}</strong></span>
                                        <span style="margin-right: 2px">cuando <strong>{{ $rule->condition }}</strong> sea</span>
                                        <span style="margin-right: 2px">
                                        <strong>
                                        @switch($rule->comparison_operator)
                                            @case('==')
                                                igual a
                                                @break

                                            @case('!=')
                                                no igual a
                                                @break

                                            @case('<')
                                                menor que
                                                @break

                                            @case('<=')
                                                menor que o igual a
                                                @break

                                            @case('>')
                                                mayor que
                                                @break

                                            @case('>=')
                                                mayor que o igual a
                                                @break

                                            @default
                                                Error. Elimina esta regla.
                                        @endswitch
                                        </strong>
                                        </span>

                                        <span style="margin-right: 2px"><strong>{{ number_format($rule->value) }}</strong></span> 
                                    </div>
                                    @endif

                                    <p class="mt-2 mb-3"><strong>Aplica cupones en el siguiente paso.</strong></p>

                                    <li class="d-flex justify-content-between">
                                        <span class="subtitle">Total</span> <span class="amount">${{ number_format($total,2) }}</span>
                                    </li>
                                </ul>

                                <div class="row">
                                    @if(!empty($card_payment))
                                    <div class="col-12">
                                        <a class="btn btn-primary mb-2 w-100 btn_icon" style="padding: 15px;" href="{{ route('checkout') }}">
                                            <ion-icon name="cash-outline"></ion-icon> Completar pago
                                        </a> 
                                    </div>
                                    @endif

                                    @if(!empty($paypal_payment))
                                    <div class="col pe-1">
                                        <a class="btn btn-light mb-2 w-100 btn_icon" href="{{ route('checkout') }}">
                                            <img src="{{ asset('assets/img/brands/paypal.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        </a> 
                                    </div>
                                    @endif

                                    @if(!empty($mercado_payment))
                                    <div class="col ps-1">
                                        <a class="btn btn-light mb-2 w-100 btn_icon" href="{{ route('checkout') }}">
                                            <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        </a>
                                    </div>
                                    @endif

                                    @if(!empty($cash_payment))
                                    <div class="col-12">
                                        <a class="btn btn-light mb-2 w-100 btn_icon" href="{{ route('checkout') }}">
                                            <img src="{{ asset('assets/img/brands/oxxopay.png') }}" style="padding-top: 10px; margin-bottom: 5px; height: 35px; width: auto !important;">
                                        </a> 
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('catalog.all') }}" class="btn btn-link text-center d-block mb-5">Seguir comprando</a>
                    </div>
                </div>
            </div>
            @else
                <div class="col-md-6 offset-md-3 mt-5 text-center">
                    <p class="filter__title">No hay productos en el carrito</p>
                    <p class="filter__info">
                        <a href="{{ route('catalog.all') }}" class="btn btn-secondary">¡Empieza a llenarlo!</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')

@endpush