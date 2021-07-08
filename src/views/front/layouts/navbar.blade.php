<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-4">Werkn Commerce</span>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('index') }}" class="nav-link px-2 text-secondary">Inicio</a></li>
          <li><a href="{{ route('catalog') }}" class="nav-link px-2 text-white">Catálogo</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Nosotros</a></li>
          <li><a href="{{ route('blog') }}" class="nav-link px-2 text-white">Blog</a></li>
          <li><a href="{{ route('contact') }}" class="nav-link px-2 text-white">Contacto</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Búsqueda General..." aria-label="Search">
        </form>

        <div class="text-end">
          <a href="{{ route('profile') }}" class="btn btn-outline-light me-2"><ion-icon name="person-outline"></ion-icon> Tu Perfil</a>
          <a href="{{ route('cart') }}" class="btn btn-warning"><ion-icon name="cart-outline"></ion-icon> Carrito</a>
        </div>
      </div>
    </div>
</header>