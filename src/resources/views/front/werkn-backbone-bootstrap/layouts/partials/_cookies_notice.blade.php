<style type="text/css">
  .overlay-cookie {
    position: fixed;
    width: 250px;
    background: black;
    color: white;
    border: solid 1px grey;
    padding: 20px; 
    bottom: 20px;
    left: 20px;
    z-index: 99;
    display: none;
  }

  .show-cookie{
    display: block;
  }

  .overlay-cookie h5{
    font-size: 1.1em;
  }

  .overlay-cookie p{
    font-size: .9em;
  }

  .close-div{
    text-align: right;
  }

  .close-icon {
    color: white;
    border: none;
    background-color: transparent;
  }

  @media (max-width: 760px) {
    .overlay-cookie {
      position: fixed;
      width: 70%;
      background: black;
      color: white;
      border: solid 1px grey;
      padding: 20px; 
      bottom: 0;
      left: 0;
      z-index: 99;
    }
  }
</style>

<div id="cookie-notice" class="overlay-cookie show-cookie">
  <div class="close-div">
    <button class="close-icon close-cookie">X</button>
  </div>

    <div class="fragment" >
        <div>
            <h5>Este sitio utiliza Cookies</h5>
            <p>Usamos cookies para proporcionarte una excelente experiencia de usuario. Al continuar en nuestro sitio aceptas nuestra politica de privacidad y nuestra política de uso de cookies.</p>

            <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 close-cookie">Acepto todas las Cookies</a>
            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm close-cookie">Solo acepto las necesarias</a>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    if (document.cookie.indexOf('cookie=notice_accepted') >= 0) {
      $('.overlay-cookie').removeClass('show-cookie');
    }else {
      $('.close-cookie').on("click", function() {
          document.cookie = ('cookie=notice_accepted');  

          $('.overlay-cookie').removeClass('show-cookie'); 
      });
    }
</script>
@endpush