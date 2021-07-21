<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Werkn Lagerhaus - E-commerce Plataform</title>
        <meta name="description" content="Plataforma E-Commerce de Werkn">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @stack('seo')

		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('themes/werkn-backbone/img/apple-touch-icon.png') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('themes/werkn-backbone/img/favicon-32x32.png') }}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('themes/werkn-backbone/img/favicon-16x16.png') }}">
		<link rel="manifest" href="{{ asset('themes/werkn-backbone/img/site.webmanifest') }}">
		<link rel="mask-icon" href="{{ asset('themes/werkn-backbone/img/safari-pinned-tab.svg') }}" color="#ff5400">
		<meta name="msapplication-TileColor" content="#ff0000">
		<meta name="theme-color" content="#000000">

		<!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/jarallax.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/werkn-backbone/css/responsive.css') }}">

        <!-- This is the file for your custom styles -->
        <link rel="stylesheet" href="{{ asset('css/w-custom.css') }}">

        @stack('stylesheets')
    </head>
    <body>
        @if(Auth::check())
            @if(Auth::user()->hasRole(['webmaster', 'admin', 'analyst']))
            @php
                $config = Nowyouwerkn\WeCommerce\Models\StoreConfig::first();
            @endphp

            <style type="text/css">
                .werkn-admin-bar{
                    direction: ltr;
                    color: #c3c4c7;
                    font-size: 13px;
                    font-weight: 400;
                    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
                    line-height: 2.46153846;
                    height: 32px;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    min-width: 600px;
                    z-index: 99999;
                    background: #1d2327;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .werkn-admin-bar ul{
                    display: flex;
                    align-items: center;
                }

                .werkn-admin-bar ul li{
                    padding: 5px 15px;
                }

                body{
                    margin-top: 32px;
                }
            </style>

            <div class="werkn-admin-bar">
                <ul>
                   <li>{{ $config->store_name ?? 'Sin Configurar' }}</li>
                   <li><a href="{{ route('dashboard') }}">Ir a tu Panel</a></li>
                </ul>

                <ul>
                   <li>Hola, {{ Auth::user()->name }}</li>
                   <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger"><span>Cerrar Sesión</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                    </li>
                </ul>
            </div>
            @endif
        @endif

        <div id="preloader">
            <div id="ctn-preloader" class="ctn-preloader">
                <div class="animation-preloader">
                    <div class="spinner"></div>
                </div>
                <div class="loader">
                    <div class="row">
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-left">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                        <div class="col-3 loader-section section-right">
                            <div class="bg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="scroll-top scroll-to-target" data-target="html">
            <i class="fas fa-angle-up"></i>
        </button>

    	@include('front.theme.werkn-backbone.layouts.header')

    	<main>
            @include('front.theme.werkn-backbone.layouts.partials._messages')
    		@yield('content')
    	</main>

    	@include('front.theme.werkn-backbone.layouts.footer')

		<!-- JS here -->
        <script src="{{ asset('themes/werkn-backbone/js/vendor/jquery-3.5.0.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/popper.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/jarallax.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/slick.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/wow.min.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/nav-tool.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/plugins.js') }}"></script>
        <script src="{{ asset('themes/werkn-backbone/js/main.js') }}"></script>
    	@stack('scripts')

        @php
            $integrations = Nowyouwerkn\WeCommerce\Models\Integration::all();
        @endphp

        @foreach($integrations as $integration)
            <!-- {{ $integration->name }} -->
            {{ $integration->code }}
        @endforeach
	</body>
</html>