@extends('wecommerce::back.layouts.config')

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

<form method="POST" action="{{ route('config.update', $config->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row row-xs">
        <div class="col-md-6">
            <div class="card card-body mb-2">
                <h4>Dirección de la Tienda</h4>
                <p>Esta dirección aparecerá en tus datos de contacto y correos electrónicos.</p>

                <div class="form-group">
                    <label for="name">Razón Social de la Empresa</label>
                    <input type="text" class="form-control" name="rfc_name" value="{{ old('rfc_name') }}" />
                </div>

                <div class="form-group">
                    <label for="name">Teléfono</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" />
                </div>

                <div class="row">
                    @php
                        $countries = App\Models\Country::all();
                    @endphp

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Calle</label>
                            <input type="text" class="form-control" name="street" value="{{ old('street') }}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Número</label>
                            <input type="text" class="form-control" name="street_num" value="{{ old('street_num') }}" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Código Postal</label>
                            <input type="text" class="form-control" name="zip_code" value="{{ old('zip_code') }}" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Ciudad</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Estado</label>
                            <input type="text" class="form-control" name="state" value="{{ old('state') }}" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">País / Región</label>
                            <select class="form-control" name="country">
                                @foreach($countries as $country)
                                <option value="{{ $country->name }}" selected>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-uppercase mb-3">Estándares y Formatos</h6>

                <div class="form-group">
                    <label for="">Huso Horario</label>
                    <select class="form-control" name="timezone">
                        <option value="(GMT-06:00) Guadalajara, Ciudad de México">(GMT-06:00) Guadalajara, Ciudad de México</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="">Sistema de Unidades</label>
                        <select class="form-control" name="unit_system">
                            <option value="Sistema Métrico" selected>Sistema Métrico</option>
                            <option value="Sistema Imperial">Sistema Imperial</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="">Unidad de Peso Predeterminada</label>
                        <select class="form-control" name="weight_system">
                            <option value="Kilogramos (kg)" selected>Kilogramos (Kg)</option>
                            <option value="Gramos (g)">Gramos (g)</option>

                            <option value="Libra (Lb)">Libra (Lb)</option>
                            <option value="Onza (oz)">Onza (oz)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">Dejar para otro momento <i class="far fa-pause-circle"></i></a>
                <button type="submit" class="btn btn-primary btn-lg ml-3">Siguiente <i class="fas fa-arrow-right"></i></button>
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