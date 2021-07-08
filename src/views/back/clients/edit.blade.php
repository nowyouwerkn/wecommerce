@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Editar cliente</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('clients.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Form -->
    <form action="" method="POST">
        <div class="row">
            <!-- Firts Column -->
            <div class="col-md-8">
                <!-- Infomation General -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Datos generales</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Datos generales.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Apellido</label>
                                <input type="text" name="lastname" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telefono</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Address -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Dirección</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Dirección.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country_id">Pais</label>
                                <select class="custom-select tx-13" name="country_id">
                                    <option selected>Selecciona el pais</option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_id">State</label>
                                <select class="custom-select tx-13" name="state_id">
                                    <option selected>Selecciona el estado</option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_id">Ciudad</label>
                                <select class="custom-select tx-13" name="city_id">
                                    <option selected>Selecciona la ciudad</option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" name="address" class="form-control">
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

                        <div class="col-md-12 my-3">
                            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                                Agregar otra dirección
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
@endsection