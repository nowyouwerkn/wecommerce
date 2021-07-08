@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Variantes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Variantes</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>
            <a href="{{ route('variants.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Agregar categorias
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
                        <form action="{{ route('variants.index') }}" method="GET" class="d-flex">
                            <div class="content-search col-6">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control" name="name" placeholder="Buscar categoria...">
                            </div>

                            <select class="custom-select tx-13" name="order">
                                <option selected disabled="disabled">Ordenar</option>
                                <option value="desc">Recientes</option>
                                <option value="asc">Antiguos</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dashboard mg-b-0">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Variante</th>
                                <th class="text-right">Fecha de creación</th>
                                <th class="text-right">Fecha de edición</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variantTypes as $variantType)
                                <tr>
                                    <td>
                                        {{ $variantType->name }}
                                    </td>
                                    <td class="d-flex">
                                        @foreach ($variantType->variants as $vars)
                                            {{ $vars->name }} 
                                        @endforeach
                                    </td>
                                    <td class="text-right">{{ $variantType->created_at }}</td>
                                    <td class="text-right">{{ $variantType->updated_at }}</td>
                                    <td class="text-right">
                                        <nav class="nav nav-icon-only justify-content-end">
                                            <a href="{{ route('variants.edit', $variantType) }}" class="nav-link d-none d-sm-block">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <form action="{{ route('variants.destroy', $variantType) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn nav-link d-none d-sm-block">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            <a href="#add" data-toggle="modal" class="nav-link d-none d-sm-block">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ route('variants.storeStock') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content tx-14">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="exampleModalLabel2">Modal Title</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="name">Nombre de la variante</label>
                                                                        <input type="text" name="name" class="form-control" >
                                                                        <input type="text" name="type_id" value="{{ $variantType->id }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary tx-13">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </nav>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection