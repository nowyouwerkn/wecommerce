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

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Banners</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Banners</h4>
        </div>
    </div>
@endsection

@section('content')
<form method="POST" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Información General</h4>
                    <hr>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">Titulo</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $banner->title }}" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="subtitle">SubTitulo</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $banner->subtitle }}" required="" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="text_button">Texto en el boton</label>
                            <input type="text" class="form-control" id="text_button" name="text_button" value="{{ $banner->text_button }}" required="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="link">URL del boton</label>
                            <input type="url" class="form-control" id="link" name="link" value="{{ $banner->link }}" required="" />
                        </div>
                    </div>

                    <div class="row">
                        <!--
                        <div class="form-group col-md-6">
                            <label for="hex">Color</label>
                            <input type="color" class="form-control" id="hex" name="hex" value="{{ old('hex') }}" required="" />
                        </div>
                        -->

                        <div class="form-group col-md-12">
                            <label for="image">Imagen de banner</label>
                            <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                            <input type="file" id="image" name="image" onchange="loadFile(event)" required="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mt-4 mb-5">
                <a href="{{ route('banners.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-lg">Guardar Nuevo Banner</button>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Vista Previa</h4>
                    <hr>
                    <div class="d-flex">
                        <div class="card-banner d-flex justify-content-center align-items-center" id="hex_" style="background: {{ $banner->hex }}">
                            <div class="card-banner-content">
                                <h5 id="title_">{{ $banner->title }}</h5>
                                <p id="subtitle_">{{ $banner->subtitle}}</p>
                                <a href="#" class="btn btn-light rounded" id="text_button_">{{ $banner->text_button }}</a>
                            </div>
                            <img src="{{ asset('img/banners/' . $banner->image ) }}" id="output" class="card-banner-image" width="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection


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

    /*
    $("#hex").bind("keyup keydown change", function(){
        $("#hex_").css('background', $("#hex").val());
    });
    */

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