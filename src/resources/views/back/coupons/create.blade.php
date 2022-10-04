@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

<style type="text/css">
    .hidden{
        display: none;
    }
</style>
@endpush

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
                <i class="fas fa-undo mr-1"></i> Regresar al listado
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
                    <label>Código de Descuento <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code" required="" />
                    <small>Los clientes introducirán este código de descuento en la pantalla de pago.</small>
                </div>

                <div class="form-group mt-2">
                    <label>Descripción <span class="text-info">(Opcional)</span></label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </div>

            <div class="card card-body mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <label>Tipo <span class="text-danger">*</span></label>
                            <select class="form-control" name="type" id="typeCheck" required="">
                                <option value="NULL" selected="" disabled="">Selecciona una opción</option>
                                <option value="percentage_amount">Porcentaje</option>
                                <option value="fixed_amount">Monto Fijo</option>
                                <option value="free_shipping" data-name="free_shipping">Envío Gratis</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2" id="qtyForm" style="display:none;">
                            <label>Valor del descuento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="qty" value="0" name="qty" required="" />
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- 
            <div class="card card-body mb-4">
                <h6 class="text-uppercase">Requerimientos mínimos</h6>

                <div class="form-group mt-2">
                    <label>Cantidad minima de artículos</label>
                    <input type="text" class="form-control" name="minimun_requirements_value" id="minimun_requirements_value" value="10" />
                </div>

            </div>
            --}}

            <div class="card card-body mb-4">
                <h6 class="text-uppercase">Restricciones de Uso</h6>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="individual_use" name="individual_use" value="1">
                                <label class="custom-control-label" for="individual_use">Uso Individual</label>
                            </div>
                            <small>Este cupón solo podrá ser usado una vez por usuario.</small>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <label>Limite por Código</label>
                            <input type="text" class="form-control" name="usage_limit_per_code" id="usage_limit_per_code" value="1" />
                            <small>Limita la cantidad de veces que este cupón puede usarse en todas las compras.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <label>Limitar uso por usuario</label>
                            <input type="text" class="form-control" name="usage_limit_per_user"  id="usage_limit_per_user" value="1" required="" />
                            <small>Limita la cantidad de veces que este cupón puede ser usado por usuario.</small>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="exclude_discounted_items" name="exclude_discounted_items" value="1">
                                <label class="custom-control-label" for="exclude_discounted_items">Excluir productos con descuento</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group mt-2">
                    <label>Excluir categorías</label>
                    <select class="form-control select2" multiple="" name="excluded_categories[]">
                        @php
                            $categories = Nowyouwerkn\WeCommerce\Models\Category::all();
                        @endphp 
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->slug }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label>Excluir Productos</label>
                    <select class="form-control select2" multiple="" name="excluded_products[]">
                        @php
                            $products = Nowyouwerkn\WeCommerce\Models\Product::all();
                        @endphp 
                        @foreach($products as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card card-body mb-4">
                <h3>Periodo de duración</h3>

                <div class="row">
                    <div class="col">
                        <div class="form-group mt-2">
                            <label>Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" value="" required="" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mt-2">
                            <label>Fecha de Finalización <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" value="" required="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-sm btn-block pd-x-15 btn-success btn-uppercase"><i class="far fa-save"></i> Guardar cupón</button>
            <!--<a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary btn-block">Descartar</a>-->
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
 <script src="{{ asset('lib/cleave.js/cleave.min.js') }}"></script>
    <script type="text/javascript">
        var cleaveA = new Cleave('#qty', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });

        var cleaveC = new Cleave('#usage_limit_per_code', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });

        var cleaveD = new Cleave('#usage_limit_per_user', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });

        
           
    </script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Selecciona una opción..."
        });
    });

    $('#typeCheck').on('change', function(){
        event.preventDefault();

        var value = $('#typeCheck option:selected').attr('data-name');
        
        $('#qtyForm').show();
        $('#qtyForm .form-control').attr('required', true);

        if(value == 'free_shipping'){
            $('#qtyForm').hide();
            $('#qtyForm .form-control').attr('required', false);
        }
    });
</script>
@endpush