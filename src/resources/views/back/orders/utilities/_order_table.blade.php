<table class="table">
    <thead>
        <tr>
            <th>Orden</th>
            <th>ID Pago</th>
            <th>Comprador</th>
            <th>Fecha de Compra</th>
            <th>Cantidad Pagada</th>
            <th>Estatus</th>
            <th>País</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
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
            <td>{{ $order->payment_id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>
                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($order->created_at)->format('d M Y - h:ia') }}</span>
            </td>
            <td><strong>${{ number_format($order->payment_total, 2) }}</strong><i class="far fa-question-circle ml-1" style="font-size:.7em;" data-toggle="tooltip" data-placement="top" title="Esta es la cantidad total pagada por el cliente en la compra."></i> </td>
            <td>
                @if($order->is_completed == true)
                <div class="badge badge-table badge-success"><i class="fas fa-check mr-1"></i> Pagado</div>
                @else
                    @if($order->status == NULL)
                    <div class="badge badge-table badge-warning"><i class="fas fa-exclamation mr-1"></i> Pendiente</div>
                    @else
                    <div class="badge badge-table badge-danger"><i class="fas fa-times mr-1"></i> Expirado/Cancelado</div>
                    @endif
                @endif
            </td>

            <td><i class="fas fa-globe"></i> {{ $order->country }}</td>
        </tr>
        @endforeach
    </tbody>
</table>