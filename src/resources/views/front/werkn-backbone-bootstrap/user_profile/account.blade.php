@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

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
                    @include('front.theme.werkn-backbone-bootstrap.layouts.nav-user')
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <section class="col-md-8">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3>Editar tu Cuenta</h3>
                                </div>
                                <div class="col">
                                    <a href="{{ route('profile') }}" class="btn btn-info float-right"><i class="fa fa-chevron-left"></i> Regresar</a>
                                </div>
                            </div>
                            
                            <hr>

                            <form role="form" method="POST" action="{{ route('profile.update', $user->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required="">
                                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{ $user->id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">E-Mail</label>
                                            <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control" required="" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h3>Seguridad</h3>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Nueva Contraseña</label>
                                            <input type="text" name="password" id="password" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm-password">Confirmar Contraseña</label>
                                            <input type="text" name="confirm-password" id="confirm-password" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-8 mr-auto">
                                        <a href="{{ route('profile') }}" class="btn btn-default">Cancelar</a>

                                        <button type="submit" class="btn btn-primary">Guardar Perfil</button>
                                    </div>
                                </div>
                            </form>
                        </section>          
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection