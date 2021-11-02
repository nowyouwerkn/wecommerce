@php
  $popup = Nowyouwerkn\WeCommerce\Models\Popup::where('is_active', true)->first();
@endphp

@if(!empty($popup))
<div class="modal fade wk-popup-modal" id="wkPopupModal" tabindex="-1" aria-labelledby="wkPopupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      <div class="modal-body">
        <div class="wk-modal-image">
          @if($popup->image == NULL)
          @else
          <img src="{{ asset('img/popups/' . $popup->image ) }}" alt="">
          @endif
        </div>

        <div class="wk-info-wrap">
          <h3>{{ $popup->title }}</h3>
          @if($popup->subtitle != NULL)
          <h5>{{ $popup->subtitle }}</h5>
          @endif

          <p>{{ $popup->text }}</p>

          @if($popup->has_button == true)
          <a href="{{ $popup->link }}" class="btn btn-primary mt-4">{{ $popup->text_button }}</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@if($popup->show_on_enter == true)
<script type="text/javascript">
  if (document.cookie.indexOf('modal_shown=') >= 0) {
  }
  else {
    $('#wkPopupModal').modal('show'); 
    document.cookie = 'modal_shown=seen';
  }
</script>
@endif

@if($popup->show_on_exit == true)
<script type="text/javascript">
  if (document.cookie.indexOf('modal_shown=') >= 0) {
  }
  else {
    $("html").bind("mouseleave", function () {
      $('#wkPopupModal').modal('show');
      $("html").unbind("mouseleave");
    });
    document.cookie = 'modal_shown=seen';
  }
</script>
@endif
@endif