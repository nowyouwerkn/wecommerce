@extends('back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Banners</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Banners</h4>
        </div>
        @if(auth()->user()->can('admin_access'))
        <div class="d-none d-md-block">
            <a href="{{ route('banners.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Crear nuevo Banner
            </a>
        </div>
        @endif
    </div>
@endsection

@section('content')

@if($banners->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_7.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay banners guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar banners en tu plataforma usando el botón superior.</p>
    <a href="{{ route('banners.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto">Crear nuevo banner</a>
</div>
@else

<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Titulo</th>
                            <th>Subtitulo</th>
                            <th>Botón</th>
                            <th>Link</th>
                            <th>Estatus</th>
                            <th>Accciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td style="width: 150px;">
                                <img style="width: 100%;" src="{{ asset('img/banners/' . $banner->image ) }}" alt="{{ $banner->title }}">
                                
                            </td>
                            <td style="width: 250px;">
                                <strong><a href="{{ route('banners.show', $banner->id) }}">{{ $banner->title }}</a></strong> 
                            </td>
                            <td style="width: 80px;">{{ $banner->subtitle }}</td>
                            <td style="width: 80px;">{{ $banner->text_button }}</td>
                            <td style="width: 80px;">{{ $banner->link }}</td>

                            <td>
                                @if($banner->active == true)
                                    <span class="badge badge-success">Activado</span><br>
                                @else
                                    <span class="badge badge-info">DesActivado</span><br>
                                @endif
                            </td>
                            
                            <td class="text-nowrap">
                                <a href="{{ route('banners.show', $banner->id) }}" class="btn btn-sm btn-icon btn-flat btn-default px-2" data-toggle="tooltip" data-original-title="Ver Detalle">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </a>

                                <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-sm btn-icon btn-flat btn-default px-2" data-toggle="tooltip" data-original-title="Editar">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>

                                <form method="POST" action="{{ route('banners.status', $banner->id) }}">
                                    {{ csrf_field() }}

                                    <input type="hidden" value="{{ $banner->id }}" name="id">

                                    <button type="submit" class="btn btn-sm btn-icon btn-flat btn-default px-2" data-toggle="tooltip" data-original-title="Cambiar estado">
                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row justify-items-center">
    <div class="col text-center">
        {{ $banners->links() }}
    </div>
</div>
@endif

@endsection