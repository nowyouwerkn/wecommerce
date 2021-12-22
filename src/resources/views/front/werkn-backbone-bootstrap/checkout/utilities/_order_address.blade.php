@guest
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="addressRadio" id="addressRadio" checked="">
                    <label class="form-check-label" for="addressRadio">
                        Nueva Dirección
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Int </label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $address->int_num ?? '' }}" />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                            <select class="form-control form-control" id="country" name="country">
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

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Referencias <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="references" required="" name="references" rows="3"></textarea>
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
            <div class="card-body" style="display:none;">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Int </label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $address->int_num ?? '' }}" />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                            <select class="form-control form-control" id="country" name="country">
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
                            <select class="form-control" id="state" name="state" data-parsley-trigger="change" required="">
                                @foreach($states as $state)
                                    @if(!empty($address))
                                        <option {{ ($state->name == $address->state) ? 'selected' : '' }} value="{{ $state->name }}">{{ $state->name }}</option>
                                    @else
                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? '' }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Referencias <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="references" required="" name="references" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input new-address" type="radio" name="addressRadio" id="addressRadio_new" checked="" onchange="newAdress()" checked>
                    <label class="form-check-label" for="addressRadio_new">
                        Nueva Dirección
                    </label>
                </div>
                
               <label>
                <input type="hidden" name="save_address" value="false">
                <input type="checkbox" name="save_address" value="true">  Guardar dirección para despues</label>
            </div>
            <div class="card-body card-body-new-add" id="new_address_body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street" name="street" value="{{ $address->street ?? old('street') }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Num <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $address->street_num ?? old('street_num') }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="last-name">Int </label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $address->int_num ?? old('int_num') }}"/>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Colonia / Fraccionamiento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="suburb" name="suburb" value="{{ $address->suburb ?? old('suburb') }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Código Postal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? old('postal_code') }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="country">País <span class="text-danger">*</span></label>
                            <select class="form-control form-control" id="country" name="country">
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
                            <select class="form-control" id="state" name="state" data-parsley-trigger="change" required="">
                                @foreach($states as $state)
                                    @if(!empty($address))
                                        <option {{ ($state->name == $address->state) ? 'selected' : '' }} value="{{ $state->name }}">{{ $state->name }}</option>
                                    @else
                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="city">Ciudad / Municipio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $address->city ?? old('city') }}" required="" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="zip">Referencias <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="references" required="" name="references" rows="3">{{ $address->references ?? old('references') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest