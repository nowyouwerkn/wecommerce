@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Usuarios</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Agregar Usuario
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">
                        <form action="" method="POST" class="d-flex">
                            <div class="content-search col-6">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control" placeholder="Buscar SEO...">
                            </div>

                            <select class="custom-select tx-13">
                                <option value="1" selected>Estatus</option>
                                <option value="2">...</option>
                                <option value="3">...</option>
                                <option value="4">...</option>
                            </select>

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
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th class="text-right">Rol</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    SEO
                                </td>
                                <td>
                                    email@email.com
                                </td>
                                <td class="text-right">
                                    Administrador
                                </td>
                                <td class="text-right">
                                    <nav class="nav nav-icon-only justify-content-end">
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="" class="nav-link d-none d-sm-block">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
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