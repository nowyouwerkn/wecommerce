@extends('front.theme.werkn-backbone.layouts.main')

@push('seo')
<meta property="og:image" content="{{ asset('img/logo-color.png') }}">
<meta property="og:image:width" content="279">
<meta property="og:image:height" content="279">
<meta property="og:description" content="Everything in Gearcom comes from manufacturers who have the same values as us including high quality products and an excellent customer service.">
<meta property="og:title" content="Gearcom Shop |&nbsp;America Works Hard">
<meta property="og:url" content="https://gearcom.shop">
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
        height: 990px;
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
      top: 25%;
      left: 40px;
      z-index: 2;
      letter-spacing: -2px;
      width: 70%;
    }

    .special-text{
      padding: 50px 40px;
      padding-bottom: 100px;
      position: relative;
        top: 20%;
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
                        <h2>Gracias por tu Compra</h2>
                        <img src="{{ asset('img/modal-image.png') }}">    
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="special-text">
                        <p>We hope you enjoy the quality and confort that our top brands provide</p>
                        <hr>
                        <h4>Siguientes pasos...</h4>
                        @guest
                        <p class="alert alert-warning text-left" style="display: inline-block;"><ion-icon name="alert-circle-outline" class="mr-1"></ion-icon> Compraste esto como invitado pero se creó una cuenta para ti por si acas. Puedes acceder usando tu correo con el compraste y la contraseña: "<strong>wkshop</strong>"</p>
                        @endguest

                        <p>Te enviamos un corre oelectrónico con los detalles de tu orden. Esa información tambien puedes verificarla directamente en nuestro sitio dirigiendote a tus <a href="{{ route('shopping') }}">ordenes</a> en tu <a href="{{ route('profile') }}">perfil.</a></p>
                        <hr>
                        @php
                            $legals = Nowyouwerkn\WeCommerce\Models\Models\LegalText::all();
                        @endphp

                        <h5>Any questions?</h5>
                        <p class="mb-0">Puedes leer nuestros textos legales
                            @foreach($legals as $legal)
                                <a class="btn btn-link" href="{{ route('legal.help', [$legal->type, $legal->slug]) }}">{{ $legal->name }}</a> , 
                            @endforeach</p>

                        <a href="{{ route('profile') }}" class="btn btn-secondary btn-lg">Ir a mi perfil <ion-icon name="arrow-forward"></ion-icon></a>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('scripts-js')

@endsection