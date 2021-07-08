@extends('front.layouts.main')

@section('content')
    <!-- Error -->
    @include('front.layouts.partial._messages')

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
                    @include('front.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <!-- Add Address -->
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('address.add') }}" method="POST">
                                @csrf
                                @method('POST')

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="country">Pais</label>
                                        <input type="text" name="country" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="state">Estado</label>
                                        <input type="text" name="state" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="city">Ciudad</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="street">Calle</label>
                                        <input type="text" name="street" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="street_num">Numero</label>
                                        <input type="number" name="street_num" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="postal_code">Codigo Postal</label>
                                        <input type="number" name="postal_code" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="between_street">Entre Calles</label>
                                        <input type="text" name="between_street" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="references">Referencias</label>
                                        <input type="text" name="references" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone">Telefono</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>

                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                    <div class="col-md-12 text-center mt-2">
                                        <button class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div> 

                        <!-- Table of Address -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pais</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Ciudad</th>
                                    <th scope="col">Calle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $address)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $address->country }}</td>
                                        <td>{{ $address->state }}</td>
                                        <td>{{ $address->city }}</td>
                                        <td>{{ $address->street .' '. $address->street_num }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Button -->
                        <div class="col-md-6 offset-md-3 text-center mt-5">
                            <a href="#" class="btn btn-primary">Cargar mas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection