<div class="card card-order mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="card-order-title">Orden #00{{ $order->id }}</h3>

            <div class="card-order-status">
                <div class="progress">
                        @if($order->status == 'Pagado')
                        <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                        @endif

                        @if($order->status == 'Empaquetado')
                        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                        @endif

                        @if($order->status == 'Enviado')
                        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;" data-toggle="tooltip" data-placement="top" title="Progreso">

                            <span class="tracking-type">
                                <h5>Número de Rastreo</h5>
                                <p class="mb-0">
                                    @if($order->trackings->count())
                                        @foreach($order->trackings as $tracking)
                                            {{ $tracking->tracking_number }}
                                        @endforeach
                                    @else
                                    <div class="text-center my-5">
                                        <p class="mb-0">¡Todavía no se asigna una guía para esta orden!</p>
                                    </div>
                                    @endif
                                </p>
                            </span>
                        @endif

                        @if($order->status == 'Entregado')
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                        @endif

                        <span class="progress-type"><i class="box-icon-order"></i></span>
                    </div>
                </div>

                <div class="progress-meter">
                    <div class="meter meter-left" style="width: 25%;"><span class="meter-text">Pagado</span></div>
                    <div class="meter meter-left" style="width: 25%;"><span class="meter-text">Empaquetado</span></div>
                    <div class="meter meter-right" style="width: 25%;"><span class="meter-text">Enviado</span></div>
                    <div class="meter meter-right" style="width: 25%;"><span class="meter-text">Entregado</span></div>
                </div>
            </div>
        </div>

        <h6 class="title-order-separator">Resumen de tu Orden</h6>

        @if($order->cart == NULL)
        <p class="alert alert-warning">No es posible mostrar la información del carrito en este momento.</p>
        @else
            @foreach($order->cart->items as $product)
            @php
                $item_img = $product['item']['image'];
                $variant = $product['variant'];
            @endphp

            <div class="product-checkout-line">
                <div class="row align-items-center">
                    <div class="col-5 text-left">
                        <div class="row align-items-center">
                            <div class="col">
                                <img class="mr-4" style="width: 100px;" src="{{ asset('img/products/' . $item_img ) }}" alt="{{ $product['item']['name'] }}">
                            </div>
                            <div class="col">
                                <h5 class="mt-0 mb-0">{{ $product['item']['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2 text-center">
                        <h5 class="mb-0"><span>Talla:</span><br> {{ $variant }}</h5>
                    </div>
                    <div class="col col-md-2 text-center">
                        <h5 class="mb-0"><span>Cantidad:</span><br> {{ $product['qty'] }}</h5>
                    </div>
                    <div class="col-2 hid text-right">
                        <p class="mb-0">$ {{ number_format($product['price']) }} </p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        <hr>
        <div class="row">
            <div class="col text-right">
                <h5 class="price-order">Total: $ {{ $order->cart_total }}</h5>
            </div>
        </div>

        <div class="order-info">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="bg-primary text-white">
                        <h6 class="title-order-separator">Método de Pago</h6>
                        <p class="order-info-big">
                            @if($order->payment_method == 'Paypal')
                            <i class="fab fa-paypal"></i>
                            @else
                                <i class="fas fa-credit-card"></i>
                            @endif

                            {{ $order->payment_method }}
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="">
                        @if(substr($order->payment_id, 0, 3) == 'ord')
                        <h6 class="title-order-separator">Número</h6>
                        @else
                        <h6 class="title-order-separator">Referencia</h6>
                        @endif
                        <p class="order-info-big">
                            @if(substr($order->payment_id, 0, 3) == 'ord')
                            **** **** **** {{ $order->card_digits }}
                            @else
                            {{ wordwrap($order->payment_id, 4, "-", true) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h6 class="title-order-separator">Dirección de Envío</h6>
                <p>{{ $order->street }} {{ $order->street_num }}, {{ $order->city }} {{ $order->state }}, {{ $order->country }}, C.P {{ $order->postal_code }}</p>
            </div>
            <div class="col-md-6 text-right">
                <h6 class="title-order-separator">Fecha de Compra</h6>
                <p>{{ Carbon\Carbon::parse($order->created_at)->format('d M Y, h:ia') }}</p>
            </div>
        </div>
    </div>
</div>