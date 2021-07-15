@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Clientes</h4>
        </div>
        <div class="d-none d-md-block">
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                Exportar
            </a>
            <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
                Importar
            </a>
            <a href="{{ route('clients.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
                Agregar Cliente
            </a>
        </div>
    </div>
@endsection

@section('content')
@if($clients->count() == 0)
<div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
    <img src="{{ asset('assets/img/group_3.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
    <h4>Administra y conoce a tus clientes</h4>
    <p class="mb-4">En esta sección puedes administrar la información de tus clientes y ver su historial de compra.</p>

    <div class="d-flex align-items-center wd-300 justify-content-center ml-auto mr-auto">
        <a href="{{ route('clients.create') }}" data-toggle="modal" data-target="#modalCreate" class="btn btn-sm btn-primary btn-uppercase">Agregar Cliente</a>
        <a href="#" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
            Importar
        </a>
    </div>    
</div>
@else
    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
                <div class="card-body pd-y-30">
                    <!-- Filters -->
                    <div class="mb-4">

                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha Registro</th>
                                <th>Email</th>
                                <th>Wishlist</th>
                                <th>Órdenes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></td>
                                <td>
                                    <span class="text-muted"><i class="iconsminds-timer"></i> {{ Carbon\Carbon::parse($client->created_at)->format('d M Y, H:i') }}</span>
                                </td>
                                <td>{{ $client->email }}</td>
                                <td>
                                    @php
                                        $wishlist = Nowyouwerkn\WeCommerce\Models\Wishlist::where('user_id', $client->id)->get();
                                    @endphp

                                    @if($wishlist->count() == NULL)
                                        <span class="badge badge-info">Sin Wishlist</span>
                                    @else
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-light dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ver Wishlist <i class="mdi mdi-chevron-down"></i>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start">
                                            @foreach($client->wishlists as $ws)
                                                <p class="dropdown-item">{{ $ws->product->name ?? '' }}</p>
                                            @endforeach 
                                        </div>
                                    </div>
                                    @endif 
                                </td>
                                <td>{{ $client->orders->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif  
@endsection