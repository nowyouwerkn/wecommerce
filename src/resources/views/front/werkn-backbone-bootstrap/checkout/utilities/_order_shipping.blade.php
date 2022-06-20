@if(!empty($shipment_options))
@php
$oldCart = Session::get('cart');
$cart = new Nowyouwerkn\WeCommerce\Models\Cart($oldCart);

// Reglas de Envios y Opciones de Envío
$shipping_rules = Nowyouwerkn\WeCommerce\Models\ShipmentMethodRule::where('is_active', true)->first();
@endphp

<div class="shipping-options row">
    @foreach($shipment_options as $option)
        @php
            if (!empty($shipping_rules)) {
                switch ($shipping_rules->type) {
                    case 'Envío Gratis':
                        $count = 0;
                        foreach ($cart->items as $product) {
                            $qty = $product['qty'];
                            $count += $qty;
                        };
                        $count;

                        $operator = $shipping_rules->comparison_operator;
                        $value = $shipping_rules->value;
                        $shipping = $option->price;

                        switch ($shipping_rules->condition) {
                            case 'Cantidad Comprada':
                                switch ($operator) {
                                    case '==':
                                        if ($cart->totalPrice == $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '!=':
                                        //dd('la cuenta NO ES IGUAL');
                                        if ($cart->totalPrice != $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '<':
                                        //dd('la cuenta es MENOR QUE');
                                        if ($cart->totalPrice < $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '<=':
                                        //dd('la cuenta es MENOR QUE O IGUAL');
                                        if ($cart->totalPrice <= $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '>':
                                        //dd('la cuenta es MAYOR QUE');
                                        if ($cart->totalPrice > $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '>=':
                                        //dd('la cuenta es MAYOR QUE O IGUAL');
                                        if ($cart->totalPrice >= $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    default:
                                        $shipping = $option->price;
                                        break;
                                }
                                break;

                            case 'Productos en carrito':
                                switch ($operator) {
                                    case '==':
                                        if ($count == $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '!=':
                                        //dd('la cuenta NO ES IGUAL');
                                        if ($count != $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '<':
                                        //dd('la cuenta es MENOR QUE');
                                        if ($count < $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '<=':
                                        //dd('la cuenta es MENOR QUE O IGUAL');
                                        if ($count <= $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '>':
                                        //dd('la cuenta es MAYOR QUE');
                                        if ($count > $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    case '>=':
                                        //dd('la cuenta es MAYOR QUE O IGUAL');
                                        if ($count >= $value) {
                                            $shipping = '0';
                                        }
                                        break;

                                    default:
                                        $shipping = $option->price;
                                        break;
                                }
                                break;

                            default:
                                $shipping = $option->price;
                                break;
                        }
                        //
                        break;

                    default:
                        $shipping = $option->price;
                        break;
                }
            }else{
                $shipping = $option->price;
            }
        @endphp
        <div class="col-6 mb-3">
            <a href="javascript:void(0)" data-value="{{ $option->id }}" data-type="{{ $option->type }}" price-value="{{ $option->price }}" id="option{{ $option->id }}" class="card card-body shipping-card h-100">
                <div class="d-flex align-items-center">
                    <div class="shipping-icon">
                        @if($option->icon != NULL)
                        <img src="{{ asset('img/' . $option->icon) }}" alt="{{ Str::slug($option->name) }}" width="40">
                        @else
                        <img src="{{ asset('assets/img/package.png') }}" alt="{{ Str::slug($option->name) }}" width="40">
                        @endif
                    </div>

                    <div class="shipping-info"> 
                        <label class="title-shipping">{{ $option->name }}</label>
                        <p class="mb-1" class="delivery-time">{{ $option->delivery_time }}</p>

                        @if($option->price != 0)
                            @if($shipping == '0')
                            <h6 class="price price-free">GRATIS</h6>
                            @else
                            <h6 class="price">$ {{ number_format($shipping,2) }} </h6>
                            @endif
                        @else
                            <h6 class="price price-free">GRATIS</h6>
                        @endif

                        @if($option->location != null)
                        <small class="text-muted">{{ $option->location }}</small>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endif