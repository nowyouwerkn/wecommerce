@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inventario</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Inventario</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Table -->
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">
                        <form action="" method="POST" class="d-flex">
                            <div class="content-search col-6">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control" placeholder="Buscar en Inventario...">
                            </div>

                            <select class="custom-select tx-13">
                                <option value="1" selected>Ordenar</option>
                                <option value="2">...</option>
                                <option value="3">...</option>
                                <option value="4">...</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dashboard mg-b-0">
                        <thead>
                            <tr>
                                <th>Imagenes</th>
                                <th>Producto</th>
                                <th class="text-right">SKU</th>
                                <th class="text-right">Cantidad</th>
                                <th class="text-right">Variante</th>
                                <th class="text-right">Editar Variante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tx-color-03 tx-normal image-table">
                                    <img src="http://placehold.jp/99ccff/2475c7/300x300.png?text=w" alt="">
                                </td>
                                <td>
                                    Producto
                                    <br>
                                    Este es un producto muy bueno
                                </td>
                                <td class="text-right">
                                    hyjh78
                                </td>
                                <td class="text-right">400</td>
                                <td class="text-right">20</td>
                                <td class="text-right">
                                    <!--<nav class="nav nav-icon-only justify-content-end">
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </nav>-->
                                </td>
                            </tr>
                            <tr>
                                <td class="tx-color-03 tx-normal image-table">

                                </td>
                                <td>
                                    Producto
                                    <br>
                                    Este es un producto muy bueno
                                </td>
                                <td class="text-right">
                                    hyjh78
                                </td>
                                <td class="text-right">
                                    400
                                </td>
                                <td class="text-right">
                                    20
                                </td>
                                <td class="text-right">
                                    <nav class="nav nav-icon-only justify-content-end">
                                        <div class="form-group w-50">
                                            <input type="number" name="amount" class="form-control">
                                        </div>
                                    </nav>
                                </td>
                            </tr>
                            <tr>
                                <td class="tx-color-03 tx-normal image-table">

                                </td>
                                <td>
                                    Producto
                                    <br>
                                    Este es un producto muy bueno
                                </td>
                                <td class="text-right">
                                    hyjh78
                                </td>
                                <td class="text-right">
                                    400
                                </td>
                                <td class="text-right">
                                    20
                                </td>
                                <td class="text-right">
                                    <nav class="nav nav-icon-only justify-content-end">
                                        <div class="form-group w-50">
                                            <input type="number" name="amount" class="form-control">
                                        </div>
                                    </nav>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection