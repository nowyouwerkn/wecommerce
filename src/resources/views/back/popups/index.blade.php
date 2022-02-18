@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pop-ups</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Pop-ups</h4>
        </div>
        @if(auth()->user()->can('admin_access'))
        <div class="d-none d-md-block">
            <a href="{{ route('popups.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                <i data-feather="plus"></i> Crear nuevo Pop-up
            </a>
        </div>
        @endif
    </div>
@endsection

@section('content')

@if($popups->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_7.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>¡No hay popups guardadas en la base de datos!</h4>
    <p class="mb-4">Empieza a cargar popups en tu plataforma usando el botón superior.</p>
    <a href="{{ route('popups.create') }}" class="btn btn-sm btn-primary btn-uppercase wd-200 ml-auto mr-auto"><i data-feather="plus"></i> Crear nuevo Pop-up</a>
</div>
@else

<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-10">
            <div class="table-responsive">
                <table class="table table-dashboard">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Información</th>
                            <th>Botón</th>
                            <th>Link</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($popups as $banner)
                        <tr>
                            <td style="width: 150px;">
                                <img style="width: 100%;" src="{{ asset('img/popups/' . $banner->image ) }}" alt="{{ $banner->title }}">
                                
                            </td>
                            <td style="width: 250px;">
                                <strong>{{ $banner->title }}</strong><br>
                                {{ $banner->subtitle }}
                            </td>
                            <td>{{ $banner->text_button }}</td>
                            <td>{{ $banner->link }}</td>

                            <td>
                                @if($banner->is_active == true)
                                    <span class="badge badge-success">Activado</span><br>
                                @else
                                    <span class="badge badge-info">Desactivado</span><br>
                                @endif
                            </td>
                            
                            <td class="d-flex">
                                <a href="{{ route('popups.show', $banner->id) }}" class="btn btn-link text-dark px-1 py-0">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </a>

                                <a href="{{ route('popups.edit', $banner->id) }}" class="btn btn-link text-dark px-1 py-0">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>

                                <form method="POST" action="{{ route('popups.status', $banner->id) }}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-link text-dark px-1 py-0">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>

                    
                                <form method="POST" action="{{ route('popups.destroy', $banner->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link text-danger px-1 py-0">
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
        {{ $popups->links() }}
    </div>
</div>
@endif

@endsection