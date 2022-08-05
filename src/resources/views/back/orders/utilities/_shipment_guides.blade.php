<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
            <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Guías de Envío</h6>
            <nav class="nav nav-with-icon tx-13">
                <a href="" class="nav-link" data-toggle="modal" data-target="#trackingModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Adjuntar Guía</a>
            </nav>
        </div>

        <div class="card-body">
            @if($order->trackings->count())
                @foreach($order->trackings as $tracking)
                <div class="card card-body tracking-card">
                    @if($tracking->status == 'En proceso')
                    <span class="badge badge-warning">{{ $tracking->status }}</span>
                    @endif
                    @if($tracking->status == 'Completado')
                    <span class="badge badge-success">{{ $tracking->status }}</span>
                    @endif
                    @if($tracking->status == 'Perdido')
                    <span class="badge badge-warning">{{ $tracking->status }}</span>
                    @endif

                    <p class="small-title">Número de Guía</p>
                    <div class="tracking-number">
                        <h4 class="mb-0">{{ $tracking->tracking_number }}</h4>
                    </div>

                    <p><em>{{ $tracking->products_on_order ?? 'No hay nota adjunta a esta guía.'}}</em></p>

                    @if($tracking->is_delivered  == true)
                    <a href="javascript:void(0)" class="btn btn-sm btn-success disabled"><i class="fas fa-check"></i> Entregado</a>
                    @else
                    <a href="{{ route('tracking.complete', $tracking->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-check"></i> Marcar Entregado</a>
                    @endif
                    
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        
                        <form method="POST" action="{{ route('tracking.destroy', $tracking->id) }}" style="display: inline-block; width: 15%;">
                            <button type="submit" class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-original-title="Borrar">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>

                        <a href="" class="btn btn-sm btn-outline-light" style="width:100%; margin-left: 8px;">
                            <i class="fas fa-envelope"></i> Reenviar correo
                        </a>
                    </div> 
                </div>
                @endforeach
            @else
            <div class="text-center my-5">
                <img src="{{ asset('assets/img/new_2.svg') }}" alt="No hay Guía" class="mb-4" width="180">
                <h5 class="mb-0 px-5">Todavía no hay guías adjuntas para esta orden!</h5>
                <p>Adjunta tu primera guía para gestionarla.</p>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
            <h6 class="tx-13 tx-spacing-1 tx-uppercase tx-semibold mg-b-0">Dirección de Envío</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-unstyled">
                        <li><strong>Calle + Núm:</strong> {{ $order->street }} {{ $order->street_num }}</li>
                        <li><strong>Colonia:</strong> {{ $order->suburb }}</li>

                        <li><strong>Código Postal:</strong> {{ $order->postal_code }}</li>
                        <li><strong>Referencias:</strong> {{ $order->references }}</li>
                        <li><hr></li>
                        <li><strong>Ciudad:</strong> {{ $order->city }}</li>
                        <li><strong>Estado:</strong> {{ $order->state }}</li>
                        <li><strong>País:</strong> {{ $order->country }}</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDhjSfxxL1-NdSlgkiDo5KErlb7rXU5Yw4&q={{ str_replace(' ', '-', $order->street . ' ' . $order->street_num) }},{{ $order->city }},{{ $order->state }},{{ $order->country }}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen class="mt-0 dont-print"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>