@guest
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input new-address responsive-one" type="radio" name="addressRadio" id="addressRadio_new" checked="" onchange="newAdress()" checked>
                    <input class="form-check-input new-address responsive-two" type="radio" name="addressRadio" id="addressRadio_new"  onchange="newAdress()">
                    <label class="form-check-label" for="addressRadio_new">
                        <span class="responsive-one">Nueva Dirección</span> <span class="responsive-two">Dirección de Envío</span>
                    </label>
                </div>

            </div>
            <div class="card-body card-body-new-add" id="new_address_body">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Int </label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $address->int_num ?? '' }}" />
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" autocomplete="off" />

                            <small class="postal_code_notice text-danger mt-1"></small>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="country" name="country" value="México" required="" readonly />
                            {{--
                            <select class="form-control" id="country" name="country">
                                <option value="México" selected="">México</option>
                            </select>
                            --}}
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="state">Estado <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="state" name="state" value="" required="" readonly />

                            {{--
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
                            --}}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? '' }}" required="" readonly />
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                            <!--<input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? '' }}" required="" />-->

                            <select class="form-control" id="suburb" name="suburb" required="">

                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Referencias <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="references" required="" name="references" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        @foreach(Auth::user()->addresses->take(3) as $address)
        <div class="card mb-2">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input option-address" type="radio" name="addressRadio" id="addressRadio_{{ $address->id }}" onchange="newAdress()">
                    <label class="form-check-label" for="addressRadio_{{ $address->id }}">
                        {{ $address->name }}
                    </label>
                </div>
            </div>

            <div id="addressCard_{{ $address->id }}" class="card-body card-body-old-add" style="display:none;">
                <input type="text" class="form-control"  name="street" value="{{ $address->street ?? '' }}" required="" disabled/>
                <input type="text" class="form-control"  name="street_num" value="{{ $address->street_num ?? '' }}" required="" disabled/>
                <input type="text" class="form-control"  name="int_num" value="{{ $address->int_num ?? '' }}" disabled/>
                <input type="text" class="form-control"  value="{{ $address->suburb ?? '' }}" required="" disabled/>
                <input type="text" class="form-control" id="postalCode_{{ $address->id }}" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" autocomplete="off" disabled/>
                <input type="text" class="form-control" name="country" value="{{ $address->country ?? '' }}" required="" autocomplete="off" disabled/>
                <input type="text" class="form-control" name="state" value="{{ $address->state ?? '' }}" required="" disabled/>
                <input type="text" class="form-control" name="city" value="{{ $address->city ?? '' }}" required="" disabled/>
                <input type="text" class="form-control" name="suburb" value="{{ $address->suburb ?? '' }}" required="" disabled/>

                <textarea class="form-control" required="" name="references" rows="3">{{ $address->references }}</textarea>
            </div>

        </div>
        @endforeach
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input new-address responsive-one" type="radio" name="addressRadio" id="addressRadio_new" checked="" onchange="newAdress()" checked>
                    <input class="form-check-input new-address responsive-two" type="radio" name="addressRadio" id="addressRadio_new"  onchange="newAdress()">
                    <label class="form-check-label" for="addressRadio_new">
                        <span class="responsive-one">Nueva Dirección</span> <span class="responsive-two">Dirección de Envío</span>
                    </label>
                </div>

               <label>
                <input type="checkbox" name="save_address" value="false" id="save-address">  Guardar esta dirección para después</label>
            </div>
            <div class="card-body card-body-new-add" id="new_address_body">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-6 col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Int </label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $address->int_num ?? '' }}" />
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" autocomplete="off" />

                            <small class="postal_code_notice text-danger mt-1"></small>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="country" name="country" value="México" required="" readonly />
                            {{--
                            <select class="form-control" id="country" name="country">
                                <option value="México" selected="">México</option>
                            </select>
                            --}}
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="state">Estado <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="state" name="state" value="" required="" readonly />

                            {{--
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
                            --}}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? '' }}" required="" readonly />
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                            <!--<input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? '' }}" required="" />-->

                            <select class="form-control" id="suburb" name="suburb" required="">

                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Referencias <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="references" required="" name="references" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest

@push('scripts')
<script type="text/javascript">
    $('#postal_code').keyup(function(){
        event.preventDefault();

        if ($(this).val().length == 5) {
            $('.postal_code_notice').hide();

            $('#suburb').append('<option value="0" disabled selected>Procesando...</option>');
            $('#city').val('Procesando...');
            $('#state').val('Procesando...');


            if ($(this).val().charAt(0) == '0') {
                var zip = $(this).val().slice(1);
            }else{
                var zip = $(this).val();
            }

            $.ajax({
                method: 'GET',
                url: "{{ route('zipcode.get') }}",
                data:{
                    value: zip,
                    _token: '{{ Session::token() }}',
                },
                success: function(response){
                    if (response.length == 0) {
                        $('#suburb').empty();
                        $('#city').empty();
                        $('#state').empty();

                        $('.postal_code_notice').show();
                        $('.postal_code_notice').text('Este código postal no existe.');
                    }else{
                        $('#suburb').empty();
                        response.forEach(element => {
                            let suburb = element['suburb'] || element['municipality']; // Use 'municipality' if 'suburb' is null
                            $('#suburb').append(`<option value="${suburb}">${suburb}</option>`);
                        });

                        $('#city').empty();
                        $('#city').val(response[0]['municipality']);
                        //$('#city').append(`<option value="${response[0]['city']}">${response[0]['city']}</option>`);

                        $('#state').empty();
                        $('#state').val(response[0]['state']);
                        //$('#state').append(`<option value="${response[0]['state']}">${response[0]['state']}</option>`);

                        $('.postal_code_notice').hide();
                    }

                    $('.postal_code_notice').hide();
                },
                error: function(response){

                }
            });
        }else{
            $('.postal_code_notice').show();
            $('.postal_code_notice').text('Debe tener 5 caracteres.');
        }
    });
</script>


@auth
@foreach(Auth::user()->addresses->take(3) as $address)
<script>
    $('#addressRadio_{{ $address->id }}').on('click', function(){

        if($('#addressRadio_{{ $address->id }}').attr('checked', 'true')){


            $(".card-body-old-add .form-control").attr('disabled', 'disabled');

            $(".card-body-new-add").fadeOut(500);
            $(".card-body-new-add .form-control").attr('disabled', 'disabled');
            $("#addressCard_{{ $address->id }} .form-control").removeAttr('disabled');
        }

        $('#contact_notice_{{ $address->id }}').hide();
        $('.address-contact-notice').hide();
        /* ---- */
        $('.courier-info').hide();
        /* ---- */

    });

    $("#save-address").on('click', function(e){

        $(this).val('true');

    });

    $("#addressRadio_new").on('click', function(e){
        $('.address-contact-notice').hide();

        if($('.new-address').attr('checked', 'true')){
            $(".card-body-new-add").fadeIn(500);
            $(".card-body-new-add .form-control").removeAttr('disabled');
            $(".card-body-old-add .form-control").attr('disabled', 'disabled');
        }else{
            $(".card-body-new-add").fadeOut(500);
            $(".card-body-new-add .form-control").attr('disabled', 'disabled');
        }
    });
</script>
@endforeach
@endauth

@endpush
