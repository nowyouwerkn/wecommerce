@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<style>
    .icon-box{
        text-align: center;
        padding: 10px;
        height: 100%;
        border:1px dotted grey;
        border-radius: 5px;
        margin-right: 10px;
    }

    .icon-box i{
        color: grey;
    }
</style>
@endpush

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
                    </div>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateOption" class="btn btn-sm pd-x-15 btn-outline-primary btn-uppercase mg-l-5"><i class="fas fa-plus"></i> Crear Nueva Sucursal</a>
                </div>

                @if($branches->count() == 0)
                <div class="d-block text-center mt-5 pt-2">
                    <img src="{{ asset('assets/img/group_6.svg') }}" class="wd-30p mg-l-20">
        
                    <div class="mg-l-40 mt-4">
                      <h6 class="mb-2">No has registrado sucursales en tu plataforma</h6>
                      <p class="tx-color-03 mg-b-10">Sin la existencia de sucursales tu inventarios solo considerará las existencias que registres en tus productos.</p>
                    </div>
                  </div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="icon-box">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $branch->name }}</strong><br>
                                            <small>{{ $branch->street . ' ' . $branch->street_num . ' ' . $branch->postal_code . ' ' . $branch->city . ' ' . $branch->state . ', ' . $branch->country_id }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($branch->is_default == true)
                                    <span class="badge badge-success">Predeterminado</span>
                                    @endif 
                                </td>
                            
                                <td class="d-flex">
                                    <form method="POST" action="{{ route('branches.destroy', $branch->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-sm btn-light" data-toggle="tooltip" data-original-title="Borrar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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
                        <label>Nombre de la sucursal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="" required/>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="is_warehouse" name="is_warehouse" value="1" checked>
                        <label class="custom-control-label" for="is_warehouse">Preparar pedidos online desde esta sucursal</label><br>
                        <small id="textHelp">El inventario en esta sucursal está disponible para la venta online</small>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_default" name="is_default" value="1">
                        <label class="custom-control-label" for="is_default">Esta sucursal es la predeterminada</label>
                    </div>

                    @push('scripts')
                        <script>
                            $('#is_warehouse').on('click', function(e){
                                if($(this).is(':checked')){
                                    $('#textHelp').text('El inventario en esta sucursal está disponible para la venta online');
                                }else{
                                    $('#textHelp').text('El inventario en esta sucursal no está disponible para la venta online');
                                }
                            });
                        </script>
                    @endpush
                    <hr>
                    <h5>Dirección</h5>
                    <hr>

                    <div class="form-group mt-2">
                        <label>País/Región <span class="text-danger">*</span></label>
                        <select class="form-control" name="country_id">
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label>Calle y número de casa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="street" name="street" value=""/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Apartamento, local, etc <span class="text-info">(Opcional)</span></label>
                        <input type="text" class="form-control" id="street_num" name="street_num" value=""/>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Codigo Postal <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" value=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Ciudad <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control" id="city" name="city" value=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label>Estado <span class="text-info">(Opcional)</span></label>
                                <input type="text" class="form-control" id="state" name="state" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label>Teléfono <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value=""/>
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