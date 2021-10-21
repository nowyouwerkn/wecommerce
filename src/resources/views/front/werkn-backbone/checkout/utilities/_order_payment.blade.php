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
				        <div class="mb-3">
				            <label class="form-label" for="card-number">Número de Tarjeta <span class="text-danger">*</span></label>
				            <input type="text" id="card-number" name="card_number" class="card-input form-control form-control" data-parsley-trigger="change" value="{{ old('card_number') }}" required="">
				        </div>

				        <div class="mb-3">
				            <label class="form-label" for="card-name">Nombre en la Tarjeta <span class="text-danger">*</span> </label>
				            <input type="text" id="card-name" name="card-name" class="form-control form-control" value="{{ old('card-name') }}" data-parsley-trigger="change" required="">
				        </div>

				        <div class="row">
				            <div class="col-md-4">
				                <div class="mb-3">
				                    <label class="form-label" for="card-month">Mes <span class="text-danger">*</span></label>
				                    <input type="text" id="card-month" name="card-month" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" value="{{ old('card-month') }}" required="">
				                </div>
				            </div>
				            <div class="col-md-4">
				                <div class="mb-3">
				                    <label class="form-label" for="card-year">Año <span class="text-danger">*</span></label>
				                    <input type="text" id="card-year" name="card-year" maxlenght="2" class="form-control form-control" data-parsley-trigger="change" value="{{ old('card-year') }}" required="">
				                </div>
				            </div>
				            <div class="col-md-4">
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
    </div>
</div>