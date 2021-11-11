@extends('front.theme.werkn-backbone-bootstrap.layouts.checkout.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')

<!-- Checkout -->
<section class="mt-5 mb-5 container we-co--checkout-container">
    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" data-parsley-validate="">
        @if(!empty($card_payment))
        <input type="hidden" name="method" value="Pago con Tarjeta" disabled="">
        @else
        <input type="hidden" name="method" value="" disabled="">
        @endif
        <div class="row">
            <!-- Shipping Detail -->
            <div class="col-md-8 mb-3 pos-relative">
                <!-- Progress -->
                <div class="we-co--progress progress">
                    @guest
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 35%;"></div>
                    @else
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 20%;"></div>
                    @endguest
                </div>

                <!-- Form Container -->
                <div class="we-co--form-wrap">
                    <div class="we-co--title d-flex align-items-center justify-content-between">
                        <h4><span class="we-co--progress-indicator"></span> Información de Contacto <span class="ms-2"><span class="text-danger">*</span> Campo requerido</span></h4>
                        @guest
                        <p class="we-co--guest-notice mb-0"><ion-icon name="warning"></ion-icon> ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión aquí</a></p>
                        @endguest
                    </div>
                    @include('front.theme.werkn-backbone-bootstrap.checkout.utilities._order_contact')

                    {{-- 
                    <div class="we-co--title d-flex align-items-center justify-content-between">
                        <h4><span class="we-co--progress-indicator"></span> Método de Envío</h4>
                    </div>
                    @include('front.theme.werkn-backbone-bootstrap.checkout.utilities._order_shipping')
                    --}}

                    <div class="we-co--title d-flex align-items-center justify-content-between">
                        <h4><span class="we-co--progress-indicator"></span> Información de Envío</h4>
                    </div>
                    @include('front.theme.werkn-backbone-bootstrap.checkout.utilities._order_address')

                    <div class="we-co--title d-flex align-items-center justify-content-between">
                        <h4><span class="we-co--progress-indicator"></span> Pago</h4>

                        <p class="mb-0"><ion-icon name="lock-closed"></ion-icon> Sitio seguro con encriptación de 256-bits</p>
                    </div>
                    @include('front.theme.werkn-backbone-bootstrap.checkout.utilities._order_payment')
                </div>
            </div>

            <!-- Confirm Order -->
            <div class="col-md-4" id="confirmation_step">
                <div class="sticky-top">
                    <div class="we-co--title d-flex align-items-center justify-content-between">
                        <h4>Resúmen de Pedido</h4>
                    </div>

                    @include('front.theme.werkn-backbone-bootstrap.checkout.utilities._order_summary')
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<!-- SELECTOR DE MÉTODOS DE PAGO -->
<script type="text/javascript">
    var $form = $('#checkout-form');

    $(document).ready(function() {
        $('input[name=paymentRadio]').on('click', function(){
            $('input[name=method]').prop('disabled', false);

            var selected = $(this).attr('data-option');

            switch(selected){
                case "tarjeta":
                    console.log('Pago con Tarjeta');
                    $('#cardInfo').fadeIn();
                    $('#cardInfo').find('input').prop('disabled', false);
                    $('input[name=method]').val('Pago con Tarjeta');

                    $('#paymentMethod').text('{{ $card_payment->supplier }}');

                    break;

                case "paypal":
                    console.log('Pago con Paypal');
                    $('#cardInfo').fadeOut();
                    $('#cardInfo').find('input').prop('disabled', true);
                    $('input[name=method]').val('Pago con Paypal');
                    
                    $('#paymentMethod').text('Paypal');

                    break;

                case "mercadopago":
                    console.log('Pago con MercadoPago');
                    $('#cardInfo').fadeOut();
                    $('#cardInfo').find('input').prop('disabled', true);
                    $('input[name=method]').val('Pago con MercadoPago');
                    
                    $('#paymentMethod').text('MercadoPago');

                    break;

                case "efectivo":
                    console.log('Pago con Oxxo');
                    $('#cardInfo').fadeOut();
                    $('#cardInfo').find('input').prop('disabled', true);
                    $('input[name=method]').val('Pago con Oxxo');

                    $('#paymentMethod').text('OxxoPay');

                    break;
            }
        });
    });
</script>
<!-- // SELECTOR DE MÉTODOS DE PAGO -->

<!-- PARSLEY VALIDATION -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>
<script type="text/javascript">
    // ParsleyConfig definition if not already set
    // Validation errors messages for Parsley
    // Load this after Parsley
    Parsley.addMessages('es', {
      defaultMessage: "Este valor parece ser inválido.",
      type: {
        email:        "Este valor debe ser un correo válido.",
        url:          "Este valor debe ser una URL válida.",
        number:       "Este valor debe ser un número válido.",
        integer:      "Este valor debe ser un número válido.",
        digits:       "Este valor debe ser un dígito válido.",
        alphanum:     "Este valor debe ser alfanumérico."
      },
      notblank:       "Este valor no debe estar en blanco.",
      required:       "Este valor es requerido.",
      pattern:        "Este valor es incorrecto.",
      min:            "Este valor no debe ser menor que %s.",
      max:            "Este valor no debe ser mayor que %s.",
      range:          "Este valor debe estar entre %s y %s.",
      minlength:      "Este valor es muy corto. La longitud mínima es de %s caracteres.",
      maxlength:      "Este valor es muy largo. La longitud máxima es de %s caracteres.",
      length:         "La longitud de este valor debe estar entre %s y %s caracteres.",
      mincheck:       "Debe seleccionar al menos %s opciones.",
      maxcheck:       "Debe seleccionar %s opciones o menos.",
      check:          "Debe seleccionar entre %s y %s opciones.",
      equalto:        "Este valor debe ser idéntico."
    });

    Parsley.setLocale('es');
</script>
<!-- / PARSLEY VALIDATION -->

@if(!empty($card_payment))
    @if($card_payment->supplier == 'Conekta')
    <!-- CONEKTA TOKENIZE API -->
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

    <script type="text/javascript">
        $form.submit(function(event){
            if($('input[name=method]').val() === 'Pago con Tarjeta') {
                Conekta.setPublicKey('{{ $card_payment->public_key }}');
                Conekta.setLanguage("es");

                // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
                $form.find('button').prop('disabled', true);

                Conekta.Token.create({
                    "card": {
                        "number": $('#card-number').val().replace(/\s+/g, ''),
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
            }

            function onSuccess(response) {
                //alert('Successful operation');
                
                $('.loader-standby').removeClass('loader-hidden');
                //console.log(response.id);

                $form.find('button').prop('disabled', true);

                $('#checkout-form').append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId" />').val(response.id));

                $form.get(0).submit();
            }
         
            function onError(response) {
                $('.loader-standby').addClass('loader-hidden');

                $('.pay-error').show();
                $('.pay-error').text(response['message_to_purchaser']);

                $form.find('button').prop('disabled', false);
                console.log(response);
            }
        });
    </script>
    @endif

    @if($card_payment->supplier == 'Stripe')
    <!-- STRIPE -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script>
        $form.submit(function(event){
            if($('input[name=method]').val() === 'Pago con Tarjeta') {
                Stripe.setPublishableKey('{{ $card_payment->public_key }}');

                // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken({
                    name: $('#card-name').val(),
                    number: $('#card-number').val().replace(/\s+/g, ''),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-month').val(),
                    exp_year: $('#card-year').val()
                }, stripeResponseHandler);

                return false;
            }

            function stripeResponseHandler(status, response){
                if (response.error) {
                    $form.find('button').prop('disabled', false);
                    $('.loader-standby').addClass('loader-hidden');
                    console.log(response);

                    $('.pay-error').show();
                    $('.pay-error').text(response['error'].message);

                }else{
                    $('.loader-standby').removeClass('loader-hidden');
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
        });
    </script>
    @endif

    @if($card_payment->supplier == 'OpenPay')
    <!-- OPEN PAY API -->
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay-data.v1.min.js"></script>

    <script>
        $form.submit(function(event){
            if($('input[name=method]').val() === 'Pago con Tarjeta') {
                OpenPay.setId('{{ $card_payment->merchant_id }}');
                OpenPay.setApiKey('{{ $card_payment->public_key }}');
                OpenPay.setSandboxMode('{{ env("OPENPAY_PRODUCTION_MODE", false) }}');
                
                var deviceSessionId = OpenPay.deviceData.setup('checkout-form', "device_hidden");
                //console.log(deviceSessionId);

                // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
                $form.find('button').prop('disabled', true);
                    
                $('.loader-standby').removeClass('loader-hidden');

                OpenPay.token.create({
                      "card_number": $('#card-number').val().replace(/\s+/g, ''),
                      "holder_name":$('#card-name').val(),
                      "expiration_year":$('#card-year').val(),
                      "expiration_month":$('#card-month').val(),
                      "cvv2":$('#card-cvc').val(),
                }, onSuccess, onError);

                return false;
            }

            function onSuccess(response) {
                console.log(response.data.id);

                $form.find('button').prop('disabled', true);

                $form.append($('<input type="hidden" name="openPayToken" />').val(response.data.id));
                
                $form.get(0).submit()
            }

            function onError(response) {
                $('.loader-standby').addClass('loader-hidden');

                $('.pay-error').show();
                $('.pay-error').text(response['data'].description);

                $form.find('button').prop('disabled', false);
                console.log(response);
            }
        });
    </script>
    <!-- // OPEN PAY API -->
    @endif

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
@endif

@if(!empty($paypal_payment))
<script type="text/javascript">
    $form.submit(function(event){
        if($('input[name=method]').val() === 'Pago con Paypal') {
            // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
            $form.find('button').prop('disabled', true);
            $('.loader-standby h2').text('Redireccionándote a Paypal...');
            $('.loader-standby').removeClass('loader-hidden');
            //console.log(response.id);

            setTimeout(function() { 
                $form.get(0).submit();
            }, 2000);
        }
    });
</script>  
@endif

@if(!empty($mercado_payment))
<script type="text/javascript">
    $form.submit(function(event){
        if($('input[name=method]').val() === 'Pago con MercadoPago') {
            //$('#checkout-form').append($('<input type="hidden" name="mp_preference" />').val('{{ $preference->sandbox_init_point }}'));
            //$('#checkout-form').append($('<input type="hidden" name="mp_preference_id" />').val('{{ $preference->id }}'));

            // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
            $form.find('button').prop('disabled', true);
            $('.loader-standby h2').text('Redireccionándote a MercadoPago...');
            $('.loader-standby').removeClass('loader-hidden');
            //console.log(response.id);

            setTimeout(function() { 
                $form.get(0).submit();
            }, 2000);
        }
    });
</script> 
@endif

@if(!empty($cash_payment))
    <!-- CONEKTA TOKENIZE API -->
    @if($cash_payment->supplier == 'Conekta')
    <script type="text/javascript">
        $form.submit(function(event){

            if($('input[name=method]').val() === 'Pago con Oxxo') {
                // Pedirle al boton que se desactive al enviar el formulario para que no sea posible enviar varias veces el formulario.
                $form.find('button').prop('disabled', true);
                $('.loader-standby h2').text('Generando tu referencia de pago...');
                $('.loader-standby').removeClass('loader-hidden');
                //console.log(response.id);

                setTimeout(function() { 
                    $form.get(0).submit();
                }, 2000);
            }
        });
    </script>  
    @endif

    @if($cash_payment->supplier == 'OpenPay')

    @endif
@endif

@endpush