@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Clientes</h4>
    </div>
    <div class="d-none d-flex align-items-center">
        <form role="search" action="{{ route('clients.search') }}" class="search-form mr-3">
            <input type="search"  name="query" class="form-control" style="height: calc(1.5em + 0.9375rem - 2px);" placeholder="Buscar por nombre o email...">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalUserRules" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5 mr-1">
             Reglas especiales
        </a>
        <a href="{{ route('export.clients') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
            <i class="fas fa-file-export"></i> Exportar
        </a>
        <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5 mr-1">
            <i class="fas fa-file-import"></i> Importar
        </a>
        
        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Agregar Cliente</a>
    </div>
</div>

<style type="text/css">
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
</style>
@endsection

@section('content')

@if($clients->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_3.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>Administra y conoce a tus clientes</h4>
    <p class="mb-4">En esta sección puedes administrar la información de tus clientes y ver su historial de compra.</p>

    <div class="d-flex align-items-center wd-300 justify-content-center ml-auto mr-auto">
        <a href="{{ route('clients.create') }}" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase">Agregar Cliente</a>
        <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
            Importar
        </a>
    </div>    
</div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dashboard">
                        <thead>
                            <tr>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Usuario</span>
                                        <a class="filter-btn" href="{{route('filter.clients', ['asc', 'name'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.clients', ['desc', 'name'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>

                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Fecha Registro</span>
                                        <a class="filter-btn" href="{{route('filter.clients', ['asc', 'created_at'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.clients', ['desc', 'created_at'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>

                                <th>
                                   <div class="d-flex align-items-center">
                                        <span class="table-title">Email</span>
                                        <a class="filter-btn" href="{{route('filter.clients', ['asc', 'email'])}}">
                                        <i class="icon ion-md-arrow-up"></i></a>
                                        <a class="filter-btn" href="{{route('filter.clients', ['desc', 'email'])}}">
                                        <i class="icon ion-md-arrow-down"></i></a>
                                    </div>
                                </th>

                                <th>Wishlist</th>

                                <th>Órdenes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></td>
                                <td>
                                    <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($client->created_at)->format('d M Y - H:i') }}</span>
                                </td>
                                <td>{{ $client->email }}</td>
                                <td>
                                    @php
                                        $wishlist = Nowyouwerkn\WeCommerce\Models\Wishlist::where('user_id', $client->id)->get();
                                    @endphp

                                    @if($wishlist->count() == NULL)
                                        <span class="badge badge-info">Sin Wishlist</span>
                                    @else
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-light dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ver Wishlist <i class="mdi mdi-chevron-down"></i>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start">
                                            @foreach($client->wishlists as $ws)
                                                <p class="dropdown-item">{{ $ws->product->name ?? '' }}</p>
                                            @endforeach 
                                        </div>
                                    </div>
                                    @endif 
                                </td>
                                <td>{{ $client->orders->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center justify-content-center">
                    {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif 

<div id="modalCreate" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

             <form method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre(s) <span class="tx-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Apellido(s) <span class="tx-danger">*</span></label>
                                <input type="text" name="lastname" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Correo <span class="tx-danger">*</span></label>
                                <input type="text" name="email" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Contraseña <span class="tx-danger">*</span></label>
                                <input type="text" name="password" class="form-control" required="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Teléfono <span class="text-info">(Opcional)</span></label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalUserRules" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar reglas de usuarios</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="p-1">Crear nueva regla especial para usuarios</h4>
            <form method="POST" action="{{ route('user-rules.store' ) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Tipo de promocion</label>
                                <input type="text" class="form-control" name="type" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Valor de promocion</label>
                                <input type="text" class="form-control" name="delivery_time" />
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                        <label class="custom-control-label" for="is_active"> Activado</label>
                    </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
            <hr>
            <h4 class="p-1">Actualizar reglas existentes</h4>
            @foreach($user_rules as $rule)
                <div class="modal-body pd-25">
                    <div class="row">
            <form method="POST" action="{{ route('user-rules.update', $rule->id ) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{$rule->type}}</label>
                                <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{  ($rule->is_active == 1 ? ' checked' : '') }}>
                                <label class="custom-control-label" for="is_active"> Activado</label>
                            </div>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Actualizar regla</button>
            </form>
            @endforeach
                </div>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modalImport" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nuevo Elemento</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('import.clients') }}" enctype="multipart/form-data">
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