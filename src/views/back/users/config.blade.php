@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Configuración</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configuración</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Configuración General</h4>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form action="" method="POST">
        <div class="row">
            <!-- Firts Column -->
            <div class="col-md-8">
                <!-- Entrega Local -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Entrega Local</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Entrega Local.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre de la tienda</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry">Industria</label>
                                <select class="custom-select tx-13" name="industry">
                                    <option selected>Selecciona el giro</option>
                                    <option value="si">Inactico</option>
                                    <option value="no">Activo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                                Agregar Información
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Retiro en tienda -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Dirección de tienda</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">direccion de Tienda.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Pais</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state">Estado</label>
                                <input type="text" name="state" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Ciudad</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="street">Dirección</label>
                                <input type="text" name="street" class="form-control">
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num">Num.</label>
                                <input type="number" name="num" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code">Codigo Postal</label>
                                <input type="number" name="code" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                                Agregar dirección
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Paquete -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Estandares</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Estandares.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="industry">Zona horaria</label>
                                <select class="custom-select tx-13" name="industry">
                                    <option selected>Selecciona la zona</option>
                                    <option value="si">Inactico</option>
                                    <option value="no">Activo</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry">Sistema de unidades</label>
                                <select class="custom-select tx-13" name="industry">
                                    <option selected>Selecciona la unidad</option>
                                    <option value="si">Inactico</option>
                                    <option value="no">Activo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry">Unidad de peso</label>
                                <select class="custom-select tx-13" name="industry">
                                    <option selected>Selecciona el peso</option>
                                    <option value="si">Inactico</option>
                                    <option value="no">Activo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                                Agregar paquetes
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
@endsection