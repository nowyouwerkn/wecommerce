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
<style type="text/css">

    .hidden-form{
        display: none;
    }

    .selector {
        margin:  1rem;
        border:  1px solid black;
    }
    .cube {
        width: 100%;
        height: 60px;
        border: 1px solid grey;
        margin: 0.5rem;
        outline: 2px solid #333;
        box-sizing: border-box;
        appearance: none;
        background: white;
        border: 3px solid white;

    }
    .cube:checked {
         background: #333;
    }

    .cube:hover {
        background-color: grey;
        cursor: pointer;
    }


</style>
@endpush

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pop-ups</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Pop-ups</h4>
        </div>
    </div>
@endsection

@section('content')
<form method="POST" action="{{ route('popups.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4>Información General</h4>
                    <hr>
                    
                    <div class="row">
                    <div class="form-group col-md-12">
                        <label for="style_type">Tipo de popup <span class="text-danger">*</span></label>
                        <select id="style_type" name="style_type" class="form-control" onchange="showDiv('selector', this)">
                            <option value="fixed">Fijo</option>
                            <option value="floating">Flotante</option>
                        </select>
                    </div>
                        <div class="form-group col-md-6">
                            <label for="title">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="subtitle">Subtítulo <span class="text-info">(Opcional)</span></label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" />
                        </div>

                        <div class="form-group col-md-12">
                        	<label>Texto <span class="text-info">(Opcional)</span></label>
                        	<textarea class="form-control" id="body_text" name="text"></textarea>
                        </div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" checked="true" class="custom-control-input" id="show_on_enter" name="show_on_enter" value="1">
                                <label class="custom-control-label" for="show_on_enter">Mostrar al cargar la página</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="show_on_exit" name="show_on_exit" value="1">
                                <label class="custom-control-label" for="show_on_exit">Mostrar al salir de la página</label>
                            </div>
                        </div>
                    </div>

     
                    <hr>

                    <div class="row">
                    	<!--
                        <div class="form-group col-md-6">
                            <label for="hex">Color</label>
                            <input type="color" class="form-control" id="hex" name="hex" value="{{ old('hex') ?? 'red' }}" required="" />
                        </div>
						-->

                        <div class="form-group col-md-12">
                            <label for="image">Imagen del popup <span class="text-success">Recomendado</span></label>
                            <input type="file" id="image" class="form-control"  name="image" />
                        </div>
                    </div>

                    <div class="row mt-3">
                    	<div class="col-md-12">
                    		<div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="has_button" name="has_button" value="1">
                                <label class="custom-control-label" for="has_button">Mostrar Botón</label>
                            </div>
                    	</div>

                        <div class="form-group col-md-6">
                            <label for="text_button">Texto en el botón <span class="text-info">(Opcional)</span></label>
                            <input type="text" class="form-control" id="text_button" name="text_button" value="{{ old('text_button') }}" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="link">URL del botón <span class="text-info">(Opcional)</span></label>
                            <input type="url" class="form-control" id="link" name="link" value="{{ old('link') }}" />
                        </div>
                        <div id="selector" class="form-group col-md-12 hidden-form">
                            <label for="priority">Posición</label>
                            <div class="row selector" name="priority">

                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="top-left"> </input> 
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="top-mid"> </input>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="top-right"> </input>
                                </div>

                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="mid-left"> </input> 
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="mid-mid"> </input>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="mid-right"> </input>
                                </div>

                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="bottom-left"> </input> 
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="bottom-mid"> </input>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" class="cube" name="position" value="bottom-right"> </input>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="text-right mt-4 mb-5">
                <a href="{{ route('popups.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-lg">Guardar Nuevo Banner</button>
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
                                <h5 id="title_">Título</h5>
                                <p id="subtitle_">Subtítulo</p>
                                <a href="#" class="btn btn-light rounded" id="text_button_">Texto del botón</a>
                            </div>
                            <img class="card-banner-image" id="output"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@push('scripts')
<script>
    function showDiv(divId, element)
    {
        document.getElementById(divId).style.display = element.value == 'floating' ? 'block' : 'none';
    }
</script>
@endpush
@section('scripts')
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
@endsection