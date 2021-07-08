@extends('wecommerce::front.werkn-backbone.layouts.main')

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
                    @include('wecommerce::front.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row align-items-center">
                                <div class="col">
                                    <h3>Lista de Direcciones</h3>
                                </div>
                                <div class="col">
                                    <a href="{{ route('address.create') }}" class="btn btn-auth float-right"><i class="fa fa-plus"></i> Nueva Dirección</a>
                                </div>
                            </div>
                            
                            <hr>

                            @if($addresses->count())
                                @foreach($addresses as $address)
                                    <div class="card my-3">
                                        <div class="card-header">
                                            <ul class="list-inline mb-0">
               
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
                                @else
                                <div class="text-center my-5">
                                    <h4 class="mb-0">No haz guardado ninguna dirección.</h4>
                                    <p>Crea una nueva <a href="{{ route('address.create') }}">aqui</a> o en el botón superior.</p>
                                </div>
                            @endif
                </div>
            </div>
        </div>
    </section>
@endsection