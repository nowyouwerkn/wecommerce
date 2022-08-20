<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@nowyouwerkn">
    <meta name="twitter:creator" content="@nowyouwerkn">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Werken">
    <meta name="twitter:description" content="Werken WeCommerce">
    <meta name="twitter:image" content="">

    <!-- Facebook -->
    <meta property="og:url" content="http://www.werken.mx">
    <meta property="og:title" content="Werken">
    <meta property="og:description" content="Werken WeCommerce">

    <meta property="og:image" content="">
    <meta property="og:image:secure_url" content="">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Werken WeCommerce">
    <meta name="author" content="Werken">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <title>Werkn Commerce - Vista Principal</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.css') }}">
    @if(Auth::user()->color_mode == true)
    <link rel="stylesheet" href="{{ asset('assets/css/skin.dark.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/wk.custom.css') }}">

    @php
        $store_config = Nowyouwerkn\WeCommerce\Models\StoreConfig::first();
    @endphp

    @if($store_config->store_logo == NULL)
        <style>
            .aside-logo {
                background: url("{{ asset('assets/img/logo.png') }}");
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
            }
        </style>
    @else
        <style>
            .aside-logo {
                background: url("{{ asset('assets/img/' . $store_config->store_logo) }}");
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
            }
        </style>
    @endif

    @stack('stylesheets')
</head>
<body>
    @include('wecommerce::back.layouts.navbar')
    <div class="content ht-100v pd-0">
        @include('wecommerce::back.layouts.header')

        <div class="content-body">
            <div class="container pd-x-0">
                @yield('title')
                @include('wecommerce::back.layouts.partials._messages')

                @yield('content')
            </div>
        </div>
    </div>

    <div id="modalSaleChannels" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Nuevo Canal de Venta</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-25">
                    <div class="media align-items-center mb-5">
                        <img src="{{ asset('assets/img/brands/amazon.jpg') }}" class="wd-100 rounded mg-r-20" alt="">
                        <div class="media-body">
                            <span class="badge badge-warning">PRÓXIMAMENTE</span>
                            <h5 class="mg-b-15 tx-inverse">Amazon</h5>
                            Uno de las empresas más grandes de venta por internet. Conecta tu catálogo por medio de la API para aprovechar sus beneficios.
                        </div>
                    </div>

                    <div class="media align-items-center mb-5">
                        <img src="{{ asset('assets/img/brands/mercadolibre.png') }}" class="wd-100 rounded mg-r-20" alt="">
                        <div class="media-body">
                            <span class="badge badge-warning">PRÓXIMAMENTE</span>
                            <h5 class="mg-b-15 tx-inverse">MercadoLibre</h5>
                            El portal latinoamericano de ventas. Conecta tu catálogo por medio de la API para aprovechar sus beneficios.
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-block pt-4">
                            <h5>¿No encuentras a tu proveedor?</h5>
                            <p>Nosotros podemos ayudarte a integrar la API.</p>
                        </div>
                        
                        <a href="javascript:void()" class="btn btn-outline-secondary disabled btn-block">Solicita una integración</a>
                    </div>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/js/dashforge.aside.js') }}"></script>

    @stack('scripts')
</body>
</html>
