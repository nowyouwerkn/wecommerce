<!doctype html>
<html class="no-js" lang="">
    <head>
        @php
            $store_config = Nowyouwerkn\WeCommerce\Models\StoreConfig::first();
        @endphp

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $store_config->store_name ?? 'WeCommerce' }}</title>
        <meta name="description" content="{{ $store_config->store_name ?? 'WeCommerce' }}">
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

        @stack('stylesheets')

        <link rel="stylesheet" href="{{ asset('css/w-custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/w-theme.css') }}">
    </head>
    <body>

        @if(Auth::check())
            @include('front.theme.werkn-backbone.layouts.partials._werkn_bar')
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

        @include('front.theme.werkn-backbone.layouts.partials._modal_popup')

        @php
            $integrations = Nowyouwerkn\WeCommerce\Models\Integration::all();
        @endphp

        @foreach($integrations as $integration)
            <!-- {{ $integration->name }} -->
            {!! $integration->code !!}

            @if($integration->name = 'Facebook Pixel')
                @stack('pixel-events')
            @endif
        @endforeach

        <script type="text/javascript">
            $('.contact_action').on('click', function(){
                fbq('track', 'Contact');
            });
        </script>
	</body>
</html>