@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<style type="text/css">

    .modal{
        z-index: 999999;
    }

    .close-modal{
        position: absolute;
        top: 0;
        right: 0;
        z-index: 999999999;
        font-size: 2rem;
        pointer-events: all;
        background-color: var(--color-purple);
        color: var(--color-white);
        border:none;
        padding: 1rem;    
    }

    .margin-top {
        margin-top: 40px;
    }

</style>
@endpush

@section('content')

<section class="margin-top">
    <div class="container">
        <!-- title -->
        <div class="row">
            <div class="col-md-12">
                <div class="title_image">
                    <div class="title_image__info">
                        <h1>Tu Carrito de compra</h1>
                        <p >Tu elección</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- cart -->
        <div class="row mt-5">
            @if(Session::has('cart'))
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
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
                                            <a href="{{ route( 'cart.substract', [ 'id' => $product['item']['id'], 'variant' => $product['variant'] ] ) }}" class="btn btn_custom--purple d-flex align-items-center">-</a>
                                            <p class="btn d-flex align-items-center h-100">{{ $product['qty'] }}</p>
                                            <a href="{{ route( 'cart.add-more', [ 'id' => $product['item']['id'], 'variant' => $product['variant'], 'qty' => $product['qty'] ] ) }}" class="btn btn_custom--purple d-flex align-items-center">+</a>
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

                <div class="d-flex justify-content-between my-5 cart_info">
                    <div class="col-4 card px-4 pt-3 pb-3">

                        @php
                            $card_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', '!=','Paypal')->where('type', 'card')->where('is_active', true)->first();
                            $cash_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('type', 'cash')->where('is_active', true)->first();
                            $paypal_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', 'Paypal')->where('is_active', true)->first();
                            $mercado_payment = Nowyouwerkn\WeCommerce\Models\PaymentMethod::where('supplier', 'MercadoPago')->where('is_active', true)->first();
                        @endphp

                        <div class="list_custom">
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

                    <div class="col-4 card px-4 pt-3 pb-3">
                        <p class="subtitle">Total del Carrito</p>
                        <div class="list_custom">
                            <form action="#">
                                <ul class="list_custom__block">
                                    <li class="list_custom__item d-flex justify-content-between">
                                        <span class="subtitle">Subtotal</span> ${{ number_format($subtotal,2) }}
                                    </li>

                                    <li class="list_custom__item d-flex justify-content-between">
                                        <span class="subtitle">Envío</span>
                                        @if($shipping == '0')
                                        Gratis
                                        @else
                                        ${{ number_format($shipping,2) }}
                                        @endif
                                    </li>

                                    <li class="list_custom__item d-flex justify-content-between">
                                        <span class="subtitle">Total</span> <span class="amount">${{ number_format($total,2) }}</span>
                                    </li>
                                </ul>
                                
                    
                                                
                           
                                    <a class="btn btn-primary mb-2 w-100 btn_icon" href="{{ route('checkout') }}">
                                        <ion-icon name="cash-outline"></ion-icon> Completar pago
                                    </a>
                               
                               
                                
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-6 offset-md-3 mt-5 text-center">
                    <p class="filter__title">No hay productos en el carrito</p>
                    <p class="filter__info">
                        <a href="{{ route('catalog.all') }}" class="btn btn_custom btn_custom--purple">¡Empieza a llenarlo!</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
        <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
     <button type="button" class="close-modal" data-bs-dismiss="modal">&times;</button>
      <!-- Modal content-->
      <div class="modal-content">
            <div class="row">
    
      <div class="col-12">
        <div class="modal-title">
          
            <h2>¡Llena tu informacion para seguir con tu compra!</h2>
            <hr>
           
           
        </div>
        
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('scripts')

@endpush