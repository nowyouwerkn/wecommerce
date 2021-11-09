@if (count($errors) > 0)
<div class="alert alert-danger fade show alert-dismissable alert-fixed">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>¡Error!</strong>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif