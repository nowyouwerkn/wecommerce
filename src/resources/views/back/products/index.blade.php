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
        <div class="d-none d-flex align-items-center">
            <form role="search" action="{{ route('products.query') }}" class="search-form mr-3">
                <input type="search"  name="query" class="form-control" style="height: calc(1.5em + 0.9375rem - 2px);" placeholder="Buscar por nombre, SKU...">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </form>

            <a href="{{ route('export.products') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                <i class="fas fa-file-export"></i> Exportar
            </a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                <i class="fas fa-file-import"></i> Importar
            </a>

            <a href="javascript:void(0)" data-toggle="modal" data-target="#createProductModal" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
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

        .filter-btn{
            border: none;
            background-color: transparent;
            color: rgba(27, 46, 75, 0.7);
            font-size: 12px;
            padding: 0px 2px;
        }

        .table .table-title{
            margin-right: 6px;
        }

        .filter-btn:hover{
            color: #000;
        }

        .table-dashboard thead th, .table-dashboard tbody td{
            white-space: initial;
        }

        .product-btn{
            background-color: #fff;
            border: 1px solid;
            border-color: #c0ccda;
            color: rgba(27, 46, 75, 0.7);
            padding: 50px 20px;
            display: inline-block;
            border-radius: 10px;
            width: 100%;
            min-height: 190px;
            transition: all .2s ease-in-out;
        }

        .product-btn img{
            width: 50px;
            margin-bottom: 15px;
        }

        .product-btn h5{
            font-size: 1em;
            margin-bottom: 0px;
        }

        .product-btn:hover{
            background-color: #dfe6e9;
        }

    </style>
@endsection

@section('content')
    @if($products->count() == 0)
        <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
            <img src="{{ asset('assets/img/group_1.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
            <h4>Crea y administra tus productos</h4>
            <p class="mb-4">Empieza a cargar productos en tu plataforma usando el botón superior.</p>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#createProductModal" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Nuevo Producto</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">

                    <div class="table-responsive">
                        @include('wecommerce::back.products.utilities._product_table')
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links() }}
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Producto</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 pr-2">
                            <a href="{{ route('products.create') }}" class="text-center product-btn">
                                <img src="{{ asset('assets/img/physical-product.png') }}" alt="">
                                <h5>Producto Físico</h5>
                            </a>
                        </div>
                        <div class="col-md-4 px-2">
                            <a href="{{ route('products.create.digital') }}" class="text-center product-btn">
                                <img src="{{ asset('assets/img/digital-product.png') }}" alt="">
                                <h5>Producto Digital</h5>
                            </a>
                        </div>
                        <div class="col-md-4 pl-2">
                            <a href="{{ route('products.create.subscription') }}" class="text-center product-btn">
                                <img src="{{ asset('assets/img/suscription-product.png') }}" alt="">
                                <h5>Suscripción</h5>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
