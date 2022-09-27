<div class="card">
    <div class="card-body">
        @if(!empty($products))
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
        @else
            <!--List product -->
            <div class="we-co--product-list-item d-flex align-items-center">
                <div class="we-co--product-img-wrap w-25">
                    <img src="{{ asset('img/products/' . $subscription->image) }}" class="img-fluid" alt="{{ $subscription->name }}">
                </div>

                <div class="w-75 d-flex justify-content-between">
                    <div class="we-co--product-item-info">
                        <h6 class="mb-0">{{ $subscription->name }}</h6>
                        <p class="mb-0">
                            {{ $subscription->payment_frequency_qty ?? '1' }}
                            @switch($subscription->payment_frequency)
                                @case('daily')
                                Día(s)
                                @break

                                @case('weekly')
                                Semana(s)
                                @break

                                @case('monthly')
                                Mes(es)
                                @break

                                @case('yearly')
                                Año(s)
                                @break
                            @endswitch
                        </p>
                    </div>

                    @if($subscription->has_discount == true)
                    <p>$ {{ number_format($subscription->discount_price) }}</p>
                    @else
                    <p>$ {{ number_format($subscription->price) }}</p>
                    @endif
                </div>
            </div>

            @if($subscription->time_for_cancellation == NULL)
            <div class="alert alert-info d-flex justify-content-between mt-3">
                <div>
                    <strong>Este cobro es recurrente.</strong> Tu siguiente fecha de pago será:
                     @switch($subscription->payment_frequency)
                        @case('daily')
                        {{ Carbon\Carbon::now()->addDays($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                        @break

                        @case('weekly')
                        {{ Carbon\Carbon::now()->addWeeks($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                        @break

                        @case('monthly')
                        {{ Carbon\Carbon::now()->addMonths($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                        @break

                        @case('yearly')
                        {{ Carbon\Carbon::now()->addYears($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                        @break
                    @endswitch

                    . Puedes cancelar tu suscripción en cualquier momento desde tu perfil de cliente.
                </div>
            </div>
            @else
            <div class="alert alert-info d-flex justify-content-between mt-3">
                <div>
                    <strong>Este cobro es
                        @switch($subscription->payment_frequency)
                            @case('daily')
                            diario, tu siguiente cobro es el {{ Carbon\Carbon::now()->addDays($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                            @break

                            @case('weekly')
                            semanal, tu siguiente cobro es el {{ Carbon\Carbon::now()->addWeeks($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                            @break

                            @case('monthly')
                            mensual, tu siguiente cobro es el {{ Carbon\Carbon::now()->addMonths($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                            @break

                            @case('yearly')
                            anual, tu siguiente cobro es el {{ Carbon\Carbon::now()->addYears($subscription->payment_frequency_qty)->translatedFormat('j \\de F') }}
                            @break
                        @endswitch
                    </strong>

                    . Tu suscripción termina el:
                    @switch($subscription->payment_frequency)
                        @case('daily')
                        {{ Carbon\Carbon::now()->addDays($subscription->time_for_cancellation)->translatedFormat('j \\de F') }}
                        @break

                        @case('weekly')
                        {{ Carbon\Carbon::now()->addWeeks($subscription->time_for_cancellation)->translatedFormat('j \\de F') }}
                        @break

                        @case('monthly')
                        {{ Carbon\Carbon::now()->addMonths($subscription->time_for_cancellation)->translatedFormat('j \\de F') }}
                        @break

                        @case('yearly')
                        {{ Carbon\Carbon::now()->addYears($subscription->time_for_cancellation)->translatedFormat('j \\de F') }}
                        @break
                    @endswitch

                    . Puedes renovar comprando nuevamente la suscripción al terminar el periodo.
                </div>
            </div>
            @endif
            <hr>
        @endif

        <div class="we-co--order-numbers mt-4">
            @if(!empty($products))
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
            @endif

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
            @endif

            <div class="d-flex align-items-center justify-content-between">
                <p>Cupones</p>

                <p class="position-relative">- $ <span id="discountValue">0.00</span><a id="delete_cuopon" class="delete-cuopon" href="javascript:voif(0)">X</a></p>
                <input type="hidden" name="discounts" id="discount" value="">
            </div>

            <div class="border mt-2 mb-3"></div>

            <div class="d-flex align-items-center justify-content-between">
                <h4>Total</h4>

                <h4>$ <span id="totalPayment">{{ number_format($total,2) }}</span></h4>
                <input type="hidden" name="final_total" value="{{ $final_total }}" id="finalTotal">
            </div>

            @php
                $membership = Nowyouwerkn\WeCommerce\Models\MembershipConfig::where('is_active', true)->first();
            @endphp

            @if(!empty($membership))
            <div class="d-flex align-items-center justify-content-between">
                <p>Puntos por acumular</p>

                <p><span id="earnedPoints">{{ $points }}</span></p>
            </div>
            @endif
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
                        @if(!empty($products))
                            @if($shipment_options->count() != 0)
                            <button class="we-co--btn-coupon select-shipment-first" id="apply_cuopon" type="button">Usar Código</button>
                            @else
                            <button class="we-co--btn-coupon" id="apply_cuopon" type="button">Usar Código</button>
                            @endif
                        @else
                            <button class="we-co--btn-coupon" id="apply_cuopon" type="button">Usar Código</button>
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($membership))

            <style>
                .range-input {
                padding:10px 20px;
                display:flex;
                align-items:center;
                border-radius:10px;
                width: 100%;
                justify-content: space-between
                }
                .range-input input {
                -webkit-appearance:none;
                width:200px;
                height:2px;
                background:#4471ef;
                border:none;
                outline:none;
                }
                .range-input input::-webkit-slider-thumb {
                -webkit-appearance:none;
                width:20px;
                height:20px;
                background:#eee;
                border:2px solid #4471ef;
                border-radius:50%;
                }
                .range-input input::-webkit-slider-thumb:hover {
                background:#4471ef;
                }
                .range-input .value {
                color:#4471ef;
                text-align:center;
                font-weight:600;
                line-height:40px;
                height:40px;
                overflow:hidden;
                margin-left:10px;
                }
                .range-input .value div {
                transition:all 300ms ease-in-out;
                }
            </style>

                @if ($valid < 10)
                <div class="col-md-12">
                    <div class="bg-secondary bg-opacity-10">
                        <div class="p-3">
                            <h6 class="fw-semiBold">No tienes los puntos suficientes para utilizar en tu compra</h6>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-md-12">
                    <div class="bg-secondary bg-opacity-10">
                        <div class="p-3">
                            <h6 class="fw-semiBold">Paga con puntos</h6>
                        </div>
                        <div class="range-input">
                            <input type="range" id="points" min="0" max="{{ $valid }}" value="0" step="10">
                            <div class="value">
                                <div></div>
                            </div>
                            <button class="we-co--btn-coupon select-shipment-first" id="apply_points" type="button">Canjear</button>
                        </div>
                        <div class="p-3">
                            <p>Desliza el slider para determinar los puntos a usar</p>
                        </div>
                        <input type="text" name="points_to_apply" id="points_to_apply" hidden>
                        <input type="text" value="{{ $point_disc }}" id="point_value" hidden>
                        <input type="text" name="points" hidden id="points_discount">
                    </div>
                </div>
                @endif
            @endif

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
            var tax_rateIn = parseFloat($('#taxRate').val());
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

                        if (isNaN(shipping)) {
                            console.log('si es falso');

                            var subtotal_tax = subtotal + tax_rateIn;

                            var total_count = subtotal_tax - parseFloat(discount.toString().replace(/,/g, ''));

                            $('#subtotal').text(subtotal_tax.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#subtotalInput').val(subtotal_tax);

                            $('#apply_cuopon').attr('disabled', 'disabled');
                            $('.delete-cuopon').show();
                        } else {
                            console.log('no es falso');

                            var sub_total_sh = subtotal + tax_rateIn;
                            $('#subtotal').text(sub_total_sh.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            $('#subtotalInput').val(sub_total_sh);

                            var total_count = sub_total_sh - parseFloat(discount.toString().replace(/,/g, ''));

                            var total = total_count.toString().replace(/,/g, '');
                            $('#totalPayment').text(total);
                            $('#apply_cuopon').attr('disabled', 'disabled');
                            $('.delete-cuopon').show();
                        }

                        /* Calculate Tax */
                        var tax_rate = 0;
                        var tax = parseFloat(total_count*tax_rate).toFixed(2);
                        /* Print Tax on Screen */
                        $('#taxValue').text(tax);
                        $('#taxRate').val(tax);

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

<script>
    $('#delete_cuopon').on('click', function(){
        event.preventDefault();
        var discount = 0;
        var coupon_code = $('#coupon_code').val();
        var subtotal =  parseFloat($('#subtotalInput').val());
        var shipping = parseFloat($('#shippingInput').val());
        var tax_rateIn = parseFloat($('#taxRate').val());
        var subtotal =  parseFloat($('#subtotalInput').val());
        var final_s = parseFloat($('#finalTotal').val());

        /* Calculate Tax */
        var tax_rate = (subtotal) - (subtotal / 1.16);
        var tax = parseFloat(tax_rate).toFixed(2);
        /* Print Tax on Screen */
        $('#taxValue').text(tax);
        $('#taxRate').val(tax);

        console.log(subtotal);

        console.log(tax);

        console.log(subtotal - tax);

        /*Subtotal*/
        var subtotal_f = parseFloat(subtotal - tax).toFixed(2);
        $('#subtotal').text(subtotal_f.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#subtotalInput').val(subtotal_f);

        // Clean Numbers
        var total_count = subtotal_f;
        var total = total_count.toString().replace(/,/g, '');
        var total = parseFloat(total);
        var tax = parseFloat(tax);
        var finaltotal = parseFloat(total + tax).toFixed(2);

        $('#totalPayment').text(finaltotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#finalTotal').val(parseFloat(finaltotal));


        $('#discountValue').text(parseFloat(discount.toString().replace(/,/g, '')).toFixed(2));
        $('#discount').val(discount);
        $('.cp-success').fadeOut();
        $('#coupon_code').val("");
        $('#apply_cuopon').removeAttr('disabled', 'disabled');
        $('.delete-cuopon').hide();
    });
</script>

<script>
    let rangeInput = document.querySelector(".range-input input");
    let rangeValue = document.querySelector(".range-input .value div");

    let start = parseFloat(rangeInput.min);
    let end = parseFloat(rangeInput.max);
    let step = parseFloat(rangeInput.step);

    for(let i=start;i<=end;i+=step){
        rangeValue.innerHTML += '<div>'+i+'</div>';
    }

    rangeInput.addEventListener("input",function(){
        let top = parseFloat(rangeInput.value)/step * -40;
        rangeValue.style.marginTop = top+"px";
    });
</script>

<script>
    $('#apply_points').on('click', function(){
        event.preventDefault();

        if($(this).hasClass('select-shipment-first')){
            $('.cp-error').text('Selecciona un método de envío primero.');
            $('.cp-error').fadeIn();

            setTimeout(function () {
                $('.cp-error').fadeOut();
            }, 3000);

        }else{
            var subtotal =  parseFloat($('#subtotalInput').val());
            var shipping = parseFloat($('#shippingInput').val());

            var final_s = parseFloat($('#finalTotal').val());

            $use_points = $("#points").val();
            $point_disc = $("#point_value").val();
            $points = $use_points * $point_disc;

            $("#points_to_apply").val($points);

            if ($points > 0) {
                $("#coupon_code").attr("disabled", true);
                $("#apply_coupon").attr("disabled", true);

                //CALCULAR DESCUENTO
                $('#discountValue').text(parseFloat($points.toString().replace(/,/g, '')).toFixed(2));
                $("#points_discount").val($points);

                var total_count = final_s - parseFloat($points.toString().replace(/,/g, ''));

                var total = total_count.toString().replace(/,/g, '');
                $('#totalPayment').text(total);

                /* Calculate Tax */
                var tax_rate = 0;
                var tax = parseFloat(total_count*tax_rate).toFixed(2);
                /* Print Tax on Screen */
                $('#taxValue').text(tax);
                $('#taxRate').val(0);

                // Clean Numbers
                var total = total_count.toString().replace(/,/g, '');
                var total = parseFloat(total);
                var tax = parseFloat(tax);
                var finaltotal = parseFloat(total + tax).toFixed(2);

                $('#totalPayment').text(finaltotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#finalTotal').val(parseFloat(finaltotal));

            } else {
                $("#coupon_code").attr("disabled", false);
                $("#apply_coupon").attr("disabled", false);


                var total_count = subtotal * 1.16;

                var total = total_count.toString().replace(/,/g, '');
                $('#totalPayment').text(total);

                /* Calculate Tax */
                var tax_rate = 0;
                var tax = parseFloat(total_count-subtotal).toFixed(2);
                /* Print Tax on Screen */
                $('#taxValue').text(tax);
                $('#taxRate').val(tax);

                // Clean Numbers
                var total = total_count.toString().replace(/,/g, '');
                var total = parseFloat(total);
                var tax = parseFloat(tax);
                var finaltotal = parseFloat(total_count).toFixed(2);

                $('#totalPayment').text(finaltotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#finalTotal').val(parseFloat(finaltotal));
            }

        }
    });
</script>
@endpush
