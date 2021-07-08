@extends('wecommerce::front.werkn-backbone.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush
@section('content')
    <!-- Profile -->
    <section>
        <div class="container catalog">
            <!-- Title -->
            <div class="row">
                <div class="col-md-12">
                    <p>Tus datos</p>
                    <h1>Hola, {{ auth()->user()->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="row mt-3">
                <div class="col-md-3">
                    @include('wecommerce::front.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="lastname">Apellido</label>
                                        <input type="text" name="lastname" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password">Contraseña</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password-c">Confirma Contraseña</label>
                                        <input type="password" name="password-c" class="form-control">
                                    </div>

                                    <div class="col-md-12 text-center mt-2">
                                        <button class="btn btn-primary">Editar</button>
                                    </div>
                                </div>
                            </form>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection