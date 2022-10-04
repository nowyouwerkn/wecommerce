@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: var(--primary);
    }

    input:focus + .slider {
        box-shadow: 0 0 1px var(--primary);
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .card p{
        text-transform: uppercase;
        font-weight: 500
    }

</style>
@endpush

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sistema de Lealtad</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Sistema de Lealtad</h4>
        </div>
    </div>
@endsection

@section('content')

    @if ($config->is_active == 1)
    <label class="switch">
        <input id="switchOff" type="checkbox" checked>
        <span class="slider round"></span>
    </label>

    @else
        <form action="{{ route('mem-status.update', $config->id) }}" id="on" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <label class="switch">
                <input id="turnOn" type="checkbox" value="1" name="is_active">
                <span class="slider round"></span>
            </label>
        </form>
    @endif

<form action="{{ route('membership.update', $config->id) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-10">
            <div class="card mg-t-10 mb-4">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Datos generales</h5>
                    <!--<p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>-->
                </div>

                <!-- Form -->
                <div class="card-body row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <p>Valor</p>
                    </div>
                    <div class="col-md-5">
                        <h4>Monto mínimo para puntos:</h4>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">MX$</span>
                            </div>
                            <input type="number" name="minimum_purchase" class="form-control noText" value="{{ $config->minimum_purchase }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Cada:</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">MX$</span>
                            </div>
                            <input type="number" name="qty_for_points" class="form-control noText" value="{{ $config->qty_for_points }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4>Puntos ganados:</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mg-b-10">
                            <input type="number" name="earned_points" class="form-control noText" value="{{ $config->earned_points }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Valor por punto:</h4>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">MX$</span>
                            </div>
                            <input type="number" name="point_value" class="form-control noText" value="{{ $config->point_value }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Puntos máximos por compra:</h4>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group mg-b-10">
                            <div class="input-group-prepend">
                            </div>
                            <input type="number" name="max_redeem_points" class="form-control noText" value="{{ $config->max_redeem_points }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="card mg-t-10 mb-4">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Caducidad de puntos</h5>
                    <!--<p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>-->
                </div>

                <!-- Form -->
                <div class="card-body row">
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <p>Estado</p>
                    </div>
                    <div class="col-md-4">
                        <p>Tiempo</p>
                    </div>
                    <div class="col-md-5">
                        <h4>Duración de puntos:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch5" value="1" name="has_expiration_time" {{ ($config->has_expiration_time == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch5"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="custom-select tx-13" name="point_expiration_time">
                                @if (!empty($config->point_expiration_time))
                                <option selected value="{{ $config->point_expiration_time }}">{{ $config->point_expiration_time. ' '.'meses' ?? 'Elegir duración' }}</option>
                                @else
                                <option selected disabled>Elegir duración</option>
                                @endif
                                <option value="1">1 mes</option>
                                <option value="2">2 meses</option>
                                <option value="4">4 meses</option>
                                <option value="6">6 meses</option>
                                <option value="8">8 meses</option>
                                <option value="10">10 meses</option>
                                <option value="12">12 meses</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-5 d-none">
                        <h4>Fecha de corte:</h4>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="has_cutoff" {{ ($config->has_cutoff == '1') ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-md-4 d-none">
                        <div class="form-group">
                            <input type="date" name="cutoff_date" class="form-control" value="{{ $config->cutoff_date }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="card mg-t-10 mb-4">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Tipos de clientes</h5>
                    <!--<p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>-->
                </div>

                <!-- Form -->
                <div class="card-body row">
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <p>Estado</p>
                    </div>
                    <div class="col-md-4">
                        <p>Valor</p>
                    </div>
                    <div class="col-md-5">
                        <h4>Clientes V.I.P:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="clientVIP" type="checkbox" value="1" name="vip_clients" {{ ($config->vip_clients == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="clientVIP"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-5">
                        <h4>Puntos para ser V.I.P:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="pointsVIPc" value="1" name="has_vip_minimum_points" {{ ($config->has_vip_minimum_points == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="pointsVIPc"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" id="pointsVIPi" name="vip_minimum_points" class="form-control noText" value="{{ $config->vip_minimum_points }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Compras para mantener nivel V.I.P:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="ordersVIPc" value="1" name="has_vip_minimum_orders" {{ ($config->has_vip_minimum_orders == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="ordersVIPc"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" id="ordersVIPi" name="vip_minimum_orders" class="form-control noText" value="{{ $config->vip_minimum_orders }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Puntos por compra para cliente V.I.P:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="puntosVIPc" value="1" name="on_vip_account" {{ ($config->on_vip_account == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="puntosVIPc"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="points_vip_accounts" id="puntosVIPi" class="form-control noText" value="{{ $config->points_vip_accounts }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="card mg-t-10 mb-4">
                <!-- Header -->
                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                    <h5 class="mg-b-5">Tipos de adquisición de puntos</h5>
                    <!--<p class="tx-12 tx-color-03 mg-b-0">Archivos multimedia.</p>-->
                </div>

                <!-- Form -->
                <div class="card-body row">
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <p>Estado</p>
                    </div>
                    <div class="col-md-4">
                        <p>Puntos</p>
                    </div>
                    <div class="col-md-5">
                        <h4>Crear Cuenta:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" value="1" name="on_account_creation" {{ ($config->on_account_creation == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch1"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="points_account_created" class="form-control noText" value="{{ $config->points_account_created }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Cumpleaños:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch10" value="1" name="on_birthday" {{ ($config->on_birthday == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch10"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="points_birthdays" class="form-control noText" value="{{ $config->points_birthdays }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>Por reseñas:</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch3" value="1" name="on_review" {{ ($config->on_review == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch3"></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="points_review" class="form-control noText" value="{{ $config->points_review }}">
                        </div>
                    </div>
                    <div class="col-md-5 d-none">
                        <h4>Por reseña con imagen:</h4>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4" value="1" name="on_review_with_image" {{ ($config->on_review_with_image == '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitch4"></label>
                        </div>
                    </div>
                    <div class="col-md-4 d-none">
                        <div class="form-group">
                            <input type="number" name="points_review_with_image" class="form-control noText" value="{{ $config->points_review_with_image }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="text" value="{{ $config->is_active }}" hidden name="is_active">
    <button type="submit" class="btn btn-primary">Actualizar</button>

</form>

<div class="modal fade" id="cancelMem" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">¿Estas seguro/a que quieres desactivar tu sistema de lealtad?</h6>
                    <p>Al momento de desactivar el sistema de lealtad se eliminarán todos los puntos de tus clientes y no se podrán recuperar, y se deshabilitará las vista de puntos.</p>
                </div>
                <form action="{{ route('mem-status.update', $config->id) }}" id="off" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="text" value="0" name="is_active" hidden>
                <div class="modal-footer">
                    <button type="button" id="notCancel" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">Aceptar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        if ({{ $config->is_active == false }}) {
            $(".card input").attr("disabled", true);
            $("select").attr("disabled", true);
            $(".card").css("opacity", 0.5);
            $("#turnOn").attr("disabled", false);
            $("#status").attr("disabled", false);
        }
    </script>
    <script>
        $("#turnOn").on('click', function(){
            $("#on").submit();
        });

        $("#turnOff").on('click', function(){
            $("#off").submit();
        });
    </script>
    <script>
        $("#switchOff").on('click', function(){
            $("#cancelMem").modal("toggle");
            $(this).prop("checked", true);
        });
    </script>

    <script>
        $('.noText').on('change keyup', function() {
            var sanitized = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitized);
        });
    </script>

     <script>
      $(document).ready(function() {

          $('#clientVIP').click(function() {
              if($(this).prop("checked") == true) {
                $("#pointsVIPc").attr("disabled", false);
                $("#pointsVIPi").attr("disabled", false);
                $("#ordersVIPc").attr("disabled", false);
                $("#ordersVIPi").attr("disabled", false);
                $("#puntosVIPc").attr("disabled", false);
                $("#puntosVIPi").attr("disabled", false);
              }
              else if($(this).prop("checked") == false) {
                $("#pointsVIPc").attr("disabled", true).prop("checked", false);
                $("#pointsVIPi").attr("disabled", true).val(null);
                $("#ordersVIPc").attr("disabled", true).prop("checked", false);
                $("#ordersVIPi").attr("disabled", true).val(null);
                $("#puntosVIPc").attr("disabled", true).prop("checked", false);
                $("#puntosVIPi").attr("disabled", true).val(null);
              }
            });

            $('#pointsVIPc').click(function(){
                if($(this).prop("checked") == true) {
                    $("#ordersVIPc").attr("disabled", true).prop("checked", false);
                    $("#ordersVIPi").attr("disabled", true).val(null);
                }
                else if($(this).prop("checked") == false) {
                    $("#ordersVIPc").attr("disabled", false);
                    $("#ordersVIPi").attr("disabled", false);
                }
            })

            $('#ordersVIPc').click(function(){
                if($(this).prop("checked") == true) {
                    $("#pointsVIPc").attr("disabled", true).prop("checked", false);
                    $("#pointsVIPi").attr("disabled", true).val(null);
                }
                else if($(this).prop("checked") == false) {
                    $("#pointsVIPc").attr("disabled", false);
                    $("#pointsVIPi").attr("disabled", false);
                }
            })
        });
    </script>

    @if ($config->vip_clients == false)
        <script>
            $(document).ready(function () {
                $("#pointsVIPc").attr("disabled", true).prop("checked", false);
                $("#pointsVIPi").attr("disabled", true).val(null);
                $("#ordersVIPc").attr("disabled", true).prop("checked", false);
                $("#ordersVIPi").attr("disabled", true).val(null);
                $("#puntosVIPc").attr("disabled", true).prop("checked", false);
                $("#puntosVIPi").attr("disabled", true).val(null);
            });
        </script>
    @endif

@endpush

