<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="" required="" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="last-name">Apellidos <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" value="" required="" />
        </div>
    </div>
    
    @guest
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="email">Correo <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="" required="" />

            <small>Te enviaremos tu resumen de compra y la guía a este correo, asegúrate que sea real.</small>
        </div>

        <div class="form-group mb-3">
            <label for="email">Confirma tu Correo <span class="text-danger">*</span></label>
            <input type="email" id="email_confirm" class="form-control" autocomplete="off" name="email_confirm" value="" required="" />
        </div>
    </div>

    <div class="col-md-12">
        <div class="alert alert-success email-success" style="display: none;" role="alert">¡Excelente!</div>
        <div class="alert alert-danger email-error" style="display: none;" role="alert">¡Oops! No son iguales</div>
    </div>
    @else
    <input type="hidden" class="form-control" name="email" value="{{ Auth::user()->email }}" required="" />
    @endguest

    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="phone">Teléfono de Contacto <span class="text-danger">*</span></label>
            <input type="text" class="form-control phone-input" name="phone" value="{{ $address->phone ?? '' }}" required="" />

            <small>En casos muy raros es posible que tengamos que contactarte respecto a tu orden.</small>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="country">País <span class="text-danger">*</span></label>
            <select class="form-control form-control" id="country" name="country">
                <option value="México" selected="">México</option>
            </select>
        </div>
    </div> 

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="state">Estado <span class="text-danger">*</span></label>
            @php
                $states = Nowyouwerkn\WeCommerce\Models\State::all();
            @endphp
            <select class="form-control" id="state" name="state" data-parsley-trigger="change" required="">
                @foreach($states as $state)
                    @if(!empty($address))
                        <option {{ ($state->name == $address->state) ? 'selected' : '' }} value="{{ $state->name }}">{{ $state->name }}</option>
                    @else
                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                    @endif
                @endforeach
            </select>
            <!--      
            <input type="text" class="form-control" id="state" name="state" value="" required="" />
            -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? '' }}" required="" />
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="last-name">Calle <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? '' }}" required="" />
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="last-name">Num <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? '' }}" required="" />
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? '' }}" required="" />
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="zip">Referencias <span class="text-danger">*</span></label>
            <textarea class="form-control" id="references" required="" name="references" rows="3"></textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="zip">Código Postal <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" />
        </div>
    </div>

    <!-- STATUS ROW -->
    <div class="col-md-12">
        <div class="alert alert-success add-success" style="display: none;" role="alert">¡Excelente! Gracias por la información.</div>
        <div class="alert alert-danger add-error" style="display: none;" role="alert">Hay un error en la información de tus formulario. Revisa los campos.</div>
    </div>
</div>

@push('pixel-events')
    @if($store_config->has_pixel() == NULL)
    <script type="text/javascript">
            fbq('track', 'InitiateCheckout');
    </script>
    @endif
@endpush