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
    <div class="col-12">
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
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews_pending as $rp)
                <tr>
                <th scope="row">{{ $rp->id }}</th>
        
                <td>{{ $rp->name }} <br> {{ $rp->email }}</td>
                <td><a href="">{{ $rp->product->name }}</a></td>
                <td>{{ $rp->review }}</td>
                <td>
                    <div class="d-flex">
                         @if($rp->rating == 0)
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                        @endif
                        @if($rp->rating == 1)
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                        @endif
                        @if($rp->rating == 2)
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                        @endif
                        @if($rp->rating == 3)
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                        @endif
                        @if($rp->rating == 4)
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star-outline"></ion-icon>
                        @endif
                        @if($rp->rating == 5)
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                            <ion-icon name="star"></ion-icon>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Acciones">
                        <a href="{{ route('review.approve', $rp->id) }}" class="btn btn-sm pd-x-15 btn-outline-success btn-uppercase mg-l-5"><i class="fas fa-check-circle"></i> Aprobar</a>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <div class="col-12" style="margin-top: 1rem;">
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
                    <th>Calificacion</th>
                    <th>Acciones</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <th scope="row">{{ $review->id }}</th>
            
                    <td>{{ $review->name }} <br> {{ $review->email }}</td>
                    <td><a href="">{{ $review->product->name }}</a></td>
                    <td>{{ $review->review }}</td>
                    <td>
                        @if($review->rating == 0)
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        @endif
                          @if($review->rating == 1)
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        @endif
                          @if($review->rating == 2)
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        @endif
                          @if($review->rating == 3)
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        @endif
                          @if($review->rating == 4)
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-outline"></ion-icon>
                        @endif
                          @if($review->rating == 5)
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-sm pd-x-15 btn-outline-danger btn-uppercase mg-l-5">
                                Eliminar <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
