@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')
<link href="{{ asset('css/w-checkout.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('themes/werkn-backbone/img/bg/breadcrumb_bg01.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="text-white">Checkout</h2>
                    <p class="text-white">Un paso más cerca de tus productos favoritos.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->

<!-- Checkout -->
<section class="mt-5 mb-5 container">
    @guest
    <p class="alert alert-warning" style="display: inline-block;"><ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Estás comprando como invitado. ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión aquí</a></p>
    @endguest
    <div class="row">
        <div class="col-md-12">
            <div class="checkout-container mt-4">
                <form action="{{ route('checkout') }}" method="POST" id="checkout-form" data-parsley-validate>
                    <div class="row">
                        <!-- Shipping Detail -->
                        <div class="col-md-4 mb-3">
                            <!-- Title -->
                            <div class="row">
                                <div class="col-md-12 center">
                                    <div class="checkout-title">
                                        <div class="number-title">
                                            <p class="mb-0">1</p>
                                        </div>
                                        <div class="text-title">
                                            <p class="mb-0">Dirección de Envío <i id="one-check" class="complete-icon"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form -->
                            <div class="card">
                                <div id="add_spinner" class="section-spinner" style="display: none;">
                                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>
                                <div class="card-body text-left bg-gains">
                                    @include('front.theme.werkn-backbone.checkout.utilities._order_address')

                                    <button id="first_step_finish" class="btn bg-orange btn-lg btn-block mt-3 btn-strong">Continuar <i class="fas fa-arrow-right" ></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-4 mb-3 hidden-step" id="payment_step">
                            <!-- Title -->
                            <div class="row">
                                <div class="col-md-12 center">
                                    <div class="checkout-title">
                                        <div class="number-title">
                                            <p class="mb-0">2</p>
                                        </div>
                                        <div class="text-title">
                                            <p class="mb-0">Información de Pago <i id="two-check" class="complete-icon"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form -->
                            <div class="card">
                                <div id="card_spinner" class="section-spinner" style="display: none;">
                                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>              
                                <div class="card-body text-left bg-gains">
                                    <div class="center mb-3">
                                        <div class="card-wrapper"></div>    
                                    </div>

                                    <div class="form-group">
                                        <label for="card-number">Número de Tarjeta <span class="text-danger">*</span></label>
                                        <input type="text" id="card-number" name="card_number" class="card-input form-control form-control" data-parsley-trigger="change" required="">
                                    </div>
    
                                    <div class="form-group">
                                        <label for="card-name">Nombre en la Tarjeta <span class="text-danger">*</span> </label>
                                        <input type="text" id="card-name" name="card-name" class="form-control form-control" data-parsley-trigger="change" required="">
                                    </div>
    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-month">Mes <span class="text-danger">*</span></label>
                                                <input type="text" id="card-month" name="card-month" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-year">Año <span class="text-danger">*</span></label>
                                                <input type="text" id="card-year" name="card-year" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="card-ccv">CCV <span class="text-danger">*</span></label>
                                                <input type="text" id="card-cvc" name="card-cvc" class="form-control form-control" data-parsley-trigger="change" required="" maxlength="3">
                                            </div>
                                        </div>
                                    </div>

                                    <button id="two_step_finish" style="display: none;" class="btn bg-orange btn-lg btn-block mt-3 btn-strong">Continuar <i class="fas fa-arrow-right" ></i></button>
                                </div>                                            
                            </div>
                        </div>

                        <!-- Confirm Order -->
                        <div class="col-md-4 hidden-step" id="confirmation_step">
                            <!-- Title -->
                            <div class="row">
                                <div class="col-md-12 center">
                                    <div class="checkout-title">
                                    <div class="number-title">
                                        <p class="mb-0">3</p>
                                    </div>
                                    <div class="text-title">
                                        <p class="mb-0">Confirma tu Pedido</p>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="card text-left">
                                <div id="cp_spinner" class="section-spinner" style="display: none;">
                                    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div> 

                                <!-- Form -->
                                <div class="card-body text-left bg-gains">
                                    <div class="alert alert-info mb-4 text-center w-100">¿Quieres editar el carrito? 
                                    <br><a href="{{ route('catalog.all') }}" class="font-weight-bold">Ir al catálogo</a></div>

                                    @include('front.theme.werkn-backbone.checkout.utilities._order_summary')
                                    
                                    <div class="row mt-3 text-left">
                                        <!-- STATUS ROW -->
                                        <div class="col-md-12">
                                            <div class="alert alert-success cp-success" style="display: none;" role="alert"></div>
                                            <div class="alert alert-danger cp-error" style="display: none;" role="alert">Ese cupón no existe, intenta con otro.</div>
                                        </div>

                                        <div class="col-md-12">
                                            <p>Aplicar cupón</p>
                                            <div class="input-group input-cuopon mb-3">
                                                <input type="text" class="form-control" id="cuopon_code" placeholder="Coloca tu código aquí" style="height:61px;">
                                                <div class="form-group-append">
                                                    <button class="btn btn-primary" id="apply_cuopon" type="button">Aplicar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{ csrf_field() }}

                                    @php
                                        $legals = Nowyouwerkn\WeCommerce\Models\LegalText::all();
                                    @endphp
                                    <p class="mb-2 terms-links text-center"><small>
                                        Al confirmar la orden, aceptas nuestros 
                                        @foreach($legals as $legal)
                                        <a href="#">
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

                                        </a> /
                                        @endforeach
                                    </small></p>

                                    <div class="alert alert-danger pay-error" style="display: none;" role="alert"></div>

                                    <button type="submit" id="btnBuy" style="display: none;" class="btn bg-orange btn-lg btn-block mt-3 btn-strong">Confirmar Compra <ion-icon name="shield-checkmark-outline"></ion-icon></button>

                                    <p class=" bg-transparent btn-lg btn-block border-left border-bottom border-right text-black text-center" style="color: black !important; border-radius: 0px; font-size: 10px; padding-bottom: 13px; margin-top: 0px;">Todos los pagos procesados por {{ $payment_method->supplier ?? 'N/A' }}</p>

                                    <p class="bg-transparent btn-lg btn-block text-black text-center" style="color: black !important; margin-top: -2px; border-radius: 0px; font-size: 11px;line-height: 45px;display: flex;justify-content: center;"> Envíos de 3-9 días hábiles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#email_confirm').keyup(function(){
            event.preventDefault();

            var email = $('#email').val();
            var confirm = $('#email_confirm').val();

            if (email == confirm) {
                $('.email-success').show();
                $('.email-error').hide();

                $(this).css("background-color", "#d4edda");
                $('#email').css("background-color", "#d4edda");
            }else{
                $('.email-success').hide();
                $('.email-error').show();

                $(this).css("background-color", "#ff7675");
                $('#email').css("background-color", "#ff7675");
            }
        });
    });

    $('#first_step_finish').on('click', function(){
        event.preventDefault();

        $('#add_spinner').fadeIn(500);
        $('.add-error').hide();
        
        $('#add_spinner').fadeOut(200);

        $('.add-success').show(); 
        $('#one-check').show(); 

        /* Rate Quote */
        var products = parseFloat($('#cartTotal').text().replace(',', ''));

        var rate = parseFloat($('#shippingRate').text().replace(',', ''));
        var subtotal = products + rate;

        $('#cartTotal').text(parseFloat(subtotal/1.16).toFixed(2));
        $('#subTotal').val(parseFloat(subtotal/1.16).toFixed(0));

        var total = parseFloat(subtotal);

        /* Tax Calculation */
        var tax_rate = .16;
        var tax = parseFloat($('#cartTotal').text()) * tax_rate;
        /* Print Tax on Screen */
        $('#taxValue').text(parseFloat(tax).toFixed(2));
        $('#taxRate').val(parseFloat(tax).toFixed(2));

        var finaltotal = parseFloat(total).toFixed(0);
    
        $('#totalPayment').text(finaltotal);
        $('#finalTotal').val(finaltotal);

        $('#payment_step').removeClass('hidden-step'); 
        $('#first_step_finish').hide();
        $('#two_step_finish').show();

        /* --- Smoth Scroll --- */        
        $("html, body").animate({
            scrollTop: $('#payment_step').offset().top
        },500); 
    });

    $('#two_step_finish').on('click', function(){
        event.preventDefault();
        $('#card_spinner').fadeIn(500);
        $('#two-check').show(); 
        $('#btnBuy').show(); 
        $('#confirmation_step').removeClass('hidden-step');  
        $('#two_step_finish').hide();
        /* --- Smoth Scroll --- */        
        $("html, body").animate({
            scrollTop: $('#confirmation_step').offset().top
        },500);
        $('#card_spinner').fadeOut(200);
    });

    /* Información de Cupón */
    $('#apply_cuopon').on('click', function(){
        event.preventDefault();

        var cuopon_code = $('#cuopon_code').val();
        var subtotal =  parseFloat($('#cartTotal').text());
        var shipping = parseFloat($('#shippingRate').text());
        $('#cp_spinner').fadeIn(500);

        $.ajax({
            method: 'POST',
            url: "{{ route('apply.cuopon') }}",
            data:{ 
                cuopon_code: cuopon_code,
                subtotal: subtotal,
                shipping: shipping,
                _token: '{{ Session::token() }}', 
            },
            success: function(msg){
                if (msg['type'] == 'exception') {
                    $('.cp-success').hide();
                    $('#cp_spinner').fadeOut(200);

                    console.log(msg);
                    
                    $('.cp-error').text(msg['mensaje']);
                    $('.cp-error').show();
                }else{
                    $('#cp_spinner').fadeOut(200);
                    console.log(msg['mensaje']);
                    $('.cp-error').hide();
                    $('.cp-success').show();
                    $('.cp-success').text(msg['mensaje']);

                    /* Calculate Discount */
                    var discount = msg['discount'];
                    $('#discountValue').text(discount);
                    $('#discount').val(discount);

                    var subtotal = parseFloat($('#cartTotal').text());
                    var shipping = msg['free_shipping'];
                    $('#shippingRate').text(shipping);

                    var total_count = subtotal - parseFloat(discount) + parseFloat(shipping);
                    var total = parseFloat(total_count).toFixed(2);
                    $('#totalPayment').text(total);

                    /* Calculate Tax */
                    var tax_rate = 0.0825;
                    var tax = parseFloat(total_count*tax_rate).toFixed(2);
                    /* Print Tax on Screen */
                    $('#taxValue').text(tax);

                    // Clean Numbers
                    var total = parseFloat(total);
                    var tax = parseFloat(tax);

                    var finaltotal = parseFloat(total + tax).toFixed(2);
                    $('#finalTotal').val(finaltotal);
                }
            },
            error: function(msg){
                $('.cp-success').hide();
                $('#cp_spinner').fadeOut(200);

                console.log(msg);
                
                $('.cp-error').text(msg['mensaje']);
                $('.cp-error').show();
            }
        });
    });
</script>

<!-- CARD JS -->
<script type="text/javascript" src="{{ asset('packages/card-master/dist/card.js') }}"></script>

<script type="text/javascript">
    var card = new Card({
        form: '#checkout-form',
        container: '.card-wrapper',

        formSelectors: {
            numberInput: 'input[name="card_number"]', 
            expiryInput: 'input[name="card-month"], input[name="card-year"]',
            cvcInput: 'input[name="card-cvc"]',
            nameInput: 'input[name="card-name"]'
        },

        formatting: true,

        placeholders: {
            number: '**** **** **** ****',
            name: 'Tommy Shelby',
            expiry: '**/**',
            cvc: '***'
        },

        masks: {
            cardNumber: '•'
        },

        debug: false
    });
</script>
<!-- / CARD JS -->

<!-- CONEKTA TOKENIZE API -->
@if($payment_method->supplier == 'Conekta')
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

<script type="text/javascript">
    Conekta.setPublicKey('{{ $payment_method->public_key }}');
    Conekta.setLanguage("es");

    var $form = $('#checkout-form');

    $form.submit(function(event){
        // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
        $form.find('button').prop('disabled', true);

        Conekta.Token.create({
            "card": {
                "number": $('#card-number').val().replace(/ /g,''),
                "name": $('#card-name').val(),
                "exp_year": $('#card-year').val(),
                "exp_month": $('#card-month').val(),
                "cvc": $('#card-cvc').val(),
                "address": {
                    "street1": $('#street').val(),
                    "city": $('#city').val(),
                    "state": $('#state').val(),
                    "zip": $('#postal_code').val().replace(/ /g,''),
                    "country": $('#country').val()
                }
            }
        }, onSuccess, onError);

        return false;
    }); 

    function onSuccess(response) {
        //alert('Successful operation');
        
        $('.loader-standby').removeClass('hidden');
        console.log(response.id);

        $form.find('button').prop('disabled', true);

        $('#checkout-form').append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId" />').val(response.id));

        $form.get(0).submit();
    }
 
    function onError(response) {
        $('.loader-standby').addClass('hidden');

        $('.pay-error').show();
        $('.pay-error').text(response['error'].message);

        $form.find('button').prop('disabled', false);
        console.log(response);
    }
</script>
@endif

@if($payment_method->supplier == 'Stripe')
<!-- STRIPE -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    Stripe.setPublishableKey('{{ $payment_method->public_key }}');

    var $form = $('#checkout-form');

    $form.submit(function(event){
        // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
        $form.find('button').prop('disabled', true);

        Stripe.card.createToken({
            name: $('#card-name').val(),
            number: $('#card-number').val().replace(/ /g,''),
            cvc: $('#card-cvc').val(),
            exp_month: $('#card-month').val(),
            exp_year: $('#card-year').val()
        }, stripeResponseHandler);

        return false;
    }); 

    function stripeResponseHandler(status, response){
        if (response.error) {
            $form.find('button').prop('disabled', false);
            $('.loader-standby').addClass('hidden');
            console.log(response);

            $('.pay-error').show();
            $('.pay-error').text(response['error'].message);

        }else{
            $('.loader-standby').removeClass('hidden');
            $form.find('button').prop('disabled', true);

            $('.pay-error').hide();

            console.log(response.id);
            var token = response.id;

            // Insert the token into the form so it gets submitted to the server:
            $('#checkout-form').append($('<input type="hidden" name="stripeToken" id="stripeToken" />').val(token));

            // Submit the form:
            $form.get(0).submit();
        }
    };
</script>
@endif

@if($payment_method->supplier == 'OpenPay')
<!-- OPEN PAY API -->
<script type="text/javascript" src="{{ asset('packages/openpay/lib/openpay.v1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('packages/openpay/lib/openpay-data.v1.min.js') }}"></script>

<script>
    OpenPay.setId('{{ $payment_method->merchant_id }}');
    OpenPay.setApiKey('{{ $payment_method->public_key }}');

    OpenPay.setSandboxMode('{{ env("OPENPAY_SANDBOX_MODE", " ") }}');


    var deviceSessionId = OpenPay.deviceData.setup('checkout-form', "device_hidden");
    console.log(deviceSessionId);

    var $form = $('#checkout-form');

    $form.submit(function(event){

        // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
        $form.find('button').prop('disabled', true);
        
        $('.loader-standby').removeClass('hidden');

        OpenPay.token.create({
              "card_number":$('#card-number').cleanVal(),
              "holder_name":$('#card-name').val(),
              "expiration_year":$('#card-year').val(),
              "expiration_month":$('#card-month').val(),
              "cvv2":$('#card-cvc').val(),
        }, onSuccess, onError);

        return false;
        
    }); 

    function onSuccess(response) {
        console.log(response.data.id);

        $form.find('button').prop('disabled', true);

        $form.append($('<input type="hidden" name="openPayToken" />').val(response.data.id));
        $form.get(0).submit()
    }

    function onError(response) {
        $('.loader-standby').addClass('hidden');

        $('.pay-error').show();
        $('.pay-error').text(response['error'].message);

        $form.find('button').prop('disabled', false);
        console.log(response);
    }
</script>
<!-- // OPEN PAY API -->
@endif

<!-- Animation Checkout -->
<script>
    $("#step-one").click(function () {
        $("#layer-checkout-1").addClass("active");
        $(".info-pay-layer-1").addClass("active");
    });

    $("#step-two").click(function () {
        $("#layer-checkout-2").addClass("active");
        $(".info-pay-layer-2").addClass("active");
    });
</script>
@endpush