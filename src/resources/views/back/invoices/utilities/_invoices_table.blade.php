<style type="text/css">
    .btn-completado {
        color: #fff;
        background-color: #10b759;
        border-color: #10b759;
    }

    .btn-en-proceso {
        color: #fff;
        background-color: #fa983a;
        border-color: #fa983a;
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

    .type-td{
        overflow-x: scroll;
        white-space: nowrap;
    }

    .filter-btn{
        border: none;
        background-color: transparent;
        color: rgba(27, 46, 75, 0.7);
        font-size: 12px;
        padding: 0px 2px;
    }

    .table .table-title{
        margin-right: 6px;
    }

    .filter-btn:hover{
        color: #000;
    }

    .table-dashboard thead th, .table-dashboard tbody td{
        white-space: initial;
    }
</style>

<table class="table table-dashboard">
    <thead>
        <tr>
            <th>ID</th>
            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Orden</span>
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'order_id'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'order_id'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Comprador</span>
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'rfc_num'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'rfc_num'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th style="width: 80px;">
               <div class="d-flex align-items-center">
                    <span class="table-title">Método</span>
                        {{-- 
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'payment_method'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'payment_method'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                        --}}
                </div>
            </th>
            
            <th style="min-width: 200px;">
                <div class="d-flex align-items-center">
                    <span class="table-title">Fecha de Solicitud</span>
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'created_at'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'created_at'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>

            <th style="min-width: 100px;">
                <div class="d-flex align-items-center">
                    <span class="table-title">Total</span>
                        {{-- 
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'payment_total'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'payment_total'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                        --}}
                </div>
            </th>

            <th>
                <div class="d-flex align-items-center">
                    <span class="table-title">Estatus</span>
                        <a class="filter-btn" href="{{route('filter.invoices', ['asc', 'status'])}}">
                        <i class="icon ion-md-arrow-up"></i></a>
                        <a class="filter-btn" href="{{route('filter.invoices', ['desc', 'status'])}}">
                        <i class="icon ion-md-arrow-down"></i></a>
                </div>
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td class="type-td">
                <a href="{{ route('invoices.show', $invoice->id) }}">
                    #{{ $invoice->invoice_request_num }}
                </a>
            </td>
            

            <td class="type-td">
                <a href="{{ route('orders.show', $invoice->order->id) }}">
                    <i class="fas fa-shopping-bag"></i>
                    @if(strlen($invoice->order->id) == 1)
                    #00{{ $invoice->order->id }}
                    @endif
                    @if(strlen($invoice->order->id) == 2)
                    #0{{ $invoice->order->id }}
                    @endif
                    @if(strlen($invoice->order->id) > 2)
                    #{{ $invoice->order->id }}
                    @endif
                </a>
            </td>

            <td>
                <strong class="d-block">{{ $invoice->user->name }}</strong>
                <small class="d-block mb-0">{{ $invoice->rfc_num }}</small>
                <small class="d-block mb-0">{{ $invoice->cfdi_use }}</small>
            </td>

            <td class="text-muted">
                <span style="display:block; width:120px;" data-toggle="tooltip" data-placement="bottom" title="ID de Pago: {{ $invoice->payment_id }}">
                	@if($invoice->order->payment_method == 'Paypal')
                		<i class="fab fa-paypal"></i>
                	@else
                		<i class="fas fa-credit-card"></i>
                	@endif

                	{{ $invoice->order->payment_method }}
                </span>
            </td>

            <td>
                <span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($invoice->created_at)->format('d M Y - h:ia') }}</span>
            </td>

            <td><strong>${{ number_format($invoice->order->payment_total, 2) }}</strong><i class="far fa-question-circle ml-1" style="font-size:.7em;" data-toggle="tooltip" data-placement="top" title="Esta es la cantidad total pagada por el cliente en la compra."></i> </td>

            <td>
                <div class="badge badge-table btn-{{ Str::slug($invoice->status) }}">
                    <div class="invoice-info">
                        @switch($invoice->status)
                            @case('En Proceso')
                                <i class="fas fa-exclamation mr-1"></i> 
                                @break

                            @case('Completado')
                                <i class="fas fa-check mr-1"></i> 
                                @break

                            @case('Cancelado')
                                <i class="fas fa-times mr-1"></i> 
                                @break

                            @case('Expirado')
                                <i class="fas fa-times mr-1"></i> 
                                @break

                            @default
                                <i class="fas fa-check mr-1"></i> 

                        @endswitch
                        
                        <span>{{ $invoice->status ?? 'Completado'}}</span>
                    </div> 
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>