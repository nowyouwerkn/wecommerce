<table class="table table-dashboard table-responsive">
    <thead>
        <tr>
            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Orden</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'id'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'id'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>Tipo</th>
            <th>ID Pago</th>
            <th style="width: 80px;">
               <div class="d-flex align-items-center">
                    <span class="table-title">Método</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'payment_method'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'payment_method'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Comprador</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'client_name'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'client_name'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
            <th style="min-width: 200px;">
                <div class="d-flex align-items-center">
                    <span class="table-title">Fecha de compra</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'created_at'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'created_at'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th style="min-width: 100px;">
                <div class="d-flex align-items-center">
                    <span class="table-title">Total</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'payment_total'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'payment_total'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Estatus</span>
                        <a class="filter-btn" href="{{route('filter.orders', ['asc', 'status'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.orders', ['desc', 'status'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th class="text-center">-</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr>
            <td class="type-td" style="width:80px;">
                <a href="{{ route('orders.show', $order->id) }}">
                    <i class="fas fa-shopping-bag"></i>
                    @if(strlen($order->id) == 1)
                    #00{{ $order->id }}
                    @endif
                    @if(strlen($order->id) == 2)
                    #0{{ $order->id }}
                    @endif
                    @if(strlen($order->id) > 2)
                    #{{ $order->id }}
                    @endif
                </a>
            </td>
            <td>
                @switch($order->type)
                    @case('recurring_payment')
                    <div class="d-flex align-items-center">
                        @if($order->subscription_status == true)
                        <i class="fas fa-circle text-success mr-2"></i>
                        @else
                        <i class="fas fa-circle text-danger mr-2"></i>
                        @endif
                        Suscripción
                    </div>
                    
                    @break

                    @default
                    Pago único
                @endswitch
            </td>
            <td class="type-td" style="width:100px;">
                @if(strlen($order->payment_id) > 15)
                {{$str = substr($order->payment_id, 0, 10) . '...';  }}
                @else
                {{ $order->payment_id }}
                @endif
            </td>

            <td class="text-muted">
                <span style="display:block; width:100px;" data-toggle="tooltip" data-placement="bottom" title="ID de Pago: {{ $order->payment_id }}">
                	@if($order->payment_method == 'Paypal')
                		<i class="fab fa-paypal"></i>
                	@else
                		<i class="fas fa-credit-card"></i>
                	@endif

                	{{ $order->payment_method }}
                </span>
            </td>

            <td>
                @if($order->user == NULL)
                    <span class="badge badge-warning"><i class="fas fa-user-alt-slash"></i> Eliminado por Administración</span>
                @else
                    {{ $order->user->name ?? ''}}
                @endif
            </td>

            <td>
                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y - h:ia') }}</span>
            </td>

            <td><strong>${{ number_format($order->payment_total, 2) }}</strong><i class="far fa-question-circle ml-1" style="font-size:.7em;" data-toggle="tooltip" data-placement="top" title="Esta es la cantidad total pagada por el cliente en la compra."></i> </td>

            <td>
                @if($order->type != 'recurring_payment')
                <div id="orderStatus_{{ $order->id }}" class="dropdown order-status">

                    <button class="badge badge-table btn btn-{{ Str::slug($order->status) }} dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="load-step">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="spinner-text">Actualizando...</span>
                        </div>
                    
                        <div class="order-info">
                            @switch($order->status)
                                @case('Pago Pendiente')
                                    <i class="fas fa-exclamation mr-1"></i> 
                                    @break

                                @case('Pagado')
                                    <i class="fas fa-check mr-1"></i> 
                                    @break

                                @case('Empaquetado')
                                    <i class="fas fa-box mr-1"></i>
                                    @break

                                @case('Enviado')
                                    <i class="fas fa-truck mr-1"></i> 
                                    @break

                                @case('Entregado')
                                    <i class="fas fa-dolly mr-1"></i>
                                    @break

                                @case('Cancelado')
                                    <i class="fas fa-times mr-1"></i> 
                                    @break

                                @case('Expirado')
                                    <i class="fas fa-times mr-1"></i> 
                                    @break

                                @case('Sin Completar')
                                    <i class="fas fa-user-clock"></i>
                                    @break

                                @default
                                    <i class="fas fa-check mr-1"></i> 

                            @endswitch
                            
                            <span>{{ $order->status ?? 'Pagado'}}</span>
                        </div> 
                    </button>

                    <div class="dropdown-menu">
                        @if($order->status == 'Cancelado' || $order->status == 'Expirado' || $order->status == 'Sin Completar')
                            <p class="mb-0 mt-2 pl-3"><i class="fas fa-times"></i></span> Orden {{ $order->status }}</p>
                        @else
                            <h6 class="dropdown-header tx-uppercase tx-12 tx-bold tx-inverse">Cambiar Estatus</h6>
                            <a class="
                            dropdown-item
                            @if ($order->status == 'Pagado' || $order->status == 'Empaquetado' || $order->status == 'Enviado' || $order->status == 'Entregado')
                            disabled
                            @endif
                            " href="" data-value="Pagado">
                            <span class="step-style">
                                @if ($order->status == 'Pagado' || $order->status == 'Empaquetado' || $order->status == 'Enviado' || $order->status == 'Entregado')    
                                <i class="fas fa-check"></i></span>
                                @else
                                1
                                @endif
                            </span> 
                            Pagado
                            </a>
                            
                            <a class="
                            dropdown-item
                            @if ($order->status == 'Empaquetado' || $order->status == 'Enviado' || $order->status == 'Entregado')
                            disabled
                            @endif
                            " href="" data-value="Empaquetado">
                            <span class="step-style">
                                @if ($order->status == 'Empaquetado' || $order->status == 'Enviado' || $order->status == 'Entregado')    
                                <i class="fas fa-check"></i></span>
                                @else
                                2
                                @endif
                            </span> 
                            Empaquetado
                            </a>
                            
                            @if($order->shipping_option == NULL or $order->shipment == NULL)
                                <a class="
                                dropdown-item
                                @if ($order->status == 'Enviado' || $order->status == 'Entregado')
                                disabled
                                @endif
                                " href="" data-value="Enviado">
                                <span class="step-style">
                                    @if ($order->status == 'Enviado' || $order->status == 'Entregado')    
                                    <i class="fas fa-check"></i></span>
                                    @else
                                    3
                                    @endif
                                </span> 
                                Enviado
                                </a>
                            @else
                                @if($order->shipment->type == 'delivery')
                                    <a class="
                                    dropdown-item
                                    @if ($order->status == 'Enviado' || $order->status == 'Entregado')
                                    disabled
                                    @endif
                                    " href="" data-value="Enviado">
                                    <span class="step-style">
                                        @if ($order->status == 'Enviado' || $order->status == 'Entregado')    
                                        <i class="fas fa-check"></i></span>
                                        @else
                                        3
                                        @endif
                                    </span> 
                                    Enviado
                                    </a>
                                @endif
                            @endif

                            <a class="
                            dropdown-item
                            @if ($order->status == 'Entregado')
                            disabled
                            @endif
                            " href="" data-value="Entregado">
                            <span class="step-style last-step">
                                @if ($order->status == 'Entregado')    
                                <i class="fas fa-check"></i></span>
                                @else
                                4
                                @endif
                            </span> 
                            Entregado
                            </a>

                            @if ($order->status != 'Entregado')
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" data-value="Cancelado"><span class="step-style"><i class="fas fa-times"></i></span> Cancelar Orden</a>
                            @endif
                        @endif
                    </div>
                </div>
                
                @push('scripts')
                    <script type="text/javascript">
                        $('#orderStatus_{{ $order->id }} .dropdown-item').on('click', function(){
                            event.preventDefault();
                            console.log('Seleccionado:' , $(this).attr('data-value'));
                            $('#orderStatus_{{ $order->id }} .load-step').fadeIn();
                            $('#orderStatus_{{ $order->id }} .order-info').hide();

                            $.ajax({
                                method: 'POST',
                                url: "{{ route('order.status', $order->id) }}",
                                data:{
                                    value: $(this).attr('data-value'),
                                    _method: "PUT",
                                    _token: "{{ Session::token() }}", 
                                },
                                success: function(msg){
                                    console.log(msg['mensaje']);

                                    var status = msg['status'].toLowerCase();

                                    $('#orderStatus_{{ $order->id }} .order-info span').text(msg['status']);
                                    $('#orderStatus_{{ $order->id }} .btn').addClass('btn-' + status);


                                    switch(status) {
                                        case 'pendiente':
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-exclamation mr-1"></i>');
                                            break;
                                        case 'pagado':
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-check mr-1"></i>');
                                            break;
                                        case 'empaquetado':
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-box mr-1"></i>');
                                            break;
                                        case 'enviado':
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-truck mr-1"></i>');
                                            break;
                                        case 'entregado':
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-dolly mr-1"></i>');
                                            break;
                                        default:
                                            $('#orderStatus_{{ $order->id }} .order-info i').replaceWith('<i class="fas fa-times mr-1"></i>');
                                    } 

                                    setTimeout(function () {
                                        $('#orderStatus_{{ $order->id }} .order-info').fadeIn();
                                        $('#orderStatus_{{ $order->id }} .load-step').hide();
                                    }, 500);
                                },
                                error: function(msg){
                                    console.log(msg);

                                    setTimeout(function () {
                                        $('#orderStatus_{{ $order->id }} .order-info').fadeIn();
                                        $('#orderStatus_{{ $order->id }} .load-step').hide();
                                    }, 500);         
                                }
                            });
                        });
                    </script>
                @endpush
                @else
                <div class="badge badge-table btn btn-{{ Str::slug($order->status) }}" style="font-size: 10px;">                
                    <div class="order-info">
                        @switch($order->status)
                            @case('Pago Pendiente')
                                <i class="fas fa-exclamation mr-1"></i> 
                                @break

                            @case('Pagado')
                                <i class="fas fa-check mr-1"></i> 
                                @break

                            @case('Cancelado')
                                <i class="fas fa-times mr-1"></i> 
                                @break

                            @case('Expirado')
                                <i class="fas fa-times mr-1"></i> 
                                @break

                            @case('Sin Completar')
                                <i class="fas fa-user-clock"></i>
                                @break

                            @default
                                <i class="fas fa-check mr-1"></i> 

                        @endswitch
                        
                        <span>{{ $order->status ?? 'Pagado'}}</span>
                    </div> 
                </div>
                @endif
            </td>

            <td>
                @if ($order->status == 'Empaquetado' || $order->status == 'Enviado' || $order->status == 'Entregado')    
                <a data-toggle="tooltip" data-placement="top" title="Imprimir lista de empaque" href="{{ route('order.packing.list', $order->id) }}">
                    <i class="fas fa-print"></i>
                </a>
                @else
                <div style="opacity:.4;">
                    <i class="fas fa-print"></i>
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>