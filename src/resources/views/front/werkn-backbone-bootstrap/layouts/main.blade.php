<!doctype html>
<html lang="es">
    <head>
        @php
            $store_config = Nowyouwerkn\WeCommerce\Models\StoreConfig::first(['store_name', 'contact_email', 'phone']);
        @endphp

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $store_config->store_name ?? 'WeCommerce' }}</title>

        <!-- SEO -->
        <meta name="description" content="{{ $store_config->store_name ?? 'WeCommerce' }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('seo')

        <!-- FAVICON -->

		<!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/w-custom.css') }}">

        @stack('stylesheets')
    </head>
    <body>
        @if(Auth::check())
            @include('front.theme.werkn-backbone-bootstrap.layouts.partials._werkn_bar')
        @endif

    	@include('front.theme.werkn-backbone-bootstrap.layouts.header')

        <main class="mb-5">
            @include('front.theme.werkn-backbone-bootstrap.layouts.partials._messages')
            @include('front.theme.werkn-backbone-bootstrap.layouts.partials._messages_errors')
    		@yield('content')
    	</main>

    	@include('front.theme.werkn-backbone-bootstrap.layouts.footer')
        
		<!-- JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

        <!-- Icon Pack -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    	@stack('scripts')


        @include('front.theme.werkn-backbone-bootstrap.layouts.partials._modal_popup')

        @php
            $integrations = Nowyouwerkn\WeCommerce\Models\Integration::where('is_active', true)->get(['name', 'code']);
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