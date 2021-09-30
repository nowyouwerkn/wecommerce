@if(Auth::user()->hasRole(['webmaster', 'admin', 'analyst']))

<style type="text/css">
    .werkn-admin-bar{
        direction: ltr;
        color: #c3c4c7;
        font-size: 13px;
        font-weight: 400;
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
        list-style: none;
        margin-bottom: 0px;
    }

    .werkn-admin-bar ul li{
        padding: 5px 15px;
    }

    body{
        margin-top: 32px;
    }

    .sticky-menu{
        top: 30px !important;
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