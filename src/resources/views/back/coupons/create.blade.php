@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cupones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Crear cupones</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('coupons.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Regresar
            </a>
        </div>
    </div>
@endsection

@section('content')
<form method="POST" action="{{ route('coupons.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8">
            <div class="card card-body mb-4">
                <div class="form-group mt-2">
                    <label>Código de Descuento</label>
                    <input type="text" class="form-control" id="code" name="code" />
                    <small>Los clientes introducirán este código de descuento en la pantalla de pago.</small>
                </div>
            </div>

            <div class="card card-body mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <label>Tipo</label>
                            <select class="form-control" name="type">
                                <option value="percentage_amount">Porcentaje</option>
                                <option value="fixed_amount">Monto Fijo</option>
                                <option value="free_shipping">Envío Gratis</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <label>Valor del descuento</label>
                            <input type="text" class="form-control" id="qty" name="qty" />
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- 
            <div class="card card-body mb-4">
                <h6 class="text-uppercase">Requerimientos mínimos</h6>

                <div class="form-group mt-2">
                    <label>Cantidad minima de artículos</label>
                    <input type="text" class="form-control" name="minimun_requirements_value" value="10" />
                </div>

            </div>
            --}}

            <div class="card card-body mb-4">
                <h6 class="text-uppercase">Restricciones de Uso</h6>
                <div class="form-group mt-2">
                    <label>Uso Individual</label>
                    <select class="form-control" name="individual_use">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                    <small>Este cupón solo podrá ser usado una vez por usuario.</small>
                </div>

                <div class="form-group mt-2">
                    <label>Excluir productos con descuento</label>
                    <select class="form-control" name="exclude_discounted_items">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>

                {{-- 
                <div class="form-group mt-2">
                    <label>Excluir categorías</label>
                    <select class="form-control" multiple="" name="categories[]">
                        @php
                            $categories = App\Models\Category::all();
                        @endphp 
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label>Excluir Productos</label>
                    <select class="form-control" multiple="" name="products[]">
                        @php
                            $products = App\Models\Product::all();
                        @endphp 
                        @foreach($products as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                        @endforeach
                    </select>
                </div>
                --}}
            </div>

            <div class="card card-body mb-4">
                <h3>Límites de Uso</h3>
                <div class="form-group mt-2">
                    <label>Limite por Código</label>
                    <input type="text" class="form-control" name="usage_limit_per_code" value="1" />
                    <small>Limita la cantidad de veces que este cupón puede usarse en todas las compras.</small>
                </div>

                <div class="form-group mt-2">
                    <label>Limitar uso por usuario</label>
                    <input type="text" class="form-control" name="usage_limit_per_user" value="1" />
                    <small>Limita la cantidad de veces que este cupon puede ser usado por usuario.</small>
                </div>
            </div>

            <div class="card card-body mb-4">
                <h3>Período de duración</h3>

                <div class="row">
                    <div class="col">
                        <div class="form-group mt-2">
                            <label>Fecha de Inicio</label>
                            <input type="date" class="form-control" name="start_date" value="" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mt-2">
                            <label>Fecha de Finalización</label>
                            <input type="date" class="form-control" name="end_date" value="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-success btn-block">Guardar cupon</button>
            <a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary btn-block">Descartar</a>
        </div>
    </div>
</form>
@endsection