@extends('front.layouts.main')

@section('content')
    <!-- Auth -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Login -->
                <div class="col-md-6">
                    <p>Bienvenido de nuevo</p>
                    <h3>Ingresa</h3>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="col-md-12 mt-2 text-center">
                                <button class="btn btn-primary">
                                    Iniciar sesión
                                </button>
                                <br>
                                <a href="#" class="mt-5">¿Olvidaste la contraseña?</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <p>Crea Tu cuenta</p>
                    <h3>Registro</h3>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

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
                                <label for="password-c">Contraseña</label>
                                <input type="password" name="password-c" class="form-control">
                            </div>

                            <div class="col-md-12 mt-2 text-center">
                                <button class="btn btn-primary">
                                    Registrar cuenta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection