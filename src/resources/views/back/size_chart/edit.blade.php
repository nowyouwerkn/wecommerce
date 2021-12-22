@extends('wecommerce::back.layouts.main')

@php
    $theme = Nowyouwerkn\WeCommerce\Models\Category::where('id', $size_chart->category_id)->first();
@endphp

@push('stylesheets')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

<style type="text/css">
    .save-bar{
        position: fixed;
        width: calc(100% - 240px);
        bottom: -55px;
        left: 240px;
        padding: 10px 40px;
        z-index: 99;

        transition: all .2s ease-in-out;
    }

    .show-bar{
        bottom: 0px;
    }

    .custom-control{
        display: inline-block;
    }

    .hidden{
        display: none;
    }

    .btn-add{
        text-transform: uppercase;
        padding: 15px 0px;
        display: inline-block;
        font-size: .8em;
    }

    .new-aut,
    .new-cat{
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
                <li class="breadcrumb-item active" aria-current="page">Guia de talla</li>
                </ol>
            </nav>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('size_chart.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-undo mr-1"></i> Regresar al listado
            </a>
        </div>
    </div>

@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('size_chart.update', $size_chart->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="form-group mt-2">
                        <label>Nombre de guia de talla</label>
                        <input type="text" class="form-control" id="name" name="name"  value="{{$size_chart->name}}" />
                    </div>

                    <div class="form-group">
                        <label>Vincular con categoria <span class="text-info">(Opcional)</span></label>
                        <select class="form-control" id="category_id" name="category_id" >
                            @if ($size_chart->category_id != NULL)
                            <option  value="{{$size_chart->category_id}}" selected="">{{$theme->name}}</option>
                            @else
                            <option  value="" selected="">Vincula con una categoria</option>
                            @endif
                            @foreach($categories as $cat)
                                @if($cat->parent_id == NULL || 0)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @else
                                
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <label>Valores de la guia de talla</label>
                    <div class="form-group">
                        <form method="POST" action="{{ route('size_guide.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="size_chart_id" value=" {{ $size_chart->id }}">
                                     <input type="text" style="width: 100%; height: 100%;" name="size_value" />
                                </div>
                                <div class="col-6"><button type="submit" class="btn btn-primary">Guardar Información</button></div>
                            </div>
                           
                        </form>
                        @foreach ($size_guide as $size)
                        {{$size}}
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Información</button>
                </div>
            </form>
</div>
@endsection