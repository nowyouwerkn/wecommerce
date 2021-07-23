@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Apariencia / Personalizar</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Apariencia / Personalizar</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>

    <style type="text/css">
    .theme-methods .badge{
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Apariencia</h3>
            <p>Tu tienda puede tener la apariencia que quieras, solo es necesario subir tu carpeta de vista a la carpeta de vistas con un nombre único.</p>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card card-body mb-4 theme-methods">
            <h4>Temas Personalizados</h4>
            <p class="mb-4"><strong>Estos son los sistemas de vistas que tienes instalados en tu sistema</strong></p>

            @if($themes->count() == 0)
            <div class="text-center">
                <img src="{{ asset('assets/img/group_9.svg') }}" class="wd-40p ml-auto mr-auto mb-5">
                <h4>No hay sistemas de vista activas en tu plataforma.</h4>
                <p class="mb-4">Empieza dando click en el botón inferior.</p>
            </div>
            @else

            <div class="row">
                @foreach($themes as $theme)
                <div class="col-md-6">
                    <div class="card">
                        @if($theme->is_active == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif

                        @if($theme->image == NULL)
                            <img src="{{ asset('assets/themes/no-image.jpg') }}" class="card-img-top" alt="{{ $theme->name }}">
                        @else
                            <img src="{{ asset('assets/themes/' . $theme->image) }}" class="card-img-top" alt="{{  $theme->name }}">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $theme->name }}</h6>
                            <p class="card-text">{{ $theme->description }}</p>                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-outline-light btn-uppercase btn-block mt-3">Configurar una nueva Apariencia</a>
        </div>
    </div>
</div>


<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('themes.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="form-group col-md-6 mt-2">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="werkn-backbone">
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Versión <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="1.0.0" name="version">
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label>Imágen <span class="text-info">(Opcional)</span></label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Descripción <span class="text-info">(Opcional)</span></label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de esta apariencia se activará automáticamente. Si tienes otra apariencia activa en tu plataforma se desactivará.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar y Activar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection