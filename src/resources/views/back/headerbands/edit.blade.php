@extends('wecommerce::back.layouts.main')

@section('stylesheets')
<style>
    h5#title_ {

        font-size: 2.5rem;
        line-height: 0.8;
    }

    p#subtitle_ {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #fff;
        letter-spacing: -1px;
        line-height: 0.95;
    }

    .btn#text_button_ {
        border-radius: 25px !important;
        font-size: 1rem;
        color: #212529;
        padding: 8px 35px 8px 35px !important;
    }

    .btn-light {
        color: #212529;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    /* --- Slider card --- */
    .card-banner {
        height: 350px;
        width: 350px;
        border-radius: 25px;
        -webkit-box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        -moz-box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        box-shadow: -1px 0px 14px -3px rgba(0,0,0,0.75);
        text-align: center;
        color: #fff;
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    .card-banner-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
        border-radius: 24px;
        z-index: -1;
    }

    .card-banner .btn{
        color: #fff;
    }
</style>
@endsection
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
                <li class="breadcrumb-item active" aria-current="page">Cintillo Promocional</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Cintillo Promocional</h4>
        </div>
    </div>
@endsection

@section('content')

<form method="POST" action="{{ route('band.update', $headerband->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4>Información General</h4>
                    <hr>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $headerband->title }}" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="band_link">URL del cintillo <span class="text-info">(Opcional)</span></label>
                            <input type="text" class="form-control" id="band_link" name="band_link" value="{{ $headerband->band_link }}" />
                        </div>

                        <div class="form-group col-md-12">
                            <label>Texto  <span class="text-danger">*</span></label>
                            <div id="editor-container-create" class="ht-350 mb-4">{!! $headerband->text ?? '' !!}</div>
                            <textarea id="justHtml_create" name="text" required="" style="display:none;">{!! $headerband->text ?? '' !!}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="text_button">Color del texto<span class="text-danger">*</span></label>
                            <input type="color" class="form-control" name="hex_text" value="{{ $headerband->hex_text }}" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="text_button">Color del cintillo<span class="text-danger">*</span></label>
                            <input type="color" class="form-control" value="{{ $headerband->hex_background }}" name="hex_background" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="priority">Prioridad</label>

                            <select name="priority" class="form-control">
                              <option {{ ($headerband->priority == '1') ? 'selected' : '' }} value="1">1</option>
                              <option {{ ($headerband->priority == '2') ? 'selected' : '' }} value="2">2</option>
                              <option {{ ($headerband->priority == '3') ? 'selected' : '' }} value="3">3</option>
                              <option {{ ($headerband->priority == '4') ? 'selected' : '' }} value="4">4</option>
                              <option {{ ($headerband->priority == '5') ? 'selected' : '' }} value="5">5</option>
                              <option {{ ($headerband->priority == '6') ? 'selected' : '' }} value="6">6</option>
                              <option {{ ($headerband->priority == '7') ? 'selected' : '' }} value="7">7</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mt-4 mb-5">
                <a href="{{ route('band.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-lg">Guardar cambios al Cintillo</button>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4>Vista Previa</h4>
                    <hr>
                    <div class="d-flex">
                        <div class="card-banner d-flex justify-content-center align-items-center" id="hex_">
                            <div class="card-banner-content">
                                <h5 class="card p-4" id="title_" style="background: {{ $headerband->hex_background }}; color: {{ $headerband->hex_text }}">Texto</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>




@endsection


@push('scripts')
<script src="{{ asset('lib/quill/quill.min.js') }}"></script>
<script>
    $("#title").bind("keyup keydown change", function(){
        $("#title_").html($("#title").val());
    });

    $("#subtitle").bind("keyup keydown change", function(){
        $("#subtitle_").html($("#subtitle").val());
    });

    $("#text_button").bind("keyup keydown change", function(){
        $("#text_button_").html($("#text_button").val());
    });

    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output');
            output.src = "";
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>


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