@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">SEO</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">SEO</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>
@endsection

@section('content')

@if($seo == NULL)
<form method="POST" action="{{ route('seo.store') }}" enctype="multipart/form-data">
@else
<form method="POST" action="{{ route('seo.update', $seo->id) }}" enctype="multipart/form-data">
{{ method_field('PUT') }}
@endif
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4">
            <div class="pr-5 pt-1 pl-3">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                    <h4 class="mb-0 ml-2">Regresar</h4>
                </div>

                <h3>Search Engine Optimization (SEO)</h3>
                <p>Esta información te permite aparecer más efectivamente en los buscadores en Internet.</p>
                <!--<p>Al usar estas plantillas, aceptas que has leído y aceptado el descargo de responsabilidad.</p>-->

                <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios <i class="far fa-save"></i></button>
            </div>
        </div>
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-body">

                <h6 class="text-uppercase mb-3">Información General</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="page_title">Título general del sitio</label>
                                <input type="text" class="form-control" id="page_title" name="page_title" value="{{ $seo->page_title ?? '' }}"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="page_canonical_url">URL</label>
                                <input type="text" class="form-control" id="page_canonical_url" name="page_canonical_url" value="{{ $seo->page_canonical_url ?? '' }}"/>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="page_description">Descripción</label>
                                <textarea class="form-control" id="page_description" name="page_description" rows="5">{{ $seo->page_description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="page_keywords">Palabras Clave</label>
                            <input type="text" class="form-control" id="page_keywords" name="page_keywords" {{ $seo->page_keywords ?? '' }}"/>
                            <small class="form-text text-muted">Separa cada elemento con una coma o los robots de busqueda no podrán identificar las palabras.</small>
                        </div>

                        <div class="col-md-12">
                            <label for="page_theme_color_hex">Color (Tema)</label>
                            <input type="text" class="form-control" id="page_theme_color_hex" name="page_theme_color_hex" value="{{ $seo->page_theme_color_hex ?? '' }}"/>
                            <small class="form-text text-muted">Usa un valor HEX para determinar el color de tema de tu página.</small>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-uppercase mb-3">Configuración de ROBOTS.TXT para Google SEO</h6>

                    <div class="form-group">
                        <label for="image">Archivo Robots.txt</label>
                        <input type="file" id="image" name="image" id="image" />
                        <small class="form-text text-muted">Upload your text file with the proper configurations for robots. We'll take care of the rest.</small>
                    </div>

                    <hr>
                    <h6 class="text-uppercase mb-3">Opciones adicionales de SEO</h6>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="page_alternate_url">URL Alternativa</label>
                                <input type="text" class="form-control" id="page_alternate_url" name="page_alternate_url" value="{{ $seo->page_alternate_url ?? '' }}"/>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Archivo Browser Config XML</label>
                                <input type="file" id="image" name="image" id="image" />
                                <small class="form-text text-muted">Imagen tiene que ser 180x180 (Cualquier tamaño diferente será modificado a 180x180).</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Archivo MSTILE 150x150</label>
                                <input type="file" id="image" name="image" id="image" />
                                <small class="form-text text-muted">Imagen tiene que ser 150x150 (Cualquier tamaño diferente será modificado a 150x150).</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
