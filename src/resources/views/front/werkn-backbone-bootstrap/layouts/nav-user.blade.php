<ul class="list-unstyled">
    <li>
        <a href="{{ route('profile') }}"><ion-icon name="home-outline"></ion-icon> Vista General</a>
    </li>
    <li>
        <a href="{{ route('wishlist') }}"><ion-icon name="heart-outline"></ion-icon> Mi Wishlist</a>
    </li>
    <li>
        <a href="{{ route('shopping') }}"><ion-icon name="bag-handle-outline"></ion-icon> Mis Compras</a>
    </li>
    <li>
        <a href="{{ route('address') }}"><ion-icon name="compass-outline"></ion-icon> Mis Direcciones</a>
    </li>

    <li class="mt-5">
        <a href="{{ route('account') }}"><ion-icon name="create-outline"></ion-icon> Editar Cuenta</a>
    </li>
    <li>
        <a href="{{ route('profile.image') }}"><ion-icon name="image-outline"></ion-icon> Foto de Perfil</a>
    </li>


    <li class="mt-5">
       <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger">
            <i data-feather="log-out"></i> <span>Cerrar Sesión</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </a>
    </li>
</ul>