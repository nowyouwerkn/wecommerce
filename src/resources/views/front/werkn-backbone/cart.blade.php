@extends('front.theme.werkn-backbone.layouts.main')

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
                                    <td class="product-thumbnail"><a href="{{ route('catalog.all') }}"><img src="{{ asset('img/products/' . $item_img ) }}" alt=""></a></td>
                                    <td class="product-name">
                                        <h4><a href="{{ route('catalog.all') }}">{{ $product['item']['name'] }}</a></h4>
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
                                            <a href="{{ route( 'cart.add-more', [ 'id' => $product['item']['id'], 'variant' => $product['variant'] ] ) }}" class="btn btn-qty btn-outline-secondary">+</a>
                                        </div>
                                    </td>
                                    <td class="product-subtotal"><span>$ {{ number_format($product['price'], 2) }} </span></td>

                                    <td class="product-delete"><a href="{{ route( 'cart.delete', ['id' => $product['item']['id'], 'variant' => $variant ] ) }}"><i class="far fa-trash-alt"></i></a></td>
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
                                <li class="sub-total"><span>Subtotal</span> ${{ number_format($subtotal) }}</li>
                                <li class="sub-total"><span>Impuestos</span> ${{ number_format($tax) }}</li>
                                <!--
                                <li>
                                    <span>SHIPPING</span>
                                    <div class="shop-check-wrap">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">FLAT RATE: $15</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">FREE SHIPPING</label>
                                        </div>
                                        <a href="#" class="calculate">Calculate shipping</a>
                                    </div>
                                </li>
                                -->
                                <li class="cart-total-amount"><span>Total</span> <span class="amount">${{ number_format($totalPrice) }}</span></li>
                            </ul>
                        
                            <a href="{{ route('checkout') }}" class="btn">PAGAR</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area-end -->
@endsection

@push('scripts')

@endpush