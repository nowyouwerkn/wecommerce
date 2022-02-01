<div class="card card-body card-order mb-5">  
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex justify-content-between">
            <p class="text-primary mb-0 d-flex align-items-center">
                <ion-icon name="bag-handle-outline" class="me-2"></ion-icon>

                <span class="me-2">Resumen de Orden</span>

                @if(strlen($order->id) == 1)
                #00{{ $order->id }}
                @endif
                @if(strlen($order->id) == 2)
                #0{{ $order->id }}
                @endif
                @if(strlen($order->id) > 2)
                #{{ $order->id }}
                @endif
            </p>
        </div>

        <p class="mb-0" style="font-size:.8em;">{{ Carbon\Carbon::parse($order->created_at)->format('d M Y, h:ia') }}</p>
    </div>
    <hr>
    @if($order->cart == NULL)
        <p class="alert alert-warning">Esta orden proviene de una importación de otro sistema. El "módulo carrito" no es compatible con la información y no puede mostrar los detalles.</p>
    @else
        @foreach($order->cart->items as $item)
        <div class="card order-card-product py-0 px-3 mb-3 ps-1">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img height="45px" alt="{{ $item['item']['name'] }}" src="{{ asset('img/products/' . $item['item']['image'] ) }}">
                    <div class="d-flex align-items-center">
                        <p class="mb-0 me-2"><strong>{{ $item['item']['name'] }}</strong></p>

                        @if($item['item']['color'] != NULL)
                        <p class="mb-0 me-1">{{ $item['item']['color'] }}</p>
                        @endif
                        <p class="mb-0">x {{ $item['qty'] }}</p>
                        <span class="me-1 ms-1">|</span>
                        <p class="mb-0">Talla: {{ $item['variant']; }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="pl-1 align-self-center pr-4">
                        <p class="mb-0"><strong>${{ number_format($item['price'],2) }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    <div class="d-flex justify-content-between order-card-info">
        <p class="mb-0" style="width: 55%;">
            <ion-icon name="navigate-circle-outline"></ion-icon> 
            <strong>Dirección de Envío:</strong>
        </p>

        <p class="mb-0 text-end">{{ $order->street }} {{ $order->street_num }}, {{ $order->city }} {{ $order->state }}, {{ $order->country }}, C.P {{ $order->postal_code }}</p>
    </div>       
    <hr>
    <div class="order-card-info">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Sub-total:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>${{ number_format($order->sub_total, 2) ?? 'N/A' }}</strong></p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Envío:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>${{ number_format($order->shipping_rate, 2) ?? 'N/A' }}</strong></p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Descuentos:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>${{ number_format($order->discounts, 2) ?? 'N/A' }}</strong></p>
            </div>
        </div>

          <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Cupón usado:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>{{ $order->coupon_id ?? 'N/A' }}</strong></p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Impuestos:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>${{ number_format($order->tax_rate, 2) ?? 'N/A' }}</strong></p>
            </div>
        </div>

        <hr>

        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 mt-0">Total:</h6>
            </div>
            <div class="col text-end">
                <p class="mb-0"><strong>${{ number_format($order->payment_total, 2) ?? 'N/A' }}</strong></p>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <p class="mb-0"><strong>Tarjeta:</strong> **** **** **** {{ $order->card_digits }}</p>
            <p class="mb-0 d-flex align-items-center">
                <strong class="me-1">Procesado por:</strong>

                @if($order->payment_method == 'Paypal')
                    <ion-icon name="logo-paypal"></ion-icon>
                @else
                    <ion-icon name="card-outline"></ion-icon>
                @endif

                <span class="ms-1">{{ $order->payment_method }}</span>
            </p>
        </div>
    </div>
    <hr>

    @if($order->status != 'Cancelado')
        @guest
        <div class="d-flex justify-content-end">
            <div>
                <a href="javascript:void(0)" class="btn btn-dark btn-sm d-flex align-items-center disabled" style="font-size: .8em;"><ion-icon name="document-text-outline" class="me-2"></ion-icon> Solicitar factura</a>
                <p class="mb-0 mt-2" style="font-size:.8em;">Para solicitar factura inicia sesión <a href="{{ route('login') }}">aquí.</a></p>
            </div>
            
        </div>
        @else
        
            @if($order->invoice == NULL)
            <div class="d-flex justify-content-end">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#invoiceModal_{{ $order->id }}" class="btn btn-dark btn-sm d-flex align-items-center" style="font-size: .8em;"><ion-icon name="document-text-outline" class="me-2"></ion-icon> Solicitar factura</a>
            </div>
            @else
            <div class="d-flex justify-content-between order-card-info">
                <p class="mb-0"><strong><ion-icon name="checkbox-outline"></ion-icon> Factura solicitada</strong></p>
                
                <p class="mb-0">
                    Estado:
                    @switch($order->invoice->status)
                        @case('En Proceso')
                            <span class="badge bg-warning">{{ $order->invoice->status }}</span>
                            @break

                        @case('Completado')
                            <span class="badge bg-success">{{ $order->invoice->status }}</span>
                            @break

                        @case('Cancelado')
                            <span class="badge bg-danger">{{ $order->invoice->status }}</span>
                            @break

                        @case('Expirado')
                            <span class="badge bg-danger">{{ $order->invoice->status }}</span>
                            @break

                        @default
                            <span class="badge bg-dark">{{ $order->invoice->status }}</span>

                    @endswitch
                </p>
            </div>

            <div class="d-flex order-card-info mt-2">
                <ul class="list-inline">
                    @if($order->invoice->pdf_file != NULL)
                    <li class="list-inline-item"><a href="{{ asset('files/invoices/' . $order->invoice->pdf_file ) }}" target="_blank"><ion-icon name="document-outline"></ion-icon> PDF</a></li>
                    @endif

                    @if($order->invoice->xml_file != NULL)
                    <li class="list-inline-item"><a href="{{ asset('files/invoices/' . $order->invoice->xml_file ) }}" target="_blank"><ion-icon name="document-outline"></ion-icon> XML</a></li>
                    @endif

                    @if($order->invoice->file_attachment != NULL)
                    <li class="list-inline-item"><a href="{{ asset('files/invoices/' . $order->invoice->file_attachment ) }}" target="_blank"><ion-icon name="folder-outline"></ion-icon> .ZIP</a></li>
                    @endif
                </ul>
            </div>
            @endif
        
        @endguest
    @endif

    <div class="card-order-status" style="font-size:12px;">
        @if($order->status == 'Cancelado')
        <span class="badge bg-danger d-block">Orden Cancelada o Expirada</span>
        @else
        <div class="progress">
                @if($order->status == 'Pagado')
                <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                @endif

                @if($order->status == 'Empaquetado')
                <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                @endif

                @if($order->status == 'Enviado')
                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                @endif

                @if($order->status == 'Entregado')
                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Progreso">
                @endif

                <span class="progress-type"><i class="box-icon-order"></i></span>
            </div>
        </div>

        <div class="progress-meter">
            <div class="meter meter-left" style="width: 25%;"><span class="meter-text">Pagado</span></div>
            <div class="meter meter-left" style="width: 25%;"><span class="meter-text">Empaquetado</span></div>
            <div class="meter meter-right" style="width: 25%;"><span class="meter-text">Entregado</span></div>
            <div class="meter meter-right" style="width: 25%;"><span class="meter-text">Enviado</span></div>
        </div>
        @endif
    </div>
    
    @if($order->trackings->count())
    <div class="d-flex order-card-info mt-4">
        <p class="mb-0 me-3">
            <ion-icon name="navigate-circle-outline"></ion-icon> 
            <strong>Guía de rastreo:</strong>
        </p>

        @foreach($order->trackings as $tracking)
            <p class="mb-0 text-end">{{ $tracking->tracking_number }}</p>
        @endforeach
    </div>
    @endif
</div>

@if($order->status != 'Cancelado')
@auth
<!-- Modal -->
<div class="modal fade" id="invoiceModal_{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitando factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('invoice.request', [$order->id, Auth::user()->id]) }}" method="POST">
        {{ csrf_field() }}
          <div class="modal-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label" for="rfc_num">RFC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rfc_num" name="rfc_num" value="" required="" />
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label" for="cfdi_use">Uso de CFDI <span class="text-danger">*</span></label>
                        <select class="form-control form-control" id="cfdi_use" name="cfdi_use">
                            <option value="P01 Por Definir">P01 Por Definir</option>
                            <option value="G01 Adquisición de mercancías">G01 Adquisición de mercancías</option>
                            <option value="G03 Gastos en General" selected="">G03 Gastos en General</option>
                        </select>
                    </div>
                </div> 
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endauth
@endif