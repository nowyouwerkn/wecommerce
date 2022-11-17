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
                <li>Configuración Manual</li>
                <li>UPS (Cálculo de Envío Solo Estados Unidos)</li>
            </ul>
        </div>    
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div style="width: 50%">
                        <h6 class="text-uppercase mb-2">Configuración Manual</h6>
                        <p class="mb-0" ">Guarda tu configuración de envíos en tu plataforma. El valor predeterminado es $0.00</p>
                    </div>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateOption" class="btn btn-sm pd-x-15 btn-outline-primary btn-uppercase mg-l-5"><i class="fas fa-plus"></i> Crear nueva opción de envío</a>
                </div>
            </div>

            @if($shipment_options->count() == 0)
                <div class="card-header" style="border-bottom: none;">
                    <div class="d-flex align-items-top justify-content-between">
                        <div style="position: relative; top:-14px;">
                            @if(!empty($manual_method))
                                <span class="badge badge-success">Activado</span>
                            @else
                                <span class="badge badge-primary">Sin Configurar</span>
                            @endif

                            <h4 class="mb-0 mt-2">
                                <i class="fas fa-shipping-fast"></i>
                                Tarifa Regular
                            </h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="manual">
                            <input type="hidden" name="supplier" value="WeCommerce">
                                <div class="d-flex">
                                    <div class="input-group wd-150">
                                        <input type="text" class="form-control" id="manual_method_cost" name="cost" placeholder="0.00" value="{{ $manual_method->cost ?? '' }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                @if($config->currency_id=='2')
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
            @else
                <div class="d-flex align-items-center">
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-center">Imagen</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($shipment_options as $option)
                                <tr>
                                    <td>
                                        @if($option->is_primary == true)
                                        <i data-toggle="tooltip" data-placement="top" title="Principal" class="fas fa-star text-warning mr-2"></i>
                                        @endif
                                        @switch($option->type)
                                            @case('delivery')
                                            Envío a Domicilio
                                            @break

                                            @case('pickup')
                                            Recolección en tienda
                                            @break

                                            @default
                                        @endswitch

                                    </td>
                                    <td class="text-center">
                                        @if($option->icon != NULL)
                                        <img src="{{ asset('img/' . $option->icon) }}" alt="{{ Str::slug($option->name) }}" width="40">
                                        @else
                                        <img src="{{ asset('assets/img/package.png') }}" alt="{{ Str::slug($option->name) }}" width="40">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $option->name }}</strong><br>
                                        <small>{{ $option->location ?? '' }}</small>
                                    </td>
                                    <td>
                                        ${{ number_format($option->price, 2) }}
                                    </td>

                                    <td>
                                        @if($option->is_active == true)
                                        <span class="badge badge-success">Activado</span>
                                        @else
                                        <span class="badge badge-danger">Desactivado</span>
                                        @endif 
                                    </td>
                                
                                    <td class="d-flex justify-content-end">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalEditOption{{$option->id}}" class="btn btn-outline-primary btn-sm mr-2">Editar</a>
                                        <form method="POST" action="{{ route('shipping-options.destroy', $option->id) }}" style="display: inline-block;">
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
                
                </div>
            @endif
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-uppercase mb-0">Reglas Especiales de Envíos</h6>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalCreateRule" class="btn btn-sm pd-x-15 btn-outline-primary btn-uppercase mg-l-5">Crear nueva Regla</a>
                </div>
            </div>

            @if($shipment_rules->count() == 0)
            <div class="text-center">
                <p class="mb-5"><em>Sin reglas especiales en la tienda.</em></p>
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

        <div class="card card-body mb-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width: 50%">
                    <h6 class="text-uppercase mb-2">Pasarelas de Envío</h6>
                    <p class="mb-0">(Solo puedes tener activado uno a la vez)</p>
                </div>
            </div>
        
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

@foreach($shipment_options as $option)
<div id="modalEditOption{{$option->id}}" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Crear opción de envio</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('shipping-options.update',$option->id ) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group mt-2">
                                <label>Descripción <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Envío Estándar" value="{{ $option->name }}" required />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mt-2">
                                <label>Tipo <span class="text-danger">*</span></label>
                                <select id="typeSelect_{{ $option->id }}" class="form-control" name="type" required>
                                    <option {{ ($option->type == 'pickup') ? 'selected' : '' }} value="pickup">Recolección en Tienda</option>
                                    <option {{ ($option->type == 'delivery') ? 'selected' : '' }} value="delivery">Envío a Domicilio</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group mt-2">
                                <label>Tiempo de entrega <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="delivery_time" placeholder="3-5 días hábiles" value="{{ $option->delivery_time }}" required/>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <label class="mt-2">Precio  <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="input-group">
                                    <input type="text" class="form-control" id="manual_method_cost" name="price" value="{{ $option->price }}" placeholder="0.00" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                @if($config->currency_id=='2')
                                                MXN
                                                @else
                                                USD
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Imagen Actual</label>
                            @if($option->icon != NULL)
                            <img src="{{ asset('img/' . $option->icon) }}" alt="{{ Str::slug($option->name) }}" width="40">
                            @else
                            <img src="{{ asset('assets/img/package.png') }}" alt="{{ Str::slug($option->name) }}" width="40">
                            @endif
                        </div>

                        <div class="col-md-9">
                            <div class="form-group mt-2">
                                <label>Modificar Imagen / Ícono <span class="text-info">(Opcional)</span></label>
                                <input type="file" class="form-control" name="icon" />
                                <small class="text-info">Al subir un nuevo archivo se sobreescribirá la información en la base de datos.</small>
                            </div>
                        </div>
                        
                        @if($option->type == 'delivery')
                        <div class="col-md-12" id="locationInfo_{{ $option->id }}" style="display: none;">
                        @else
                        <div class="col-md-12" id="locationInfo_{{ $option->id }}">
                        @endif
                            <div class="form-group mt-2">
                                <label>Dirección <span class="text-info">(Opcional)</span></label>
                                <textarea name="location" class="form-control" rows="4">{{ $option->location ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="is_active_{{ $option->id }}" name="is_active" value="1" {{ ($option->is_active == '1') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active_{{ $option->id }}"> Activado</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" class="custom-control-input" id="is_primary_{{ $option->id }}" name="is_primary" value="1" {{ ($option->is_primary == '1') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_primary_{{ $option->id }}"> Es principal</label>
                            </div>

                            <small class="d-block mb-4">Al seleccionar este como principal se le quitará el estado a cualquier otro elemento que lo tenga.</small>
                        </div>                        
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de esta opción se activará automáticamente. El usuario podra seleccionarla en el proceso de checkout.</p>
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

<div id="modalCreateOption" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Creacion de Opciones de envío</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('shipping-options.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group mt-2">
                                <label>Descripción <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Envío Estándar" required />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mt-2">
                                <label>Tipo <span class="text-danger">*</span></label>
                                <select id="typeSelect" class="form-control" name="type" required>
                                    <option value="pickup">Recolección en Tienda</option>
                                    <option value="delivery" selected>Envío a Domicilio</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group mt-2">
                                <label>Tiempo de entrega <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="delivery_time" placeholder="3-5 días hábiles" required/>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <label class="mt-2">Precio  <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="input-group">
                                    <input type="text" class="form-control" id="manual_method_cost" name="price" placeholder="0.00" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                @if($config->currency_id=='2')
                                                MXN
                                                @else
                                                USD
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label>Imagen / Ícono <span class="text-info">(Opcional)</span></label>
                                <input type="file" class="form-control" name="icon" />
                            </div>
                        </div>

                        <div class="col-md-12" id="locationInfo" style="display: none;">
                            <div class="form-group mt-2">
                                <label>Dirección <span class="text-info">(Opcional)</span></label>
                                <textarea name="location" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active"> Activado</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" class="custom-control-input" id="is_primary" name="is_primary" value="1">
                                <label class="custom-control-label" for="is_primary"> Es principal</label>
                            </div>

                            <small class="d-block mb-4">Al seleccionar este como principal se le quitará el estado a cualquier otro elemento que lo tenga.</small>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <p class="mb-0">Al guardar la información de esta opción se activará automáticamente. El usuario podra seleccionarla en el proceso de checkout.</p>
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
                            <input type="text" id="value" class="form-control" name="value" required="" />
                            <small>Sin signos especiales ni comas.</small>
                        </div>
                    </div>
                    
                    <div class="custom-control custom-checkbox mb-3" >
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

@push('scripts')
@foreach($shipment_options as $option)
<script>
    $('#typeSelect_{{ $option->id }}').on('change', function(e){
        if($(this).val() == 'pickup'){
            $('#locationInfo_{{ $option->id }}').show();
        }else{
            $('#locationInfo_{{ $option->id }}').hide();
        }
    })
</script>
@endforeach

<script>
    $('#typeSelect').on('change', function(e){
        if($(this).val() == 'pickup'){
            $('#locationInfo').show();
        }else{
            $('#locationInfo').hide();
        }
    })
</script>
@endpush