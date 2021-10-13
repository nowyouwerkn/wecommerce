@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Envíos</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Envíos</h4>
        </div>
    </div>

    <style type="text/css">
        .payment-methods .badge{
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="pr-5 pt-4 pl-3">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('configuration') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
                <h4 class="mb-0 ml-2">Regresar</h4>
            </div>

            <h3>Pasarelas de Envío</h3>
            <p>Genera guías y calcula automáticamente los envíos usando pasarelas de pago.</p>

            <p>Tu tienda puede vincularse con: </p>

            <ul>
                <li>UPS (Cálculo de Énvio Solo Estados Unidos)</li>
                <li>FedEx <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>Estafeta <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>DHL <span class="badge badge-info">PROXIMAMENTE</span></li>
                <li>Gearcom <span class="badge badge-info">PROXIMAMENTE</span></li>
            </ul>
        </div>    
    </div>

    <div class="col-md-8">
        <div class="card mb-4 payment-methods">
            <div class="card-body">
                <h4>Configuración Manual</h4>
                <p class="mb-0">Guarda tu configuración de envíos en tu plataforma. El valor predeterminado es $0.00</p>
            </div>
            
            <div class="card-header" style="border-bottom: none;">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">
                        <i class="fas fa-shipping-fast"></i>
                        Tarifa Regular
                    </h4>
                    <div class="d-flex align-items-center">
                        @if(!empty($manual_method))
                            <span class="badge badge-success">Activado</span>
                        @else
                            <span class="badge badge-primary">Sin Configurar</span>
                        @endif

                        <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="manual">
                        <input type="hidden" name="supplier" value="WeCommerce">
                            <div class="d-flex">
                                <div class="input-group wd-150">
                                    <input type="text" class="form-control" name="cost" placeholder="0.00" value="{{ $manual_method->cost ?? '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            @if($config->get_country_name() == 'México')
                                            MXN
                                            @else
                                            USD
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <button class="btn btn-sm pd-x-15 btn-white btn-uppercase ml-1" type="submit"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-uppercase mb-0">Reglas Especiales de Envíos</h6>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateRule" class="btn btn-outline-primary btn-sm">Crear nueva Regla</a>
                </div>

                @if($shipment_rules->count() == 0)
                <div class="text-center">
                    <p class="mb-0"><em>Sin reglas especiales en la tienda.</em></p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Regla</th>
                                <th>Permite cupones</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shipment_rules as $rule)
                            <tr>
                                <td>
                                <span style="margin-right: 2px"><strong>{{ $rule->type }}</strong></span>
                                <span style="margin-right: 2px">cuando <strong>{{ $rule->condition }}</strong> sea</span>
                                <span style="margin-right: 2px">
                                <strong>
                                @switch($rule->comparison_operator)
                                    @case('==')
                                        igual a
                                        @break

                                    @case('!=')
                                        no igual a
                                        @break

                                    @case('<')
                                        menor que
                                        @break

                                    @case('<=')
                                        menor que o igual a
                                        @break

                                    @case('>')
                                        mayor que
                                        @break

                                    @case('>=')
                                        mayor que o igual a
                                        @break

                                    @default
                                        Error. Elimina esta regla.
                                @endswitch
                                </strong>
                                </span>

                                <span style="margin-right: 2px"><strong>{{ number_format($rule->value) }}</strong></span>
                                </td>

                                <td>
                                    @if($rule->allow_coupons == true)
                                    <span class="badge badge-success">Si</span>
                                    @else
                                    <span class="badge badge-info">No</span>
                                    @endif 
                                </td>
                                <td>
                                    @if($rule->is_active == true)
                                    <span class="badge badge-success">Activado</span>
                                    @else
                                    <span class="badge badge-danger">Desactivado</span>
                                    @endif 
                                </td>
                            
                                <td class="d-flex">
                                    <a href="{{ route('shipments-rules.status', $rule->id) }}" class=" btn btn-info btn-sm mr-2 px-2" data-toggle="tooltip" data-original-title="Cambiar Estado"><i class="fas fa-sync"></i></a>
                                    <form method="POST" action="{{ route('shipments-rules.destroy', $rule->id) }}" style="display: inline-block;">
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

        <div class="card card-body mb-4">
            <h4>Pasarelas de Envío</h4>
            <p class="mb-4"><strong>(Solo puedes tener activado uno a la vez)</strong></p>

            <div class="row payment-methods">
                <div class="col-md-6">
                    <div class="card card-body h-100">
                        @if($ups_method->is_active ?? '' == false)
                        <span class="badge badge-danger">Desactivado</span>
                        @else
                        <span class="badge badge-success">Activado</span>
                        @endif
                        <img src="{{ asset('assets/img/brands/ups.png') }}" width="120" style="margin: 10px 0px;">

            
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateUPS" class="btn btn-outline-secondary btn-sm">Configurar UPS</a>
                        <a href="https://www.ups.com/mx/es/Home.page" target="_blank" class="btn btn-link btn-sm">Visita el sitio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCreateUPS" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Conectar con UPS</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <input type="hidden" name="type" value="auto">
                <input type="hidden" name="supplier" value="UPS">

                <div class="modal-body pd-25">
                    <img src="{{ asset('assets/img/brands/ups.png') }}" width="250" style="margin: 10px 0px;">

                    <div class="form-group mt-2">
                        <label>Llave Privada</label>
                        <input type="text" class="form-control" name="private_key" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Llave Pública</label>
                        <input type="text" class="form-control" name="public_key" />
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de esta pasarela se activará automáticamente. Si tienes otro método de envío se desactivará.</p>
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

<div id="modalCreateRule" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear nueva Regla</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('shipments-rules.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

                <div class="modal-body pd-25">
                    <div class="d-flex">
                        <div class="form-group mr-1">
                            <label>Tipo</label>
                            <input type="text" class="form-control" name="type" value="Envío Gratis" readonly="" />
                        </div>

                        <div class="form-group mr-1">
                            <label>Condición</label>
                            <select class="custom-select" name="condition">
                                <option value="Cantidad Comprada" selected="">Cantidad Comprada</option>
                                <option value="Productos en carrito">Productos en carrito</option>
                            </select>
                        </div>

                        <div class="form-group mr-1">
                            <label>Operador</label>
                            <select class="custom-select" name="comparison_operator">
                                <option value="==" selected="">Igual</option>
                                <option value="!=">No Igual</option>
                                <option value="<">Menor que</option>
                                <option value="<=">Menor que o igual</option>
                                <option value=">">Mayor que</option>
                                <option value=">=">Mayor que o igual</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control" name="value" required="" />
                            <small>Sin signos especiales ni comas.</small>
                        </div>
                    </div>
                    
                    <div class="custom-control custom-checkbox mb-3" style="opacity:.3;">
                        <input type="checkbox" class="custom-control-input" id="allow_coupons" name="allow_coupons" value="1">
                        <label class="custom-control-label" for="allow_coupons"> Permitir uso de cupones</label>
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar esta regla de envio se activará automáticamente. Si tienes otra regla creada se desactivará.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection