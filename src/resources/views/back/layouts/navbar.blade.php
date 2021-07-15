<aside class="aside aside-fixed">
    <div class="aside-header">
        <a href="{{ route('index') }}" class="aside-logo">We<span></span>rkn</a>
        <a href="javascript:void(0)" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>

    <a href="{{ route('index') }}" class="btn btn-primary btn-block" style="border-radius: 0px;">Ir a tu tienda <i data-feather="shopping-bag"></i> </a>

    <div class="aside-body">
        <!-- User Menu -->
        <div class="aside-loggedin">
            <div class="d-flex align-items-center justify-content-start">
                <a href="" class="avatar">
                    <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( Auth::user()->email ?? 'N/A'))) . '?d=retro&s=150' }}" alt="user" class="rounded-circle">     
                    <!--<img src="https://via.placeholder.com/500" class="rounded-circle" alt="">-->
                </a>
                <div class="aside-alert-link">
                    <!--<a href="" class="new" data-toggle="tooltip" title="Dos mensajes sin leer">
                        <i data-feather="message-square"></i>
                    </a>
                    -->
                    <!--
                    <a href="{{ route('notifications.index') }}" class="new" data-toggle="tooltip" title="Tienes 4 notificaciones nuevas">
                        <i data-feather="bell"></i>
                    </a>
                    -->
                    
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Cerrar Sesión">
                        <i data-feather="log-out"></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </div>
            </div>
            <div class="aside-loggedin-user">
                <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                    <h6 class="tx-semibold mg-b-0">{{ Auth::user()->name ?? 'N/A' }}</h6>
                    <i data-feather="chevron-down"></i>
                </a>
                <p class="tx-color-03 tx-12 mg-b-0">Administrator</p>
            </div>
            <div class="collapse" id="loggedinMenu">
                <ul class="nav nav-aside mg-b-0">
                    <li class="nav-item">
                        <a href="{{ route('user.help') }}" class="nav-link"><i data-feather="help-circle"></i> <span>Ayuda</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger">
                            <i data-feather="log-out"></i> <span>Cerrar Sesión</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Menu -->
        <ul class="nav nav-aside">
            <li class="nav-label">General</li>
            <li class="nav-item active">
                <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="pie-chart"></i> <span>Inicio</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('banners.index') }}" class="nav-link">
                    <i data-feather="image"></i> <span>Banners</span>
                </a>
            </li>
            <li class="nav-item with-sub show">
                <a href="" class="nav-link"><i data-feather="tag"></i> <span>Productos</span></a>
                <ul>
                    <li>
                        <a href="{{ route('products.index') }}">Ver Todos</a>
                    </li>
                    <li>
                        <a href="{{ route('stocks.index') }}">Inventario</a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}">Colecciones</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link">
                    <i data-feather="shopping-bag"></i> <span>Ordenes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('clients.index') }}" class="nav-link">
                    <i data-feather="users"></i> <span>Clientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coupons.index') }}" class="nav-link">
                    <i data-feather="percent"></i> <span>Cupones</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reviews.index') }}" class="nav-link">
                    <i data-feather="edit-3"></i> <span>Reseñas</span>
                </a>
            </li>

            <!--
            <li class="nav-label mg-t-25">Blog</li>
            <li class="nav-item">
                <a href="{{ route('configuration') }}" class="nav-link">
                    <i data-feather="align-left"></i> <span>Blog</span>
                </a>
            </li>
            -->

            <li class="nav-label mg-t-25">Canales de Venta</li>
            <li class="nav-item">
                <a href="" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalSaleChannels" style="margin-top:5px; padding:5px 10px;"><i data-feather="plus"></i> Agregar nuevo Canal</a>
            </li>

            <li class="nav-label mg-t-100">Configuración</li>
            <li class="nav-item">
                <a href="{{ route('configuration') }}" class="nav-link">
                    <i data-feather="settings"></i> <span>Configuración</span>
                </a>
            </li>
        </ul>
    </div>
</aside>