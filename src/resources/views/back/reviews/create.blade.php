@extends('wecommerce::back.layouts.main')

@section('title')
    Crear reviews
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4 text-start">
            <a href="{{ route('reviews.index') }}" class="btn btn-primary">Regresar</a>
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
                                <label for="client_id">Usuario</label>
                                <select class="form-select" name="client_id">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
        
                            <div class="col-md-12">
                                <label for="product_id">Producto</label>
                                <select class="form-select" name="product_id">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="product_id">Aprovación</label>
                                <select class="form-select" name="product_id">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="product_id">Activar</label>
                                <select class="form-select" name="product_id">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                </select>
                            </div>
        
                            <div class="col-md-12">
                                <label for="text">Reseña</label>
                                <input type="text" name="text" class="form-control">
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