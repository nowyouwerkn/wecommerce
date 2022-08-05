@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notificaciones</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Notificaciones</h4>
        </div>
    </div>

    <style type="text/css">
        .status-circle{
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 5px;
            border-radius: 100%;
        }
    </style>
@endsection

@section('content')

@if($notifications->count() == 0)
    <div class="card card-body text-center" style="padding:80px 0px 100px 0px;">
        <img src="{{ asset('assets/img/done.svg') }}" class="wd-20p ml-auto mr-auto mb-5">
        <h4>Todavía no hay notificaciones en tu sistema.</h4>
        <p class="mb-4">Las notificaciones aparecerán aqui conforme vayas realizando acciones en tu sistema.</p>
    </div>
@else
    <div class="row">
        <div class="col-lg-6 mg-t-10">
            <div class="card mg-b-10 pt-3">
                    @foreach($notifications as $notification)
                    <div class="media px-3 py-3">
                        @if(!empty($notification->user))
                        <div class="avatar avatar-sm {{-- avatar-online --}}">
                            <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( $notification->user->email ?? 'N/A'))) . '?d=retro&s=150' }}" class="rounded-circle" alt="">
                        </div>
                        @endif
                        <div class="media-body mg-l-15">
                          <p class="mb-1"><strong>{{ $notification->user->name ?? ''}}</strong> {{ $notification->data }}</p>
                          <span class="text-muted">{{ Carbon\Carbon::parse($notification->created_at)->translatedFormat('l d g:ia') }}</span>
                        </div>
                      </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
@endif

@endsection