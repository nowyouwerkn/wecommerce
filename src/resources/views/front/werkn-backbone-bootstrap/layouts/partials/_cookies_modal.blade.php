@php
  $popup = Nowyouwerkn\WeCommerce\Models\Popup::where('is_active', true)->first();
@endphp


<div class="modal fade wk-popup-modal" id="wkcookiesModal" tabindex="-1" aria-labelledby="wkcookiesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      <div class="modal-body">
        <div class="wk-modal-image">
        </div>

        <div class="wk-info-wrap">
          <h3>Poliza de cookies</h3>
        
          <h5>Al usar este sitio aceptas nuestra Poliza de cookies, Terminos y Condiciones</h5>

          <p>{{ $popup->text }}</p>

          <button type="button" class="" data-bs-dismiss="modal" aria-label="Close">Acepto</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
        $("#wkcookiesModal").modal('show');
    });
  if (document.cookie.indexOf('cookies_shown=') >= 0) {
  }
  else {
 
    $('#wkcookiesModal').modal('show'); 
    document.cookie = 'cookies_shown=seen; max-age=7776000;';
  }
</script>
