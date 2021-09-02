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
        <div class="d-none d-md-block">
            <a href="{{ route('export.clients') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                <i class="fas fa-file-export"></i> Exportar
            </a>
            <a href="javascript:void(0)"  data-toggle="modal" data-target="#modalImport" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5 mr-1">
                <i class="fas fa-file-import"></i> Importar
            </a>
            
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Agregar Cliente</a>
        </div>
    </div>
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
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">

                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha Registro</th>
                                <th>Email</th>
                                <th>Wishlist</th>
                                <th>Órdenes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></td>
                                <td>
                                    <span class="text-muted"><i class="iconsminds-timer"></i> {{ Carbon\Carbon::parse($client->created_at)->format('d M Y, H:i') }}</span>
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