@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')
<meta property="og:image" content="{{ asset('img/logo-color.png') }}">
<meta property="og:image:width" content="279">
<meta property="og:image:height" content="279">
<meta property="og:description" content="">
<meta property="og:title" content="">
<meta property="og:url" content="">
@endpush

@section('content')
<style type="text/css">
    .modal-special{

    }

    .btn-secondary{
      color: #fff !important;
      padding: 10px 40px;
      z-index: 2;
      font-size: 2em;
      width: 50%;
      text-align: center;
      margin-top: 30px;
      margin-bottom: 80px;
    }

    .content{
      border: none;
    }

    .image-wrap{
        position: relative;
        overflow: hidden;
        height: 100%;
        margin-bottom: -48px;
    }

    .image-wrap img{
      position: absolute;
      top: 0px;
      left: 0px;
      height: 100%;
      width: auto !important;
      opacity: .8;
    }

    .image-wrap h2{
      line-height: .9em;
      font-size: 5em;
      position: absolute;
      top: 20%;
      left: 40px;
      z-index: 2;
      letter-spacing: -2px;
      width: 70%;
    }

    .special-text{
      padding: 50px 40px;
      padding-bottom: 100px;
      position: relative;
        top: 15%;
    }

    .tracking-purchase{
      border: 4px solid #f16321;
      border-radius: 13px;
      padding: 12px 20px 8px 20px;
      color: #f16321;
    }

    .tracking-purchase h6{
      font-size: 3.2em;
      margin: 0;
    }

    .tracking-purchase p{
      font-size: .8em;
      margin-bottom: -5px;
      text-transform: uppercase;
      letter-spacing: -1px;
    }

    a{
      color: #f16321;
      font-weight: bold;
    }

    .btn-link{
        padding: 0px 4px !important;
    }
</style>
    <main class="purchase-complete">
        <div class="container text-purchase">
            <div class="row">
                <div class="col-md-4">
                    <div class="image-wrap">
                        <h2>Gracias por tu compra</h2>
                        <img src="{{ asset('img/modal-image.jpg') }}">    
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="special-text">
                        <h4>Siguientes pasos...</h4>

                        @guest
                        <p class="alert alert-warning text-left" style="display: inline-block;"><ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Compraste esto como invitado pero se creó una cuenta para ti para que puedas dar seguimiento a tu órden. Puedes acceder usando tu correo con el que hiciste tu compra y la contraseña: "<strong>wkshop</strong>"</p>
                        @endguest

                        <p>Te enviamos un correo electrónico con los detalles de tu orden. Esa información tambien puedes verificarla directamente en nuestro sitio dirigiendote a tus <a href="{{ route('shopping') }}">ordenes</a> en tu <a href="{{ route('profile') }}">perfil.</a></p>
                        <hr>
                        @php
                            $legals = Nowyouwerkn\WeCommerce\Models\LegalText::all();
                        @endphp

                        <h5>¿Alguna pregunta?</h5>
                        <p class="mb-0">Puedes leer nuestros textos legales:</p>
                        <ul>
                            @foreach($legals as $legal)
                            <li>
                                <a href="{{ route('legal.text' , $legal->type) }}">
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

                        <a href="{{ route('profile') }}" class="btn btn-secondary btn-lg">Ir a mi perfil <ion-icon name="arrow-forward"></ion-icon></a>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('scripts-js')

@endsection