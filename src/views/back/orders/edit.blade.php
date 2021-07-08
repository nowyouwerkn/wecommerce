@extends('back.layouts.main')

@section('title')
    Editar orden
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4 text-start">
            <a href="{{ route('orders.index') }}" class="btn btn-primary">Regresar</a>
            <a href="#" class="btn">Exportar</a>
            <a href="#" class="btn">Importar</a>
        </div>

        <!-- Form -->
        <form action="" method="POST">
            <div class="row">
                <!-- Firts Column -->
                <div class="col-md-8">
                    <!-- Data -->
                    <h3>Datos generales</h3>
                    <div class="card p-3 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="client">Cliente</label>
                                <select name="client" class="form-select">
                                    <option value="si">Pagado</option>
                                    <option value="no">Pendiente</option>
                                </select>
                            </div>
        
                            <div class="col-md-12">
                                <label for="date">Fecha</label>
                                <input type="date" name="date" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label for="products">Productos</label>
                                <select name="products" class="form-select">
                                    <option value="si">Pagado</option>
                                    <option value="no">Pendiente</option>
                                </select>
                            </div>
        
                            <div class="col-md-6">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="quantity" class="form-control">
                            </div>
        
                            <div class="col-md-6">
                                <label for="price">Precio</label>
                                <input type="number" name="price"class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="pyment">Pyment</label>
                                <select name="pyment" class="form-select">
                                    <option value="si">Pagado</option>
                                    <option value="no">Pendiente</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="pyment">Estado</label>
                                <select name="pyment" class="form-select">
                                    <option value="si">Completado</option>
                                    <option value="no">Pendiente</option>
                                </select>
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
    </div>
@endsection