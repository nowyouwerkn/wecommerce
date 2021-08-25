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
            <a href="{{ route('export.orders') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
        </div>
    </div>
@endsection

@section('content')

@if($orders->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_2.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Aquí aparecerán las compras que hagan tus clientes.</h4>
        <p class="mb-4">Actualmente nadie a comprado, regresa pronto.</p>
    </div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">

                </div>

                <div class="">
                    @include('wecommerce::back.orders.utilities._order_table')
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection