<table>
    <thead>
        <tr>
            <th>Orden</th>
            <th>Carrito</th>
            <th>Usuario</th>
            <th>Comprador</th>
            <th>Fecha de Compra</th>
            <th>Cantidad Pagada</th>
            <th>Identificador de Pago</th>
            <th>Método</th>
            <th>Estatus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        @php
        	$order->cart = unserialize($order->cart);
        @endphp
        <tr>
            <td>
                @if(strlen($order->id) == 1)
                #00{{ $order->id }}
                @endif
                @if(strlen($order->id) == 2)
                #0{{ $order->id }}
                @endif
                @if(strlen($order->id) > 2)
                #{{ $order->id }}
                @endif
            </td>
          	<td>
            	@if($order->cart == NULL)
                    Esta orden proviene de una importación de otro sistema. El "módulo carrito" no es compatible con la información y no puede mostrar los detalles.
                @else
                    @foreach($order->cart->items as $item)
                   	{{ $item['item']['name'] }}, Talla: {{ $item['variant'] }} x {{ $item['qty'] }}   
      				<br>
                    @endforeach
                @endif
            </td>
            
            <td>
            	{{ $order->user->name }} <br>
            	{{ $order->user->email }}
            </td>
            <td>{{ $order->client_name }}</td>
            <td>{{ Carbon\Carbon::parse($order->created_at)->format('d M Y - h:ia') }}</td>
            <td>{{ $order->payment_total }}</td>
            <td>{{ $order->payment_id }}</td>
            <td>{{ $order->payment_method }}</td>
            <td>{{ $order->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>