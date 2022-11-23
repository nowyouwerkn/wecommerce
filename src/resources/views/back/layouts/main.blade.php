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
    
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/js/dashforge.aside.js') }}"></script>

    @stack('scripts')
</body>
</html>
