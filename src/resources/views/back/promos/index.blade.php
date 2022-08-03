@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promociones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Promociones</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('promos.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i class="fas fa-plus"></i> Crear Nueva Promoción
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if($promos->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/group_4.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Administra y crea tus promociones y descuentos.</h4>
        <p class="mb-4">Crea grupos de promociones o aplica un descuento general a tus productos.</p>

        <a href="{{ route('promos.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto"><i class="fas fa-plus"></i> Crear Nueva Promoción</a>
    </div>
    @else
        <div class="row">
            @foreach($promos as $promo)
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body pb-0">
                        @if($promo->is_active == true)
                        <span class="badge badge-success">Activo</span>
                        @else
                        <span class="badge badge-danger">Inactivo</span>
                        @endif

                        <p class="text-uppercase tx-12 d-flex align-items-center mb-1 mt-2"><strong class="text-muted">DESCUENTO</strong></p>
                        @if($promo->discount_type == 'numeric')
                        <h2 class="mb-3 mt-0">${{ $promo->value }}</h2>
                        @endif
                        
                        @if($promo->discount_type == 'percentage')
                        <h2 class="mb-3 mt-0">{{ $promo->value }} %</h2>
                        @endif

                        <p class="text-uppercase tx-12 d-flex align-items-center mb-1"><strong class="text-muted">Activo hasta:</strong></p>
                        <h5><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($promo->end_date)->translatedFormat('d M Y') }}</h5>

                        <p class="text-uppercase tx-12 d-flex align-items-center mb-2 mt-4"><strong class="text-muted">Productos</strong> <span class="badge badge-primary ml-1">{{ $promo->products->count() }}</span></p>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($promo->products as $product)
                        <li class="list-group-item">{{ $product->name }}</li>
                        @endforeach
                    </ul>
                    
                    <div class="card-body">
                        <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-uppercase btn-info"><i class="fas fa-edit"></i> Editar</a>
                        <form method="POST" action="{{ route('promos.destroy', $promo->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-uppercase btn-danger">
                                <i class="fas fa-trash" aria-hidden="true"></i> Eliminar
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        <hr>
                        <p class="card-text mb-0 mt-3"><small class="text-muted">Actualizado por última vez: <br>{{ Carbon\Carbon::parse($promo->updated_at)->translatedFormat('d M Y - h:ia') }}</small></p>
                    </div>
                </div>
            </div>      
            @endforeach
        </div>
    @endif
@endsection