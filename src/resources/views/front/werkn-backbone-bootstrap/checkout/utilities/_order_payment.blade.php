<div class="row">
    <div class="col-md-12">
        @if(!empty($card_payment))
        <div class="card mb-2">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio_card" checked="" data-option="tarjeta">
                    <label class="form-check-label" for="paymentRadio_card">
                        Tarjeta de Crédito o Débito
                    </label>
                </div>

                <img src="{{ asset('img/icons/card-info.png') }}" style="height: 25px; width: auto !important;">
            </div>
            <div id="cardInfo" class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="card-number">Número de Tarjeta <span class="text-danger">*</span></label>
                                <input type="text" id="card-number" name="card_number" class="card-input form-control form-control" data-parsley-trigger="change" value="{{ old('card_number') }}" required="">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="card-name">Nombre en la Tarjeta <span class="text-danger">*</span> </label>
                                <input type="text" id="card-name" name="card-name" class="form-control form-control" value="{{ old('card-name') }}" data-parsley-trigger="change" required="">
                            </div>

                            <div class="col-4 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="card-month">Mes <span class="text-danger">*</span></label>
                                    <input type="text" id="card-month" name="card-month" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" value="{{ old('card-month') }}" required="">
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="card-year">Año <span class="text-danger">*</span></label>
                                    <input type="text" id="card-year" name="card-year" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" value="{{ old('card-year') }}" required="">
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="card-ccv">CCV <span class="text-danger">*</span></label>
                                    <input type="text" id="card-cvc" name="card-cvc" class="form-control form-control" data-parsley-trigger="change" required="" value="{{ old('card-cvc') }}" maxlength="4">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="center mb-3">
                            <div class="card-wrapper"></div>    
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-0 mt-3">
                            <input type="hidden" name="billing_shipping" value="false">
                            <label><input class="billing_check" type="checkbox" name="billing_shipping" value="true">  La dirección de facturación es diferente que la dirección de envio</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="billingForm" class="row mt-3" style="display:none;">
                            <div class="col-md-12 ">
                                <hr>
                                <div style="font-size: .8em; font-weight: bold;">
                                    <p class="text-uppercase mb-0">Dirección de Facturación de la tarjeta</p>
                                </div>
                                <hr>

                                <div class="row mt-4">
                                    <div class="col-12 col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="street_billing" name="street_billing" value="{{ $address->street ?? '' }}"/>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="street_num_billing" name="street_num_billing" value="{{ $address->street_num ?? '' }}"/>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="last-name">Int </label>
                                            <input type="text" class="form-control" id="int_num_billing" name="int_num_billing" value="{{ $address->int_num ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="postal_code_billing" name="postal_code_billing" value="{{ $address->postal_code ?? '' }}"/>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                                            <select class="form-control form-control" id="country_billing" name="country_billing">
                                                <option value="México" selected="">México</option>
                                            </select>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="state">Estado <span class="text-danger">*</span></label>
                                            @php
                                                $states = Nowyouwerkn\WeCommerce\Models\State::all();
                                            @endphp
                                            <select class="form-control" id="state_billing" name="state_billing" data-parsley-trigger="change" required="">
                                                @foreach($states as $state)
                                                    @if(!empty($address))
                                                        <option {{ ($state->name == $address->state) ? 'selected' : '' }} value="{{ $state->name }}">{{ $state->name }}</option>
                                                    @else
                                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <!--      
                                            <input type="text" class="form-control" id="state" name="state" value=""/>
                                            -->
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city_billing" name="city_billing" value="{{ $address->city ?? '' }}"/>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="suburb_billing" name="suburb_billing" value="{{ $address->suburb ?? '' }}"/>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" id="references_billing"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!empty($paypal_payment))
        <div class="card mb-2">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio_paypal" data-option="paypal">
                    <label class="form-check-label" for="paymentRadio_paypal">
                        Paypal
                    </label>
                </div>

                <img src="{{ asset('assets/img/brands/paypal.png') }}" style="height: 25px; width: auto !important;">
            </div>
        </div>
        @endif

        @if(!empty($mercado_payment))
        <div class="card mb-2">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio_mercadopago" data-option="mercadopago">
                    <label class="form-check-label" for="paymentRadio_mercadopago">
                        MercadoPago
                    </label>
                </div>

                <img src="{{ asset('assets/img/brands/mercado-pago.png') }}" style="height: 25px; width: auto !important;">
            </div>
        </div>
        @endif

        @if(!empty($cash_payment))
        <div class="card mb-2">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio_cash" data-option="efectivo">
                    <label class="form-check-label" for="paymentRadio_cash">
                        Pago en Efectivo <small>via OxxoPay</small>
                    </label>
                </div>

                <img src="{{ asset('assets/img/brands/oxxopay.png') }}" style="height: 25px; width: auto !important;">
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="mb-0">
                    <input type="hidden" name="user_invoice" value="false">
                    <label><input class="user_invoice" type="checkbox" name="user_invoice" value="true"> Quiero recibir la factura electrónica de mi compra online con número de identificación fiscal / RFC</label>
                </div>

                <div id="userInvoiceForm" class="row mt-3" style="display:none;">
                    <div class="col-6 col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="rfc_num">RFC <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="rfc_num" name="rfc_num" value="" required="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-5">
                        <div class="mb-3">
                            <label class="form-label" for="cfdi_use">Uso de CFDI <span class="text-danger">*</span></label>
                            <select class="form-control form-control" id="cfdi_use" name="cfdi_use">
                                <option value="P01 Por Definir">P01 Por Definir</option>
                                <option value="G01 Adquisición de mercancías">G01 Adquisición de mercancías</option>
                                <option value="G03 Gastos en General" selected="">G03 Gastos en General</option>
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $('.billing_check').on('click', function(){
        if($('.billing_check').is(":checked")){
            $("#billingForm").fadeIn(350);
            $('#billingForm').find('input').prop('disabled', false);
            $('#billingForm').find('select').prop('disabled', false);
        }
        else{
            $("#billingForm").hide();
            $('#billingForm').find('input').prop('disabled', true);
            $('#billingForm').find('select').prop('disabled', true);
        }
    });
</script>
@endpush