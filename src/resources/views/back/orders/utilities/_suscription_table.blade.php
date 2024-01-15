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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>