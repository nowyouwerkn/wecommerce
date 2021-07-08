<!-- About -->
<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Grandes momentos en comunidad</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <a href="#" class="btn btn-primary">Crea tu Cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        <img class="mb-2" src="../assets/brand/bootstrap-logo.svg" alt="" width="24" height="19">
        <small class="d-block mb-3 text-muted">&copy; 2017–2021</small>
      </div>
      <div class="col-6 col-md">
        <h5>Productos</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Zapatos</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Camisas</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Tennis</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Música</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Información</h5>
        <ul class="list-unstyled text-small">
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Tu Cuenta</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Nosotros</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Blog</a></li>
          <li class="mb-1"><a class="link-secondary text-decoration-none" href="#"></a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Legal</h5>
        <ul class="list-unstyled text-small">
            @foreach($legals as $legal)
            <li class="mb-1">
                <a class="link-secondary text-decoration-none" href="">
                    @switch($legal->type)
                        @case('Returns')
                            Política de Devoluciones
                            @break

                        @case('Privacy')
                            Política de Privacidad
                            @break

                        @case('Terms')
                            Términos y Condiciones
                            @break

                        @case('Shipment')
                            Política de Envíos
                            @break

                        @default
                            Hubo un problema, intenta después.
                    @endswitch 
                </a>
            </li>
            @endforeach
        </ul>
      </div>
    </div>
  </footer>
</section>

<!-- Footer -->
<footer>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="">
                            <ion-icon name="logo-twitter"></ion-icon>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="">
                            <ion-icon name="logo-linkedin"></ion-icon>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="">
                            <ion-icon name="logo-google"></ion-icon>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>
                </ul>
            </div>

            
            <div class="col text-end">
                <ul class="list-inline">
                    @foreach($legals as $legal)
                    <li class="list-inline-item me-2">
                        <a href="">
                            @switch($legal->type)
                                @case('Returns')
                                    Política de Devoluciones
                                    @break

                                @case('Privacy')
                                    Política de Privacidad
                                    @break

                                @case('Terms')
                                    Términos y Condiciones
                                    @break

                                @case('Shipment')
                                    Política de Envíos
                                    @break

                                @default
                                    Hubo un problema, intenta después.
                            @endswitch 
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>