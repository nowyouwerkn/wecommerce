@if(Session::has('success'))
<div class="alert alert-success fade show alert-dismissable alert-fixed">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>¡Éxito!</strong> {{ Session::get('success') }}
</div>
@endif

@if(Session::has('warning'))
<div class="alert alert-warning fade show alert-dismissable alert-fixed">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>¡Proceso Correcto!</strong> {{ Session::get('warning') }}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger fade show alert-dismissable alert-fixed">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>¡Error!</strong> {{ Session::get('error') }}
</div>
@endif

@if (count($errors) > 0)
    
<div class="alert alert-danger fade show alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>¡Error!</strong>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>

@endif