@extends('wecommerce::back.layouts.main')

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/dashforge.css') }}" rel="stylesheet">

<style type="text/css">
    .hidden{
        display: none;
    }

    .select2-container{
        display: block !important;
    }
</style>
@endpush

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promociones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Editar Promoción</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('promos.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>
@endsection

@section('content')
<form method="POST" action="{{ route('promos.update', $promo->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-6">
            <div class="card mg-t-10 mb-4">
                <div class="card-footer">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="is_active">Estado: <span class="text-danger tx-12">*</span></label>
                                <select class="form-control tx-13 select2" name="is_active">
                                    <option value="1" {{ ($promo->is_active == '1') ? 'selected' : '' }}>Activado</option>
                                    <option value="0" {{ ($promo->is_active == '0') ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="end_date">Activar hasta: <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" name="end_date" value="{{ $promo->end_date }}">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-block p-3 btn-success btn-uppercase"><i class="far fa-save mr-2"></i> Actualizar Promoción</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            placeholder: "Selecciona una opción..."
        });

        $('.select-search').select2({
            placeholder: 'Escoge una o varias opciones',
            minimumResultsForSearch: 5,
            searchInputPlaceholder: 'Busca por palabras clave'
        });
    });
</script>

@endpush