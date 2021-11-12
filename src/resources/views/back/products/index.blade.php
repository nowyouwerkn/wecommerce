@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Productos</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('export.products') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                <i class="fas fa-file-export"></i> Exportar
            </a>
            <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                <i class="fas fa-file-import"></i> Importar
            </a>

            <a href="{{ route('products.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i> Nuevo producto
            </a>
        </div>
    </div>

    <style type="text/css">
        .status-circle{
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 5px;
            border-radius: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="col-12">
             <form role="search" action="{{ route('products.query') }}">
                <div class="input-group border-0">
                    <input type="search" name="query" class="form-control" placeholder="Busca tu producto">
                    <button class="btn btn-outline-secondary" type="submit">
                        <ion-icon style="font-size: 1.5rem;" name="search-outline"></ion-icon>
                    </button>
                </div>
            </form>
    </div>
@if($products->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_1.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Crea y administra tus productos</h4>
        <p class="mb-4">Empieza a cargar productos en tu plataforma usando el botón superior.</p>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Nuevo Producto</a>
    </div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">

                <div class="table-responsive">
                    @include('wecommerce::back.products.utilities._product_table')
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endif

<div id="modalImport" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('import.products') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Selecciona tu Archivo <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="import_file" required="" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar Documento</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection