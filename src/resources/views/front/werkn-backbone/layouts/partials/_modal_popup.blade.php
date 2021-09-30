@php
    $popup = Nowyouwerkn\WeCommerce\Models\Popup::where('is_active', true)->first();
@endphp

@if(!empty($popup))
  <style type="text/css">
    .wk-popup-modal .modal-body{

    }

    .wk-popup-modal .modal-dialog{
      margin-top: 6em;
    }

    .wk-popup-modal .btn-close{
      position: absolute;
      top: -15px;
      right: -15px;
      z-index: 2;
      width: 45px;
      height: 45px;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 100%;
      line-height: 45px;
    }

    .wk-popup-modal .modal-body{
      padding: 0px;
      position: relative;
      display: flex;
    }

    .wk-modal-image{
      width: 40%;
      position: relative;
      overflow: hidden;
      height: 100%;
      min-height: 350px;
    }

    .wk-modal-image img{
      position: absolute;
      top: 50%;
      left: 50%;
      height: 150%;
      transform: translate(-50%,-50%);
    }

    .wk-info-wrap{
      width: 60%;
      padding: 30px 40px;
    }

  </style>

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
  /*
  $(document).ready(function() {
    $('#wkPopupModal').modal('show');
  });
  */

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