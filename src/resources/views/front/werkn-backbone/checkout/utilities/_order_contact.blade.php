<div class="row">
	@guest
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="email">Correo <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="" required="" />

            <small>Te enviaremos tu resumen de compra y la guía a este correo, asegúrate que sea real.</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="email">Confirma tu Correo <span class="text-danger">*</span></label>
            <input type="email" id="email_confirm" class="form-control" autocomplete="off" name="email_confirm" value="" required="" />
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="name">Nombre(s) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="" required="" />
        </div>
    </div>
    @else
    <input type="hidden" class="form-control" name="email" value="{{ Auth::user()->email ?? old('email')}}" required="" />

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="name">Nombre(s) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name  ?? old('name') }}" required="" />
        </div>
    </div>
    @endguest
	
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="last-name">Apellidos <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name ?? old('last_name') }}" required="" />
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="phone"><ion-icon name="help-circle" class="pointer" data-bs-toggle="popover" data-bs-placement="left" title="¿Por qué necesitan mi teléfono?" data-bs-content="En casos muy raros es posible que tengamos que contactarte respecto a tu orden."></ion-icon> Teléfono <span class="text-danger">*</span></label>
            <input type="text" class="form-control phone-input" name="phone" value="{{ $address->phone ?? old('phone') }}" required="" />
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
        $('#email_confirm').keyup(function(){
            event.preventDefault();

            var email = $('#email').val();
            var confirm = $('#email_confirm').val();

            if (email == confirm) {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
                $('#email').removeClass('is-invalid');
                $('#email').addClass('is-valid');
            }else{
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $('#email').removeClass('is-valid');
                $('#email').addClass('is-invalid');
            }
        });
    });
</script>
@endpush