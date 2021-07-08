@extends('back.layouts.config')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Werkn-Commerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1"><i class="fas fa-cogs"></i> Configuración Inicial</h4>
        </div>
    </div>

    <style>
        .decorative-image{
            position: fixed;
            top: 0px;
            right: 0px;
            height: 100vh;
            min-width: 40%;
            overflow:hidden;
            z-index: -10;
        }

        .decorative-image img{
            position: absolute;
            top:50%;
            left:50%;
            height: 100%;
            width: auto;

            transform: translate(-50%,-50%);
        }
    </style>
@endsection

@section('content')

<form method="POST" action="{{ route('config.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row row-xs">
        <div class="col-md-6">
            <div class="card card-body mb-2">
                <h4>Bienvenido a tu Plataforma de E-Commerce</h4>
                <p>Necesitamos unos datos para comenzar a configurar tu sistema.</p>

                <div class="form-group">
                    <label for="name">Nombre de tu Tienda <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="store_name" value="Tienda de {{ $user->name ?? 'Usuario' }}" required="" placeholder="Tienda de Werkn" />
                </div>
                <hr>
                <h6 class="text-uppercase mb-3">Información de contacto</h6>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">E-mail de contacto directo</label>
                            <input type="text" class="form-control" name="contact_email" value="{{ $user->email ?? ''}}" required="" placeholder="correo@dominio.com" />
                            <small>Usaremos este correo si necesitamos comunicarnos contigo acerca de tu tienda.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Correo electrónico del remitente</label>
                            <input type="text" class="form-control" name="sender_email" value="{{ $user->email ?? '' }}" required="" placeholder="correo@dominio.com" />
                            <small>Tus clientes verán esta dirección si les envías un correo electrónico.</small>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-uppercase">Moneda de la Tienda</h6>
                @php
                    $currencies = App\Models\Currency::all();
                @endphp
                <div class="form-group">
                    <select class="form-control" name="currency_id" required="">
                        @foreach($currencies as $currency)
                        <option value="{{ $currency->id }}">({{ $currency->code }}) {{ $currency->name }}</option>
                        @endforeach
                    </select>

                    <small>Esta es la moneda en la que se venden tus productos. Después de tu primera venta, la moneda queda bloqueada y no se puede cambiar. Para cambiar tu moneda de pago, ingresa a configuración de pago.</small>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary btn-lg">Siguiente <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="col-md-6">
            <div class="decorative-image">
                <img src="https://source.unsplash.com/920x1280/?nature,water,forest" alt="">
            </div>
        </div>
    </div>
</form>
@endsection