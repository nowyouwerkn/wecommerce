@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ordenes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Ordenes</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('orders.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
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
                                <label for="client">Cliente</label>
                                <select class="custom-select tx-13" name="client">
                                    <option selected>Selecciona un Cliente</option>
                                    <option value="uno">Uno </option>
                                    <option value="dos">Dos</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Fecha</label>
                                <input type="date" name="date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="products">Productos</label>
                                <select class="custom-select tx-13" name="products" multiple>
                                    <option selected>Selecciona los productos</option>
                                    <option value="uno">Uno </option>
                                    <option value="dos">Dos</option>
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
                                <label for="price">Precio</label>
                                <input type="number" name="price"class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pyment">Pyment</label>
                                <select class="custom-select tx-13" name="pyment">
                                    <option selected>Selecciona el metodo de pago</option>
                                    <option value="uno">Uno </option>
                                    <option value="dos">Dos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Estado</label>
                                <select class="custom-select tx-13" name="status">
                                    <option selected>Selecciona un Cliente</option>
                                    <option value="uno">Uno </option>
                                    <option value="dos">Dos</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary text-center">
                                Agregar producto
                            </button>
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