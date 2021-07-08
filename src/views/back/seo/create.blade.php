@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">SEO</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Crear Seos</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('seos.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form action="" method="POST">
        <div class="row">
            <!-- Firts Column -->
            <div class="col-md-8">
                <!-- Infomation General -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Datos generales</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Datos generales.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="client">Titulo</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keywords">KeyWords</label>
                                <input type="text" name="keywords" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="canonical_url">Canonical URL</label>
                                <input type="url" name="canonical_url" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alternative_url">Alternativa URL</label>
                                <input type="url" name="alternative_url" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="og_type">OG Type</label>
                                <input type="text" name="og_type" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="og_url">OG Logo URL</label>
                                <input type="url" name="og_url" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="analytics">Analytics</label>
                                <input type="text" name="analytics" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
@endsection