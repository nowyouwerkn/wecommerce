@extends('wecommerce::back.layouts.main')

@section('title')
<div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Facturación</a></li>
            <li class="breadcrumb-item active" aria-current="page">Solicitud # {{ $invoice->invoice_request_num }}</li>
            </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">
            Solicitud # {{ $invoice->invoice_request_num }}
        </h4>
    </div>

    <div class="d-none d-md-block">
        <a href="{{ route('invoices.index') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
            <i class="fas fa-undo mr-1"></i> Regresar al listado
        </a>
    </div>
</div>
@endsection

@push('stylesheets')
<style type="text/css">
	.well{
        border-radius: 15px;
        border: 1px solid rgba(0,0,0,.2);
        padding: 20px 30px;
    }

    .status-row{
        width: 100%;
    }

    .status-row .status-box{
        width: 100%;
        padding: 13px 20px;
        line-height: 1;
    }

   .btn-completado {
        color: #fff;
        background-color: #10b759;
        border-color: #10b759;
    }

    .btn-en-proceso{
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

    .btn-sin-completar {
        color: #fff;
        background-color: #0a3d62;
        border-color: #0a3d62;
    }

    /* FILE CARD */
	.file-card{
	  height: auto;
	  max-height: 230px;
	  width: 200px;
	}

	.file-card .dropdown-icon{
		width: 15px;
	}

	.file-card .card-body{
	  padding-top: 5px;
	  padding-bottom: 10px;
	}

	/* FILE COLORS */
	.file-card .xml-color .file-icon{
	  color: #778beb;
	}

	.file-card .xml-color .filename{
	  background-color: #778beb;
	  color: #fff;
	}

	/* PDF */
	.file-card .pdf-color .file-icon{
	  color: #ff6b6b;
	}

	.file-card .pdf-color .filename{
	  background-color: #ff6b6b;
	  color: #fff;
	}

	/* IMAGE */
	.file-card .zip-color .file-icon{
	  color: #00d2d3;
	}

	.file-card .zip-color .filename{
	  background-color: #00d2d3;
	  color: #fff;
	}

	/* ----------------- */

	.file-card .file-icon{
	  font-size: 4em;
	  width: 75px;
	  position: relative;
	  margin-right: -5px;
	}

	.file-card .file-icon .filename{
	  position: absolute;
	  top: 45px;
	  right: 10px;
	  text-transform: uppercase;
	  font-size: 12px;
	  padding: 0px 12px;
	}

	.file-card .card-options{
	  position: absolute;
	  z-index: 10;
	  top: 20px;
	  right: 20px;
	}

	.file-card .filename{
	  font-size: .8em;
	}

	.file-card .upload-time{
	  font-size: .7em;
	  margin-bottom: 0px;
	  margin-top: 10px;
	}

	.file-card hr{
	  margin: 0px auto;
	}
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="d-flex align-items-center status-row">
            <div class="status-box btn-{{ Str::slug($invoice->status) }}">
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

        <div class="card mb-4">
            <div class="card-body">
                <h5>Información de Compra:</h5>
                <hr>
                <p class="mb-0"><strong>Cuenta:</strong> <a href="{{ route('clients.show', $invoice->order->user_id) }}">{{ $invoice->order->user->name }}</a></p>

                <p class="mb-0"><strong>Nombre del Comprador:</strong> {{ $invoice->order->client_name }}</p>
                <p class="mb-0"><strong>E-Mail:</strong> {{ $invoice->order->user->email }}</p>
                <p class="mb-0"><strong>Teléfono:</strong> {{ $invoice->order->phone }}</p>
                <p class="mb-0"><strong>Tarjeta:</strong> **** **** **** {{ $invoice->order->card_digits }}</p>
                <p class="mb-0">
                	<strong>Método de pago:</strong>
                	@if($invoice->order->payment_method == 'Paypal')
                    <i class="fab fa-paypal"></i>
                	@else
                    <i class="fas fa-credit-card"></i>
                	@endif

                	{{ $invoice->order->payment_method }}
                </p>

                <hr>
                <div class="card">
                	@if($invoice->order->cart == NULL)
                    <p class="alert alert-warning">Esta orden proviene de una importación de otro sistema. Es posible que la información mostrada esté incompleta.</p>
                    @endif
                    <div class="card-body">  
                        <h6 class="d-flex justify-content-between">Resumen de Orden 
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
			            </h6>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Total en Carrito:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->cart_total, 2) }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Envío:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->shipping_rate, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Sub-total:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->sub_total, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Descuentos:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->discounts, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                          <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Cupón usado:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>{{ $invoice->order->coupon_id, 2 ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Impuestos:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->tax_rate, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 mt-0">Total cobrado al cliente:</h6>
                            </div>
                            <div class="col text-right">
                                <p class="mb-0"><strong>${{ number_format($invoice->order->payment_total, 2) ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
 
                <hr>

                <h6 class="mb-1 mt-3">Horario de Compra:</h6>
                <p class="mb-0"><span class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($invoice->order->created_at)->format('d M Y - h:ia') }}</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-body mb-4">
        	<h6 class="mb-0 mt-0">Archivos <a data-toggle="modal" data-target="#modalNuevoArchivo" href="#" class="ml-2 mb-0" style="font-size:.8em;"><i class="fas fa-plus"></i> Nuevo</a></h6>

			<hr>
            <div class="d-flex">
            	@if($invoice->pdf_file != NULL)
            		<div class="card file-card mr-3">
						<div class="card-options dropdown">
							<a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i data-feather="more-vertical"></i></a>

							<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-181px, -158px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a target="_blank" href="" class="dropdown-item"><i data-feather="download" class="dropdown-icon"></i> Descargar </a>

								<a href="" class="dropdown-item text-danger"><i data-feather="trash-2" class="dropdown-icon"></i> Eliminar</a>
							</div>
						</div>

						<div class="card-body">
							<div class="pdf-color">
								<div class="file-icon">
									<i class="far fa-file"></i>
									<span class="filename">PDF</span>
								</div>
							</div>

							<h5>Factura</h5>
							<p class="filename"><a target="_blank" href="{{ asset('img/clients/files/' . $invoice->pdf_file ) }}">{{ $invoice->pdf_file }}</a></p>
							<hr>
							<p class="upload-time">Subido: {{ $invoice->updated_at }}</p>
						</div>
					</div>
            	@endif

            	@if($invoice->xml_file != NULL)
            		<div class="card file-card mr-3">
						<div class="card-options dropdown">
							<a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i data-feather="more-vertical"></i></a>

							<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-181px, -158px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a target="_blank" href="" class="dropdown-item"><i data-feather="download" class="dropdown-icon"></i> Descargar </a>

								<a href="" class="dropdown-item text-danger"><i data-feather="trash-2" class="dropdown-icon"></i> Eliminar</a>
							</div>
						</div>

						<div class="card-body">
							<div class="xml-color">
								<div class="file-icon">
									<i class="far fa-file"></i>
									<span class="filename">XML</span>
								</div>
							</div>

							<h5>Factura</h5>
							<p class="filename"><a target="_blank" href="{{ asset('img/clients/files/' . $invoice->xml_file ) }}">{{ $invoice->xml_file }}</a></p>
							<hr>
							<p class="upload-time">Subido: {{ $invoice->updated_at }}</p>
						</div>
					</div>
            	@endif

            	@if($invoice->file_attachment != NULL)
            		<div class="card file-card mr-3">
						<div class="card-options dropdown">
							<a href="javascript:void(0)" data-toggle="dropdown" class="icon" aria-expanded="false"><i data-feather="more-vertical"></i></a>

							<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-181px, -158px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a target="_blank" href="" class="dropdown-item"><i data-feather="download" class="dropdown-icon"></i> Descargar </a>

								<a href="" class="dropdown-item text-danger"><i data-feather="trash-2" class="dropdown-icon"></i> Eliminar</a>
							</div>
						</div>

						<div class="card-body">
							<div class="zip-color">
								<div class="file-icon">
									<i class="far fa-file"></i>
									<span class="filename">.ZIP</span>
								</div>
							</div>

							<h5>Factura</h5>
							<p class="filename"><a target="_blank" href="{{ asset('img/clients/files/' . $invoice->file_attachment ) }}">{{ $invoice->file_attachment }}</a></p>
							<hr>
							<p class="upload-time">Subido: {{ $invoice->updated_at }}</p>
						</div>
					</div>
            	@endif
            </div>
            <hr>
            @if($invoice->pdf_file != NULL || $invoice->xml_file != NULL || $invoice->file_attachment != NULL)
        	<div class="d-flex justify-content-between">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#resendMail" class="btn btn-outline-info"><i class="fas fa-envelope"></i> Reenviar archivo(s) de factura</a>
            </div>
            @endif
        </div>

	    <div class="card mg-t-10 mb-4">
	        <div class="card-header pd-t-20 pd-b-0 bd-b-0">
	            <h6 class="mg-b-5">Histórico de esta solicitud</h6>
	            @php
	                $logs = Nowyouwerkn\WeCommerce\Models\Notification::where('type', 'Invoice')->where('model_id', $invoice->id)->get();
	            @endphp
	        </div>

	        @if($logs->count() != 0)
	            @include('wecommerce::back.layouts.partials._notification_table')
	        @else
	        <div class="card-body">
	            <h6 class="mb-0">No hay cambios en esta solicitud todavía.</h6>
	        </div>
	        @endif
	    </div>
	</div>
</div>

<!-- Modal Crear Nuevo -->
<div class="modal fade" id="modalNuevoArchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Subir Nuevo Archivo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>

			<form method="POST" action="{{ route('invoices.update', $invoice->id) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label>Formato</label>
							<select id="fileType" class="form-control" name="file_type" required="">
								<option value="individuales" selected data-name="individuales">Archivos Individuales</option>
								<option value="carpeta" data-name="carpeta">Carpeta comprimida (.zip)</option>
							</select>
						</div>
					</div>

					<div class="individual_files">
						<div class="row">
							<div class="form-group col-md-6">
								<label class="form-label">Archivo PDF <span class="text-danger">*</span></label>
								<input type="file" class="form-control" name="pdf_file" required="">
							</div>
							<div class="form-group col-md-6">
								<label class="form-label">Archivo XML <span class="text-info">(Opcional)</span></label>
								<input type="file" class="form-control" name="xml_file" required="">
							</div>
						</div>
					</div>

					<div class="compress_files" style="display:none;">
						<div class="row">
							<div class="form-group col-md-12">
								<label class="form-label">Archivo <span class="text-danger">*</span></label>
								<input type="file" class="form-control" name="file_attachment">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar Cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="resendMail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reenviar adjuntos de factura por correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('resend.invoice.mail', $invoice->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reenviar a:</label>
                                <input type="email" name="email" class="form-control" value="{{ $invoice->user->email }}">
                            </div>
                        </div>

                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Reenviar Ahora</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('#fileType').on('change', function(e){
		event.preventDefault();
        var value = $('#fileType option:selected').attr('data-name');

        $('.compress_files').hide();
        $('.individual_files').hide();
		$('.compress_files .form-control').attr('required', false);
		$('.individual_files .form-control').attr('required', false);

		if(value == 'individuales'){
			$('.individual_files').show();
			$('.individual_files .form-control').attr('required', true);
		}

		if(value == 'carpeta'){
			$('.compress_files').show();
			$('.compress_files .form-control').attr('required', true);
		}
	});
</script>
@endpush