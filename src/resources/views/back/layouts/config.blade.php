<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DashForge">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="http://themepixels.me/dashforge/img/dashforge-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/dashforge">
    <meta property="og:title" content="DashForge">
    <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

    <meta property="og:image" content="http://themepixels.me/dashforge/img/dashforge-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/dashforge/img/dashforge-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <title>Werkn Commerce - Vista Principal</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.dashboard.css') }}">
    @yield('stylesheets')
</head>
<body>

<header class="navbar navbar-header">
      <a href="" id="sidebarMenuOpen" class="burger-menu"><i data-feather="arrow-left"></i></a>
      <div class="navbar-brand">
        <a href="{{ route('index') }}" class="df-logo">We<span></span>rkn</a>
      </div><!-- navbar-brand -->

      <div class="navbar-right">
        <a href="{{ route('support.help') }}" class="btn btn-outline-secondary"><i class="far fa-life-ring"></i> <span>Ayuda</span></a>
        <a href="{{ route('index') }}" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt ml-3"></i> <span>Salir</span></a>
      </div><!-- navbar-right -->
    </header><!-- navbar -->

    <div class="content content-components">
        <div class="content-body">
            <div class="container pd-x-0">
                <!-- Title -->
                @yield('title')
                <div class="row row-xs">
                    <div class="col-md-6">
                        @include('wecommerce::back.layouts.partials._messages')
                    </div>
                </div>
                
                <!-- Content -->
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

    @yield('scripts')
</body>
</html>
