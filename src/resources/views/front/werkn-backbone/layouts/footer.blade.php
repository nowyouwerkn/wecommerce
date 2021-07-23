<!-- promo-services -->
<section class="promo-services gray-bg pt-70 pb-25">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="promo-services-item mb-40">
                    <div class="icon"><img src="{{ asset('themes/werkn-backbone/img/icon/promo_icon01.png') }}" alt=""></div>
                    <div class="content">
                        <h6>Entrega a Domicilio</h6>
                        <p>Te lo enviamos y lo recibes.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="promo-services-item mb-40">
                    <div class="icon"><img src="{{ asset('themes/werkn-backbone/img/icon/promo_icon02.png') }}" alt=""></div>
                    <div class="content">
                        <h6>Devoluciones</h6>
                        <p>Cambia y regresa varias veces</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="promo-services-item mb-40">
                    <div class="icon"><img src="{{ asset('themes/werkn-backbone/img/icon/promo_icon03.png') }}" alt=""></div>
                    <div class="content">
                        <h6>Garantía de satisfacción</h6>
                        <p>Si no te gusta te regresamos tu dinero.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="promo-services-item mb-40">
                    <div class="icon"><img src="{{ asset('themes/werkn-backbone/img/icon/promo_icon04.png') }}" alt=""></div>
                    <div class="content">
                        <h6>Atención al cliente</h6>
                        <p>Te atendemos siempre contentos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- promo-services-end -->

@php
    $legals = Nowyouwerkn\WeCommerce\Models\LegalText::all();
@endphp

<footer class="dark-bg pt-55 pb-80">
    <div class="container">
        <div class="footer-top-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="footer-logo">
                        <a href="index.html"><img src="{{ asset('themes/werkn-backbone/img/logo/w_logo.svg') }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="footer-link-wrap">
                        <nav class="menu-links">
                            <ul>
                                <li><a href="{{ route('index') }}">Inicio</a></li>
                                <li><a href="{{ route('catalog.all') }}">Catálogo</a></li>
                                @foreach($legals as $legal)
                                <li>
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
                        </nav>
                        <div class="footer-social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="copyright-text">
                        <p>&copy; 2021 <a href="index.html"> {{ $store_config->store_name ?? 'LagerHaus powered by Werkn WeCommerce' }}</a>. Todos los derechos reservados | Tel. (477) 555 55 55</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pay-method-img">
                        <img src="{{ asset('themes/werkn-backbone/img/images/payment_method_img.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>