@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wecommerce</a></li>
            <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Newsletter</h4>
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

@if($newsletter->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_3.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>Administra y conoce a tus clientes con newsletter</h4>
    <p class="mb-4">En esta sección puedes administrar la información de tus clientes registrados para newsletter.</p>
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
                                        <span class="table-title">Nombre</span>
                                    </div>
                                </th>

                                <th>
                                     <div class="d-flex align-items-center">
                                        <span class="table-title">Email</span>
                                    </div>
                                </th>

                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="table-title">Fecha Registro</span>
                                    </div>
                                </th>

                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newsletter as $new)
                            <tr>
                                <td>{{ $new->name }}</td>
                                <td>{{ $new->e_mail }}</td>
                                <td>
                                    <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($new->created_at)->format('d M Y - H:i') }}</span>
                                </td>

                                <td>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalEdit{{$new->id}}" class="btn btn-outline-primary btn-sm btn-icon" >
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <form method="POST" action="{{ route('newsletter.destroy', $new->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" >
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>

<div id="modalEdit{{$new->id}}" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar registro de newsletter</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

             <form method="POST" action="{{ route('newsletter.update',$new->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre(s) <span class="tx-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{$new->name}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_mail">Correo <span class="tx-danger">*</span></label>
                                <input type="text" name="e_mail" class="form-control" value="{{$new->e_mail}}">
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
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center justify-content-center">
                    {{ $newsletter->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
