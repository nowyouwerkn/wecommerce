@extends('front.theme.werkn-backbone-bootstrap.layouts.main')

@push('seo')

@endpush

@push('stylesheets')

@endpush

@section('content')
    <!-- Auth -->
    <section class="mt-5 pt-5 mb-5 pb-5">
        <div class="container">
            <div class="row">
                <!-- Login -->
                <div class="col-md-6">
                    <p class="mb-0">Bienvenido de nuevo</p>
                    <h3 class="mb-4">Ingresa</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <br>
                                @if (Route::has('password.request'))
                                    <a class="btn-link bnt-sm mt-3 btn-block" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <p class="mb-0">Crea Tu cuenta</p>
                    <h3 class="mb-4">Registro</h3>
                    <form method="POST" action="{{ route('register') }}">
                            @csrf

                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        @php
                            $legals = Nowyouwerkn\WeCommerce\Models\LegalText::all();
                        @endphp

                        <div class="form-group pl-4">
                            <input class="form-check-input" type="checkbox" name="accept" id="accept" required="">
                            <label style="text-transform: uppercase; font-weight: bold; font-size: .8em; display: inline-block; margin-bottom: 10px; margin-top: 5px;" for="accept">
                                Al registrar tu cuenta con nosotros aceptas nuestro  
                                @foreach($legals as $legal)
                                <a style="font-size: 1em !important;" href="#">
                                    @switch($legal->type)
                                        @case('Returns')
                                            Política de Devoluciones
                                            @break

                                        @case('Privacy')
                                            Política de Privacidad
                                            @break

                                        @case('Terms')
                                            Términos y Condiciones
                                            @break

                                        @case('Shipment')
                                            Política de Envíos
                                            @break

                                        @default
                                            Hubo un problema, intenta después.
                                    @endswitch 
                                </a>
                                @endforeach
                                . Solo mandamos correos de <strong>notificación</strong> de compra o <strong>seguimiento</strong> de orden.
                            </label>
                        </div>

                        <div class="form-group row mb-3 mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')

@endpush