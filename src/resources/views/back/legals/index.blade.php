@extends('wecommerce::back.layouts.main')


@push('stylesheets')
<link href="{{ asset('lib/quill/quill.core.css') }}" rel="stylesheet">
<link href="{{ asset('lib/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('lib/quill/quill.bubble.css') }}" rel="stylesheet">

<style type="text/css">
    .ht-350{
        height: 350px;
    }
</style>
@endpush

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Textos Legales</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Textos Legales</h4>
        </div>
        <div class="d-none d-md-block">
             <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateLegalText"  class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Agregar Texto legal</a>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-1 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Páginas legales</h3>
            <p>Puedes crear tus propias páginas legales.</p>
            <p>Tus políticas guardadas se vincularán en el pie de página de tu pantalla de pago y los menús de tu tienda.</p>
            <!--<p>Al usar estas plantillas, aceptas que has leído y aceptado el descargo de responsabilidad.</p>-->
        </div>
        
    </div>
    <div class="col-md-8">
        @if($legals->count() == 0)
        <div class="card card-body text-center" style="padding:50px 0px 50px 0px;">
            <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
            <h4>¡No hay textos legales guardadas en la base de datos!</h4>
            <a href="" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto mt-4">Reparar</a>
        </div>
        @else
            @foreach($legals as $legal)
            <form method="POST" action="{{ route('legals.update', $legal->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">
                        <input type="text" name="title" value="{{ $legal->title }}" required="" />
                        </h4>

                    
                            <input type="hidden" name="type" value="{{ $legal->type }}">
                            <!--<textarea name="description" id="" class="form-control" cols="30" rows="10">{!! $legal->description ?? '' !!}</textarea>-->


                        <div id="editor-container-{{ $legal->id }}" class="ht-350 mb-4">
                            {!! $legal->description ?? '' !!}
                        </div>
                        
                        <textarea id="justHtml_{{ $legal->id }}" name="description" required="" style="display:none;">{!! $legal->description ?? '' !!}</textarea>

                        <button type="submit" class="btn btn-outline-success"><i class="far fa-save"></i> Guardar información</a>
                    </div>
                </div>
            </form>
            @endforeach
        @endif
    </div>
</div>

<div id="modalCreateLegalText" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Añadir texto legal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('legals.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                   <div class="modal-body pd-25">
                        <div class="form-group mt-2">
                            <label>Titulo</label>
                            <input type="text" class="form-control" name="title" />

                        <div class="form-group mt-2">
                            <label>Descripcion</label>
                             <div id="editor-container-create" class="ht-350 mb-4">
                            
                        </div>
                        
                        <textarea id="justHtml_create" name="description" required="" style="display:none;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection

@push('scripts')
<script src="{{ asset('lib/quill/quill.min.js') }}"></script>

@foreach($legals as $legal)
<script type="text/javascript">
    
    var options_{{ $legal->id }} = {
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }]
            ]
        },
        placeholder: 'Comienza a escribir aqui...',
        theme: 'snow'
    };

    var editor_{{ $legal->id }} = new Quill('#editor-container-{{ $legal->id }}', options_{{ $legal->id }});
    var justHtmlContent_{{ $legal->id }} = document.getElementById('justHtml_{{ $legal->id }}');

    editor_{{ $legal->id }}.on('text-change', function() {
      var justHtml_{{ $legal->id }} = editor_{{ $legal->id }}.root.innerHTML;
      justHtmlContent_{{ $legal->id }}.innerHTML = justHtml_{{ $legal->id }};
    });


    /*
    $(function(){
        'use strict'

        var quill = new Quill('#editor-container-{{ $legal->id }}', {
          modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }]
            ]
          },
          placeholder: 'Comienza a escribir aqui...',
          theme: 'snow'
        });
    });
    */
</script>
@endforeach
<script type="text/javascript">
    var options_create = {
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }]
            ]
        },
        placeholder: 'Comienza a escribir aqui...',
        theme: 'snow'
    };

    var editor_create = new Quill('#editor-container-create', options_create);
    var justHtmlContent_create = document.getElementById('justHtml_create');

    editor_create.on('text-change', function() {
      var justHtml_create = editor_create.root.innerHTML;
      justHtmlContent_create.innerHTML = justHtml_create;
    });
</script>
@endpush