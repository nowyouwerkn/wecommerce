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
                <li class="breadcrumb-item active" aria-current="page">Preguntas frecuentes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Preguntas frecuentes</h4>
        </div>
        <div class="d-none d-md-block">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateFAQ"  class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Agregar Pregunta frecuente</a>
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

            <h3>Preguntas frecuentes</h3>
            <p>Puedes crear tus propias preguntas frecuentes.</p>
            <p>Tus preguntas serán guardadas y vinculadas a su propia página dentro de tu sitio.</p>
            <!--<p>Al usar estas plantillas, aceptas que has leído y aceptado el descargo de responsabilidad.</p>-->
        </div>

    </div>
    <div class="col-md-8">
        @if($faqs->count() == 0)
        <div class="card card-body text-center" style="padding:50px 0px 50px 0px;">
            <img src="{{ asset('assets/img/group.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
            <h4>¡No hay textos preguntas frecuentes en la base de datos!</h4>
        </div>
        @else

            <table class="table table-dashboard">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                    <tr>
                        <td>{{ $faq->id }}</td>
                        <td>
                            {{ $faq->question }}
                        </td>
                        <td>
                            {{ $faq->answer }}
                        </td>
                        <td class="text-nowrap">
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-icon" href="javascript:void(0)" data-toggle="modal" data-target="#editFAQ_{{ $faq->id }}">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </a>

                            <form method="POST" action="{{ route('faq.destroy', $faq->id) }}" style="display: inline-block;">
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" data-toggle="tooltip" data-original-title="Borrar">
                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                </button>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>

                    <div id="editFAQ_{{ $faq->id }}" class="modal fade">
                        <div class="modal-dialog modal-dialog-vertical-center" role="document">
                            <div class="modal-content bd-0 tx-14">
                                <div class="modal-header">
                                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar Pregunta Frecuente</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('faq.update', $faq->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                    <div class="modal-body pd-25">
                                            <div class="form-group mt-2">
                                                <label>Pregunta</label>
                                                <input type="text" class="form-control" name="question" value="{{ $faq->question }}"/>

                                            <div class="form-group mt-2">
                                                <label>Respuesta</label>
                                                <div id="editor-container-create" class="ht-350 mb-4">

                                            </div>

                                            <textarea id="justHtml_create" name="answer" required="" style="display:none;" value="{{ $faq->answer }}"></textarea>
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

                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div id="modalCreateFAQ" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Añadir Pregunta Frecuente</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('faq.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                        <div class="form-group mt-2">
                            <label>Pregunta</label>
                            <input type="text" class="form-control" name="question" />

                        <div class="form-group mt-2">
                            <label>Respuesta</label>
                             <div id="editor-container-create" class="ht-350 mb-4">

                        </div>

                        <textarea id="justHtml_create" name="answer" required="" style="display:none;"></textarea>
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

@foreach($faqs as $faq)
<script type="text/javascript">

    var options_{{ $faq->id }} = {
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }]
            ]
        },
        placeholder: 'Comienza a escribir aquí...',
        theme: 'snow'
    };

    var editor_{{ $faq->id }} = new Quill('#editor-container-{{ $faq->id }}', options_{{ $faq->id }});
    var justHtmlContent_{{ $faq->id }} = document.getElementById('justHtml_{{ $faq->id }}');

    editor_{{ $faq->id }}.on('text-change', function() {
      var justHtml_{{ $faq->id }} = editor_{{ $faq->id }}.root.innerHTML;
      justHtmlContent_{{ $faq->id }}.innerHTML = justHtml_{{ $faq->id }};
    });

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
        placeholder: 'Comienza a escribir aquí...',
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
