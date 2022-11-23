@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sucursales</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Sucursales</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Sucursales</h3>
            <p>Gestiona los lugares donde conservas inventario, preparas pedidos y vendes productos.</p>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width: 50%">
                        <h6 class="text-uppercase mb-2">Sucursales</h6>
                        <p class="mb-0">Guarda tu configuración de envíos en tu plataforma. El valor predeterminado es $0.00</p>
                    </div>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateOption" class="btn btn-sm pd-x-15 btn-outline-primary btn-uppercase mg-l-5"><i class="fas fa-plus"></i> Crear Nueva Sucursal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCreateOption" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nueva Sucursal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form method="POST" action="{{ route('branches.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Nombre de la sucursal</label>
                        <input type="text" class="form-control" id="name" name="name" value="" required/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Nombre de Guía de Talla</label>
                        <input type="text" class="form-control" id="name" name="name" value=""/>
                    </div>

                    <hr>
                    <h5>Dirección</h5>
                    <hr>

                    <div class="form-group mt-2">
                        <label>País/Región</label>
                        <input type="text" class="form-control" id="name" name="name" value=""/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Calle y número de casa</label>
                        <input type="text" class="form-control" id="name" name="name" value=""/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Apartamento, local, etc</label>
                        <input type="text" class="form-control" id="name" name="name" value=""/>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Codigo Postal</label>
                                <input type="text" class="form-control" id="name" name="name" value=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Ciudad</label>
                                <input type="text" class="form-control" id="name" name="name" value=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Estado</label>
                                <input type="text" class="form-control" id="name" name="name" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" id="name" name="name" value=""/>
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

@endsection