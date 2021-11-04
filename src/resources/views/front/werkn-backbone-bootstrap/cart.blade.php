@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">
    .cart-total .shop-cart-widget form ul li > span{
        width: 50%;
    }

    .cart-total .shop-cart-widget{
        width: 30%;
    }
</style>
@endpush

@section('content')
<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('themes/werkn-backbone/img/bg/s_breadcrumb_bg01.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2>Carrito de Compra</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Carrito de Compra</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->

@if(Session::has('cart'))
<!-- cart-area -->
<div class="cart-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-wrapper">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail"></th>
                                    <th class="product-name">Producto</th>
                                    <th class="product-price">Precio</th>
                                    <th class="product-quantity">Cantidad</th>
                                    <th class="product-subtotal">Subtotal</th>
                                    <th class="product-delete"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                @php
                                    $item_img = $product['item']['image'];
                                    $variant = $product['variant'];
                                @endphp
                                <tr>
                                    <td class="product-thumbnail"><a href="{{ route('detail', [$product['item']['category']['slug'], $product['item']['slug']]) }}">
                                        <img src="{{ asset('img/products/' . $item_img ) }}" alt=""></a></td>
                                    <td class="product-name">
                                        <h4><a href="{{ route('detail', [$product['item']['category']['slug'], $product['item']['slug']]) }}">{{ $product['item']['name'] }}</a></h4>
                                        <p class="mb-2">Talla: {{ $variant }}</p>
                                    </td>
                                    @if($product['item']['has_discount'] == true)
                                    <td class="product-price">${{ number_format($product['item']['discount_price'],2) }}</td>
                                    @else
                                    <td class="product-price">${{ number_format($product['item']['price'],2) }}</td>
                                    @endif
                                    <td class="product-quantity">
                                        <div class="btn-group">
                                            <a href="{{ route( 'cart.substract', [ 'id' => $product['item']['id'], 'variant' => $product['variant'] ] ) }}" class="btn btn-qty btn-outline-secondary">-</a>
                                            <p class="btn btn-qty btn-link mb-0">{{ $product['qty'] }}</p>
                                            <a href="{{ route( 'cart.add-more', [ 'id' => $product['item']['id'], 'variant' => $product['variant'], 'qty' => $product['qty'] ] ) }}" class="btn btn-qty btn-outline-secondary">+</a>
                                        </div>
                                    </td>
                                    <td class="product-subtotal"><span>$ {{ number_format($product['price'], 2) }} </span></td>

                                    <td class="product-delete"><a href="{{ route( 'cart.delete', ['id' => $product['item']['id'], 'variant' => $variant ] ) }}"><i class="far fa-trash-alt">borrar</i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--
                    <div class="shop-cart-bottom mt-20">
                        <div class="cart-coupon">
                            <form action="#">
                                <input type="text" placeholder="Enter Coupon Code...">
                                <button class="btn">Apply Coupon</button>
                            </form>
                        </div>
                        <div class="continue-shopping">
                            <a href="shop.html" class="btn">update shopping</a>
                        </div>
                    </div>
                    -->
                </div>
                <div class="cart-total pt-95" style="display:flex; justify-content: space-between;">
                    <h3 class="title">Total del Carrito</h3>

                    <div class="shop-cart-widget" style="display:inline-block;">
                        <form action="#">
                            <ul>
                                <li class="sub-total"><span>Subtotal</span> ${{ number_format($subtotal,2) }}</li>
                            
                                <li class="sub-total"><span>Impuestos</span> ${{ number_format($tax,2) }}</li>
                                
                                <li class="sub-total">
                                    <span>Envío</span>
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

                                <li class="cart-total-amount"><span>Total</span> <span class="amount">${{ number_format($total,2) }}</span></li>
                            </ul>
                            
                            <a class="btn mt-2" href="{{ route('checkout') }}">Continuar tu compra</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area-end -->
@else
<div class="container shopping-cart color-wrap py-5">
    <div class="row">
        <div class="col-md-6 ml-auto mr-auto text-center my-5">
            <h2>No hay productos en el carrito.<i class="fa fa-frown-o"></i></h2>
            <br>
            <a href="{{ route('catalog.all') }}" class="btn btn-lg btn-primary">¡Empieza a llenarlo!</a>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')

@endpush