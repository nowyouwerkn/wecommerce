@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reseñas</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Reseñas</h4>
        </div>
        <div class="d-none d-md-block">

        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card card-body">
            <h4>Esperando Aprobación</h4>
            <hr>
            <table class="table table-hover">
            <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Reseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews_pending as $rp)
                <tr>
                <th scope="row">{{ $rp->id }}</th>
        
                <td>{{ $rp->name }} <br> {{ $rp->email }}</td>
                <td><a href="{{ route('product.detail', $rp->product->slug) }}">{{ $rp->product->name }}</a></td>
                <td>{{ $rp->review }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Acciones">
                    <a href="{{ route('review.approve', $rp->id) }}" class="btn btn-success"><i class="ionicons ion-checkmark"></i> Aprobar</a>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <div class="col">
        <div class="card card-body">
            <h4>Reseñas</h4>
            <hr>
            <table class="table table-hover">
            <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Reseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                <th scope="row">{{ $review->id }}</th>
        
                <td>{{ $review->name }} <br> {{ $review->email }}</td>
                <td><a href="{{ route('product.detail', $review->product->slug) }}">{{ $review->product->name }}</a></td>
                <td>{{ $review->review }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Acciones">
                    <a href="#" class="btn btn-danger"><i class="ionicons ion-checkmark"></i> Borrar</a>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection