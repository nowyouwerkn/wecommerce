@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cupones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Cupones</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('coupons.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i> Agregar Nuevo Cupón
            </a>
        </div>
    </div>
@endsection

@section('content')
@if($coupons->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_4.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>Administra y crea tus promociones y descuentos.</h4>
    <p class="mb-4">Crea cupones de un solo uso, de varios o aplica un descuento general a toda la tienda.</p>

    <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto"><i class="fas fa-plus"></i> Agregar Nueva Cupón</a>
</div>
@else
<div class="row">
    <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
            <div class="table-responsive">
                <table class="table table-dashboard">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Envío Gratis</th>
                            <th>Expira</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $cup)
                        <tr>
                            <td>{{ $cup->id }}</td>
                            <td>{{ $cup->code }}</td>
                            <td>{{ $cup->description }}</td>
                            <td>{{ $cup->type }}</td>
                            <td>{{ $cup->qty }}</td>
                            <td>
                                @if($cup->is_free_shipping == true)
                                <span class="badge badge-success">Si</span>
                                @else
                                <span class="badge badge-info">No</span>
                                @endif 
                            </td>
                            <td>
                                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($cup->end_date)->diffForHumans() }}</span>
                            </td>

                            <td>
                                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($cup->created_at)->diffForHumans() }}</span>
                            </td>
                            
                            <td class="d-flex">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#editModal_{{ $cup->id }}"  class="btn btn-link text-dark px-1 py-0">
                                    <i class="far fa-edit"></i>
                                </a>

                                <form method="POST" action="{{ route('coupons.destroy', $cup->id) }}" style="display: inline-block;">
                                    <button type="submit" class="btn btn-link text-danger px-1 py-0" data-toggle="tooltip" data-original-title="Borrar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>

                                <div class="modal fade" id="editModal_{{ $cup->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar Elemento</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('coupons.update', $cup->id) }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                                <div class="modal-body">
                                                    <div class="alert alert-info d-block">
                                                        Solo es posible cambiar el código y descripción del cupón. Cualquier otra configuración deberás crear otro. Si no estás contento con este cupón puedes eliminarlo.    
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Nombre de Elemento</label>
                                                                <input type="text" class="form-control" name="code" value="{{ $cup->code }}">
                                                            </div>

                                                            <div class="form-group mt-2">
                                                                <label>Descripción</label>
                                                                <textarea class="form-control" name="description">{{ $cup->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection