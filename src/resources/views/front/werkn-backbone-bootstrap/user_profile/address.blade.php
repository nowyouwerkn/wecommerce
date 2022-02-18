@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
    <!-- Error -->

    <!-- Profile -->
    <section>
        <div class="container catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Tus direcciones</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row align-items-center">
                                <div class="col">
                                    <h3>Lista de Direcciones</h3>
                                </div>
                            </div>
                            
                            <hr>

                            @if($addresses->count())
                                @foreach($addresses as $address)
                                    <div class="card my-3">
                                        <div class="card-header">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a class="" href="{{ route('address.edit', $address->id) }}"><i class="fa fa-pencil-square-o"></i> Editar</a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="" href="{{ route('address.destroy', $address->id) }}"><i class="fa fa-trash"></i> Borrar</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                                      <div class="row">
                                                            <div class="col-md-5">
                                                                  <h6 class="text-uppercase"><small><strong>Nombre</strong></small></h6>
                                                                  <h4 class="card-title">{{ $address->name }}</h4>

                                                                  <h6 class="text-uppercase"><small><strong>Direccion <em>(Street)</em></strong></small></h6>
                                                                  <p class="card-text mb-1">{{ $address->street }} / {{ $address->street_num }}</p>
                                                                  <p class="card-text mb-1">{{ $address->suburb }}</p>
                                                                  <p class="card-text">Referencias: {{ $address->references }}</p>

                                                                  <p class="card-text">Teléfono: {{ $address->phone }}</p>

                                                                  <h6 class="text-uppercase"><small><strong>Ubicación</strong></small></h6>
                                                                  <ul>
                                                                        <li>País: {{ $address->country }}</li>
                                                                        <li>Ciudad: {{ $address->city }}</li>
                                                                        <li>Estado: {{ $address->state }}</li>
                                                                        <li>CP: {{ $address->postal_code }}</li>
                                                                  </ul>
                                                            </div>
                                                            <div class="col-md-7">
                                                                  <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDhjSfxxL1-NdSlgkiDo5KErlb7rXU5Yw4&q={{ str_replace(' ', '-', $address->street . ' ' . $address->street_num) }},{{ $address->city }},{{ $address->state }},{{ $address->country }}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                                            </div>
                                                      </div>
                                        </div>
                                    </div>                      
                                @endforeach
                            <form action="{{ route('address.store') }}" method="POST">
                            {{ csrf_field() }}                                    
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="addressRadio">
                                                        Nueva Dirección
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last-name">Nombre de la dirección <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $address->name ?? '' }}" required="" />
                                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                        </div>
                                                    </div>
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

                                                    <button type="submit" id="btnBuy" class="btn btn-primary btn-lg mt-1 w-100 pt-3 pb-3"><ion-icon name="checkmark"></ion-icon> Crear nueva dirección</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                @else
                                <div class="text-center my-5">
                                    <h4 class="mb-3">No haz guardado ninguna dirección.</h4>
                            <form action="{{ route('address.store') }}" method="POST">
                            {{ csrf_field() }}                                    
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="addressRadio">
                                                        Nueva Dirección
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last-name">Nombre de la dirección <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $address->name ?? '' }}" required="" />
                                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                        </div>
                                                    </div>
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

                                                    <button type="submit" id="btnBuy" class="btn btn-primary btn-lg mt-1 w-100 pt-3 pb-3"><ion-icon name="checkmark"></ion-icon> Crear nueva dirección</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                </div>
                            @endif
                </div>
            </div>
        </div>
    </section>
@endsection