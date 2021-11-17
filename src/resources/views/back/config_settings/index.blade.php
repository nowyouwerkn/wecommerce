@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Preferencias Generales</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Preferencias Generales</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>

    <style type="text/css">
        .status-circle{
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 5px;
            border-radius: 100%;
        }

        .token-notification{
            position: relative;
            background-color: black;
            color: #fff;
            font-size: .8em;
            padding: 8px 10px;
            width: 92.7%;
            border-radius: 0px 0px 10px 10px;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Preferencias Generales</h3>
            <p>Conecta cualquier sistema de empresas de terceros para analítica, seguimiento de pedidos, reservaciones, chats en vivo y más. .</p>

            <p>Tu tienda puede vincularse con: </p>

            <ul>
                <li>Google Analytics</li>
                <li>Facebook Pixel</li>
                <li>Jivo Chat</li>
                <li>Sirvoy</li>
                <li>Acuity Scheduling</li>
                <li>Calendly</li>
                <li>y mas...</li>
            </ul>
        </div>
        
    </div>
    <div class="col-md-8">
        <form method="POST" action="{{ route('config.update', $config->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
             {{ method_field('PUT') }}
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="card card-body mb-2">
                        <h4>Bienvenido a tu Plataforma de E-Commerce</h4>
                        <p>Necesitamos unos datos para comenzar a configurar tu sistema.</p>

                        <div class="form-group">
                            <label for="name">Nombre de tu Tienda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="store_name" value="{{$config->store_name}}" required="" placeholder="Tienda de Werkn" />
                        </div>
                        <hr>
                        <h6 class="text-uppercase mb-3">Información de contacto</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">E-mail de contacto directo</label>
                                    <input type="text" class="form-control" name="contact_email" value="{{$config->contact_email}}" required="" placeholder="correo@dominio.com" />
                                    <small>Usaremos este correo si necesitamos comunicarnos contigo acerca de tu tienda.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Correo electrónico del remitente</label>
                                    <input type="text" class="form-control" name="sender_email" value="{{$config->sender_email}}" required="" placeholder="correo@dominio.com" />
                                    <small>Tus clientes verán esta dirección si les envías un correo electrónico.</small>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase">Moneda de la Tienda</h6>
                        @php
                            $currencies = \Nowyouwerkn\WeCommerce\Models\Currency::all();
                        @endphp
                        <div class="form-group">
                            <select class="form-control" name="currency_id" required="">
                                <option value="{{ $config->currency_id }}" selected>@if($config->currency_id=='1')
                                                                            (USD) Dollar
                                                                            @else
                                                                            (MXN) Peso Mexicano
                                                                            @endif</option>
                                @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">({{ $currency->code }}) {{ $currency->name }}</option>
                                @endforeach
                            </select>

                            <small>Esta es la moneda en la que se venden tus productos. Después de tu primera venta, la moneda queda bloqueada y no se puede cambiar. Para cambiar tu moneda de pago, ingresa a configuración de pago.</small>
                        </div>
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
                        $countries = \Nowyouwerkn\WeCommerce\Models\Country::orderBy('id', 'desc')->get();
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
                            <select class="form-control" name="country_id">
                                <option value="{{ $config->country_id }}" selected>
                                    @if($config->country_id=='1')
                                        United states of America
                                        @endif
                                       @if($config->country_id=='2')
                                       Mexico
                                    @endif
                                </option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                        <option value="{{ $config->timezone }}">{{ $config->timezone }}</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="">Sistema de Unidades</label>
                        <select class="form-control" name="unit_system">
                            @if($config->unit_system =='Sistema Métrico')
                             <option value="Sistema Métrico" selected>Sistema Métrico</option>
                             <option value="Sistema Imperial">Sistema Imperial</option>
                                @endif
                            @if($config->unit_system=='Sistema Imperial')
                                <option value="Sistema Imperial" selected>Sistema Imperial</option>
                                <option value="Sistema Métrico" >Sistema Métrico</option>
                            @endif
                        </select>
                    </div>
                    <div class="col">
                        <label for="">Unidad de Peso Predeterminada</label>
                        <select class="form-control" name="weight_system">

                            @if($config->weight_system=='Kilogramos (Kg)')
                            <option value="Kilogramos (kg)" selected>Kilogramos (Kg)</option>
                            <option value="Gramos (g)">Gramos (g)</option>

                            <option value="Libra (Lb)">Libra (Lb)</option>
                            <option value="Onza (oz)">Onza (oz)</option>
                            @endif

                            @if($config->weight_system=='Gramos (g)')
                            <option value="Gramos (g)" selected>Gramos (g)</option>
                            <option value="Kilogramos (kg)" >Kilogramos (Kg)</option>
                            

                            <option value="Libra (Lb)">Libra (Lb)</option>
                            <option value="Onza (oz)">Onza (oz)</option>
                            @endif

                            @if($config->weight_system=='Libra (Lb)')
                            <option value="Libra (Lb)" selected>Libra (Lb)</option>
                            <option value="Onza (oz)">Onza (oz)</option>

                            <option value="Kilogramos (kg)">Kilogramos (Kg)</option>
                            <option value="Gramos (g)">Gramos (g)</option>
                            @endif

                            @if($config->weight_system=='Onza (oz)')
                            <option value="Onza (oz)" selected>Onza (oz)</option>
                            <option value="Libra (Lb)">Libra (Lb)</option>

                            <option value="Kilogramos (kg)">Kilogramos (Kg)</option>
                            <option value="Gramos (g)">Gramos (g)</option>
                            @endif
                         
                        </select>
                    </div>
                </div>
                    </div>


                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection