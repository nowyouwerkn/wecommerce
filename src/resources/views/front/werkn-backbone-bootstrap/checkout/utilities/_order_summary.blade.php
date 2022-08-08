<div class="card">
    <div class="card-body">
        <div class="alert alert-info d-flex justify-content-between">
            ¿Quieres editar el carrito? 
            <a href="{{ route('cart') }}">Ir al carrito</a>
        </div>

        @foreach($products as $product)
            @php
                $item_img = $product['item']['image'];
                $variant = $product['variant'];
            @endphp
            <!--List product -->
            <div class="we-co--product-list-item d-flex align-items-center">
                <div class="we-co--product-img-wrap w-25">
                    <span class="we-co--qty-circle">{{ $product['qty'] }}</span>
                    <img src="{{ asset('img/products/' . $item_img ) }}" class="img-fluid" alt="{{ $product['item']['name'] }}">
                </div>
                
                <div class="w-75 d-flex justify-content-between">
                    <div class="we-co--product-item-info">
                        <h6 class="mb-0">{{ $product['item']['name'] }}</h6>
                        <p class="mb-0">{{ $type ?? 'Variante' }}: {{ $variant }}</p>
                    </div>

                    <p>$ {{ number_format($product['price']) }}</p>
                </div>
            </div>
        @endforeach
        <div class="we-co--order-numbers mt-4">
            <div class="d-flex align-items-center justify-content-between">
                <p>Envío</p>
                
                @if($shipment_options->count() > 0)
                <p>$ <span id="shippingRate"><span class="text-info" style="font-size:.8em;">Selecciona un método</span></span></p>
                <input type="hidden" name="shipping_rate" id="shippingInput" value="">
                <input type="hidden" name="shipping_option" id="shippingOptions" value="0">
                @else
                <p>$ <span id="shippingRate">
                    @if($shipping == '0')
                    Gratis
                    @else
                    {{ number_format($shipping,2) }}
                    @endif
                </span></p>
                <input type="hidden" name="shipping_rate" id="shippingInput" value="{{ $shipping }}">
                <input type="hidden" name="shipping_option" id="shippingOptions" value="0">
                @endif
            </div>

            <hr>

            <div class="d-flex align-items-center justify-content-between">
                <p>Sub-total</p>

                <p>$ <span id="subtotal">{{ number_format($subtotal, 2) }}</span></p>
                <input type="hidden" name="sub_total" id="subtotalInput" value="{{ $subtotal }}">
            </div>

            <!-- DISCOUNT DIV -->
            @if(!empty($store_tax))
            <div class="d-flex align-items-center justify-content-between">
                <p>IVA (16%) <ion-icon class="pointer" name="information-circle-outline" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Desglose de I.V.A"></ion-icon></p>

                <p>$ <span id="taxValue">{{ number_format($tax, 2) }}</span></p>
                <input type="hidden" name="tax_rate" id="taxRate" value="{{ $tax }}">
            </div>
            @else
            {{-- 
            <div class="d-flex align-items-center justify-content-between">
                <p>IVA (16%) <ion-icon class="pointer" name="information-circle-outline" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Desglose de I.V.A"></ion-icon></p>

                <p>$ <span id="taxValue">{{ number_format($tax, 2) }}</span></p>
                <input type="hidden" name="tax_rate"  id="taxRate" value="{{ $tax }}">
            </div>
            --}}
            @endif

            <div class="d-flex align-items-center justify-content-between">
                <p>Cupones</p>

                <p>- $ <span id="discountValue">0.00</span></p>
                <input type="hidden" name="discounts" id="discount" value="" >
            </div>
            
            <div class="border mt-2 mb-3"></div>

            <div class="d-flex align-items-center justify-content-between">
                <h4>Total</h4>

                <h4>$ <span id="totalPayment">{{ number_format($total,2) }}</span></h4>
                <input type="hidden" name="final_total" value="{{ $final_total }}" id="finalTotal">
            </div>
        </div>
        
        <div class="row mt-3 text-left">
            <!-- STATUS ROW -->
            <div class="col-md-12">
                <div class="alert alert-success cp-success" style="display: none;" role="alert"></div>
                <div class="alert alert-danger cp-error" style="display: none;" role="alert">Ese cupón no existe, intenta con otro.</div>
            </div>

            <div class="col-md-12">
                <div class="input-group input-cuopon mb-3">
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Código de descuento">
                    <div class="form-group-append">
                        @if($shipment_options->count() != 0)
                        <button class="we-co--btn-coupon select-shipment-first" id="apply_cuopon" type="button">Usar Código</button>
                        @else
                        <button class="we-co--btn-coupon" id="apply_cuopon" type="button">Usar Código</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
    </div>
</div>

<div class="alert alert-danger pay-error" style="display: none;" role="alert"></div>
<button type="submit" id="btnBuy" class="btn btn-primary btn-lg mt-4 w-100 pt-3 pb-3"><ion-icon name="checkmark"></ion-icon> Confirmar Compra</button>

<p class="we-co--method">Tu pago será procesado por <span id="paymentMethod">-</span></p>

<p class="mb-2 we-co--terms-links text-center"><small>
    Al confirmar la orden, aceptas nuestras 
    @foreach($legals as $legal)
    <a href="{{ route('legal.text' , $legal->type) }}">
        @switch($legal->type)
            @case('Returns')
                Política de Devoluciones
                @break

            @case('Privacy')
                Política de Privacidad
                @break

            @case('Terms')
                Términos y Condiciones
                @break

            @case('Shipment')
                Política de Envíos
                @break

            @default
                Hubo un problema, intenta después.
        @endswitch 
    </a>,
    @endforeach
</small></p>

@if ($preference != null)
<input type="hidden" id="mp_preference" name="mp_preference" value="{{ $preference->init_point }}" />
<input type="hidden" id="mp_preference_id" name="mp_preference_id" value="{{ $preference->id }}" />
<input type="hidden" id="mp_preference_id" name="mp_preference_external" value="{{ $preference->external_reference }}" />
@endif

@push('scripts')
<script type="text/javascript">
    $('.user_invoice').on('click', function(){
        if($('.user_invoice').is(":checked")){
            $("#userInvoiceForm").fadeIn(350);
            $('#userInvoiceForm').find('input').prop('disabled', false);
            $('#userInvoiceForm').find('select').prop('disabled', false);
        }
        else{
            $("#userInvoiceForm").hide();
            $('#userInvoiceForm').find('input').prop('disabled', true);
            $('#userInvoiceForm').find('select').prop('disabled', true);
        }
    });

    /* Información de Cupón */
    $('#apply_cuopon').on('click', function(){
        event.preventDefault();
        if($(this).hasClass('select-shipment-first')){
            $('.cp-error').text('Selecciona un método de envío primero.');
            $('.cp-error').fadeIn();

            setTimeout(function () {
                $('.cp-error').fadeOut();
            }, 3000);
        }else{
            var coupon_code = $('#coupon_code').val();
            var subtotal =  parseFloat($('#subtotalInput').val());
            var shipping = parseFloat($('#shippingInput').val());
            var user_email = $('#email').val();

            $('#cp_spinner').fadeIn(500);

            $.ajax({
                method: 'POST',
                url: "{{ route('apply.cuopon') }}",
                data:{ 
                    coupon_code: coupon_code,
                    subtotal: subtotal,
                    shipping: shipping,
                    user_email: user_email,
                    _token: '{{ Session::token() }}', 
                },
                success: function(msg){
                    if (msg['type'] == 'exception') {
                        $('.cp-success').hide();
                        $('#cp_spinner').fadeOut(200);

                        console.log(msg);
                        
                        $('.cp-error').text(msg['mensaje']);
                        $('.cp-error').fadeIn();

                        setTimeout(function () {
                            $('.cp-error').fadeOut();
                        }, 3000);
                    }else{
                        $('#cp_spinner').fadeOut(200);
                        console.log(msg['mensaje']);
                        $('.cp-error').hide();
                        $('.cp-success').fadeIn();
                        $('.cp-success').text(msg['mensaje']);

                        // Definiendo Referencia de MercadoPago
                        var mp_preference = msg['mp_preference'];
                        var mp_preference_id = msg['mp_preference_id'];
                        $('#mp_preference').val(mp_preference);
                        $('#mp_preference_id').val(mp_preference_id);

                        /* Calculate Discount */
                        var discount = msg['discount'];
                        console.log(discount);
                        $('#discountValue').text(parseFloat(discount.toString().replace(/,/g, '')).toFixed(2));
                        $('#discount').val(discount);
                        //var subtotal = parseFloat($('#subtotalInput').val());

                        var shipping = msg['free_shipping'];
                        $('#shippingRate').text(shipping.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                        var total_count = subtotal - parseFloat(discount.toString().replace(/,/g, '')) + parseFloat(shipping.toString().replace(/,/g, ''));

                        var total = total_count.toString().replace(/,/g, '');
                        $('#totalPayment').text(total);

                        /* Calculate Tax */
                        var tax_rate = 0;
                        var tax = parseFloat(total_count*tax_rate).toFixed(2);
                        /* Print Tax on Screen */
                        $('#taxValue').text(tax);

                        // Clean Numbers
                        var total = total_count.toString().replace(/,/g, '');
                        var total = parseFloat(total);
                        var tax = parseFloat(tax);
                        var finaltotal = parseFloat(total + tax).toFixed(2);

                        $('#totalPayment').text(finaltotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#finalTotal').val(parseFloat(finaltotal));
                    }
                },
                error: function(msg){
                    $('.cp-success').hide();
                    $('#cp_spinner').fadeOut(200);

                    $('.cp-error').text(msg['mensaje']);
                    $('.cp-error').fadeIn();

                    setTimeout(function () {
                        $('.cp-error').fadeOut();
                    }, 3000);
                }
            });
        }
    });
</script>
@endpush