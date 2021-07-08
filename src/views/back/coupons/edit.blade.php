@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cupones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Editar cupones</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('coupons.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code">Codigo</label>
                                <input type="text" name="code" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <textarea name="description" cols="10" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="in_index">Tipo $ %</label>
                                <select class="custom-select tx-13" name="in_index">
                                    <option selected>Seleccione el tipo</option>
                                    <option value="si">uno</option>
                                    <option value="no">dos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="quantity" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="free_shiping">Envio Gratis</label>
                                <select class="custom-select tx-13" name="in_index">
                                    <option selected>Seleccione el envío</option>
                                    <option value="si">si</option>
                                    <option value="no">no</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="in_index">Mostrar Inicio</label>
                                <select class="custom-select tx-13" name="in_index">
                                    <option selected>Seleccione la opción</option>
                                    <option value="si">si</option>
                                    <option value="no">no</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Fecha de Actividad</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Fecha de Actividad.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-start">Fecha inical</label>
                                <input type="date" name="date-start" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-end">Fecha final</label>
                                <input type="date" name="date-end" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rules -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Reglas</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Reglas.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="individual">Uso individual</label>
                                <select class="custom-select tx-13" name="individual">
                                    <option selected>Seleccione el uso</option>
                                    <option value="si">uno</option>
                                    <option value="no">dos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_id">Excluir productos con descuento</label>
                                <select class="custom-select tx-13" name="discount_id">
                                    <option selected>Seleccione los productos</option>
                                    <option value="si">uno</option>
                                    <option value="no">dos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categories_id">Excluir categorias</label>
                                <select class="custom-select tx-13" name="categories_id" multiple>
                                    <option selected>Seleccione las categorias</option>
                                    <option value="1">uno</option>
                                    <option value="2">dos</option>
                                    <option value="1">tres</option>
                                    <option value="2">cuatro</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="products_id">Excluir productos</label>
                                <select class="custom-select tx-13" name="products_id" multiple>
                                    <option selected>Seleccione los productos</option>
                                    <option value="1">uno</option>
                                    <option value="2">dos</option>
                                    <option value="1">tres</option>
                                    <option value="2">cuatro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second -->
            <div class="col-md-4">
                <!-- Limit -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Limites</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Limites.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="limit">Limite de uso</label>
                                <input type="text" name="limit" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="limit_user">Limite de usuario</label>
                                <input type="text" name="limit_user" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="limit_categories">Excluir categorias</label>
                                <input type="text" name="limit_categories" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type discount -->
                <div class="card mg-t-10 mb-4">
                    <!-- Header -->
                    <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                        <h5 class="mg-b-5">Tipo de descuento</h5>
                        <p class="tx-12 tx-color-03 mg-b-0">Tipo de descuento.</p>
                    </div>

                    <!-- Form -->
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type_id">Tipo de descuento</label>
                                <select class="custom-select tx-13" name="type_id">
                                    <option selected>Seleccione el tipo</option>
                                    <option value="si">uno</option>
                                    <option value="no">dos</option>
                                </select>
                            </div>
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