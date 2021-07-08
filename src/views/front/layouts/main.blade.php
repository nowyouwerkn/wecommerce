<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Werkn Commerce - Front</title>

    <!-- SEO Metas -->
    <meta name="description" content="En Werkn te ayudamos a encontrar mejores oportunidades económicas através de canales digitales. Evolucionamos y medimos tus herramientas digitales para construir el valor de tu marca.">
    <meta name="keywords" content="proyectos, desarrollo web, diseño web, diseño, desarrollo, werkn, ui, ux, uiux, ayudado, negocios, crecimiento, digital, experiencias, mejores oportunidades, canales digitales, marca, medimos, herramientas digitales.">
    
    <!-- OG Metas -->
    <meta property="og:image:width" content="558">
    <meta property="og:image:height" content="270">
    <meta property="og:description" content="En Werkn ayudamos a encontrar mejores oportunidades económicas através de canales digitales. Evolucionamos y medimos tus herramientas digitales para construir el valor de tu marca.">
    <meta property="og:title" content="Werkn">
    <meta property="og:url" content="https://www.werkn.mx ">
    <meta property="og:image" content="https://www.werkn.mx/img/tile-wide.png">

    <!-- Files CSS -->
    <!--<link rel="stylesheet" href="{{ asset('css/w-bootstrap.css') }}">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/w-theme.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/w-custom.css') }} ">
    @stack('stylesheets')
</head>
<body>
    @include('front.layouts.navbar')

    <main>
        @include('front.layouts.partials._messages')
        @yield('content')
    </main>
    
    @include('front.layouts.footer')

    <!-- Files JS -->
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>