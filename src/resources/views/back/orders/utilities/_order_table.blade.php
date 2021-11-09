<style type="text/css">
    .order-status .btn{
        font-size: 10px;
        display: flex;
    }

    .order-status .order-info{
 
    }

    .dropdown-toggle::after {
        margin-left: 0.5em;
        margin-top: 4px;
    }

    .order-status .load-step{
        display: none;
    }

    .order-status .step-style {
        width: 15px;
        height: 15px;
        position: relative;
        font-size: 8px;
        text-align: center;
        border: 2px solid black;
        border-radius: 100%;
        display: inline-block;
        position: relative;
        top: -3px;
        margin-right: 5px;
    }

    .order-status  .step-style::after{
        content: "";
        width: 2px;
        height: 21px;
        background-color: black;
        position: absolute;
        top: 11px;
        left: 4.5px;
    }

    .step-style i{
        position: relative;
    }

    .text-danger .step-style{
        border: 2px solid #a71d2a;
    }

    .text-danger .step-style::after,
    .last-step::after{
        display: none !important;
    }

    .disabled .step-style{
        border: 2px solid #7987a1;
    }

    .disabled .step-style::after{
        background-color: #7987a1;
    }

    .order-status .spinner-border-sm{
        width: .7rem;
        height: .7rem;
        border-width: 0.2em;
        margin-right: 4px;
    }

    .order-status .spinner-text{
        position: relative;
        top: 2px;
    }

    .btn-pagado {
        color: #fff;
        background-color: #10b759;
        border-color: #10b759;
    }

    .btn-empaquetado {
        color: #1c273c;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-pendiente,
    .btn-pago-pendiente {
        color: #fff;
        background-color: #fa983a;
        border-color: #fa983a;
    }

    .btn-enviado {
        color: #fff;
        background-color: #00b8d4;
        border-color: #00b8d4;
    }

    .btn-entregado {
        color: #fff;
        background-color: #7987a1;
        border-color: #7987a1;
    }

    .btn-cancelado {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-expirado {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-sin-completar {
        color: #fff;
        background-color: #0a3d62;
        border-color: #0a3d62;
    }

    .type-td{
        overflow-x: scroll;
        white-space: nowrap;
    }

    .tooltip-custom{
        position: relative;
    }

    .tooltip-custom:after{
        content: 'Imprimir lista de empaque';
        position: absolute;
        width: 165px;
        padding: 5px 15px;
        display: block;
        background-color: #7987a1;
        top: -30px;
        left: -75px;
        text-align: center;
        border-radius: 10px;
        word-wrap: normal;
        color: #fff;
        font-size: .8em;
        opacity: 0;
        box-shadow: 0px 0px 10px -1px rgba(0, 0, 0, .4);
    }

    .tooltip-custom:hover:after{
        opacity: 1;
    }
</style>

<table class="table">
    <thead>
        <tr>
            <th>Orden</th>
            <th>ID Pago</th>
            <th>Método</th>
            <th>Comprador</th>
            <th>Fecha de Compra</th>
            <th>Cantidad Pagada</th>
            <th>Estatus</th>
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
          
            <td class="type-td" style="width:280px;">{{ $order->payment_id }}</td>
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

            <td>{{ $order->user->name }}</td>
            <td>
                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($order->created_at)->format('d M Y - h:ia') }}</span>
            </td>
            <td><strong>${{ number_format($order->payment_total, 2) }}</strong><i class="far fa-question-circle ml-1" style="font-size:.7em;" data-toggle="tooltip" data-placement="top" title="Esta es la cantidad total pagada por el cliente en la compra."></i> </td>
            <td>
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