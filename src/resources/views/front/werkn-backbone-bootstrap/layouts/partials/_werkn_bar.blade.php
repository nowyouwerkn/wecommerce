@if(Auth::user()->hasRole(['webmaster', 'admin', 'analyst']))
<div class="werkn-admin-bar">
    <ul>
       <li>{{ $config->store_name ?? 'Sin Configurar' }}</li>
       <li><a class="ms-3" href="{{ route('dashboard') }}">Ir a tu Panel</a></li>
    </ul>

    <ul style="padding-right:2em">
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