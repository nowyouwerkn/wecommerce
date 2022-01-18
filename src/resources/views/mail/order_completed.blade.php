@php
	$user = Nowyouwerkn\WeCommerce\Models\User::where('id', $user_id)->first();
	$order = Nowyouwerkn\WeCommerce\Models\Order::where('id', $order_id)->first();
	$order->cart = unserialize($order->cart);

	@if($shipping_id != 0)
		$shipping_option = Nowyouwerkn\WeCommerce\Models\ShippingOptions::where('id', $shipping_id)->first();
	@endif

	$legals = Nowyouwerkn\WeCommerce\Models\LegalText::all();
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="date=no" />
	<meta name="format-detection" content="address=no" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="x-apple-disable-message-reformatting" />

	<title>Correo de Notificación - Tienda en Línea</title>
</head>
<body style="
	padding:0 !important; 
	margin:0 auto !important; 
	display:block !important; 
	min-width:100% !important; 
	width:100% !important; 
	background:#f1f2f6; 
	-webkit-text-size-adjust:none;
	color: #2f3542;
	font-family: 'Helvetica', sans-serif;
	font-size: 90%;
	">
	<center>
		<table style="width: 100%;" cellspacing="20">
			<tbody>
				<tr>
					<td style="width: 50%;">
						<img style="width:140px;" src="{{ $logo }}">
					</td>
					<td style="width: 50%;">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<table style="width: 100%;"  cellspacing="20">
			<tbody>
				<tr>
					<td>
						<h1 style="margin-bottom:0px; text-transform: uppercase;">GRACIAS {{ $user->name }}, ESTAMOS TRABAJANDO EN TU PEDIDO.</h1>
						<p style="margin-top: 10px; line-height: 1.8;">Tu pedido est&aacute; en proceso. Estamos trabajando para empacarlo y dejarlo en tu puerta, pronto recibir&aacute;s un correo electr&oacute;nico de confirmaci&oacute;n con una guía de seguimiento.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="width: 100%; background: #2f3542; color: #f1f2f6;"  cellspacing="20" cellpadding="20">
			<tbody>
				<tr>
					<td style="width: 50%; vertical-align: top;">
						<p style="margin-bottom:10px;"><strong>Enviar a:</strong></p>
						<ul style="margin-top:5px;list-style: none; padding: 0px;">
							<li>{{ $user->name }}</li>
							<li>{{ $order->street . ' ' . $order->street_num }}</li>
							<li>{{ $order->suburb }}</li>
							<li>{{ $order->postal_code }}, {{ $order->city . ',' . $order->state }}</li>
						</ul>
					</td>

					<td style="width: 50%; vertical-align: top;">
						<p style="margin-bottom:10px;"><strong>Número de pedido:</strong></p>
						<p style="margin-top:5px;">#0{{ $order_id }}</p>
					</td>
				</tr>
				<tr>
					<td style="width: 50%; vertical-align: top;">
						<p style="margin-bottom:10px;"><strong>Fecha del pedido</strong></p>
						<p style="margin-top:5px;">{{ $order->created_at }}</p>
					</td>
					@if ($shipping_option != null)
					<td style="width: 50%; vertical-align: top;">
						<p style="margin-bottom:10px;"><strong>Método de envío</strong></p>
						<p style="margin-top:5px;">{{ $shipping_option->name }}<br>
						<small>Con un tiempo estimado de entrega de: {{ $shipping_option->delivery_time }}</small><br>
						<small>Se te enviará un correo con tu guía de seguimiento</small></p>
					</td>
					@endif
				</tr>
			</tbody>
		</table>
		<table style="width: 100%;"  cellspacing="20">
			<tbody>
				@foreach($order->cart->items as $item)
				<tr style="">
					<td style="width: 50%; vertical-align: top;">
						<img src="{{ asset('img/products/' . $item['item']['image'] ) }}" alt="{{ $item['item']['name'] }}" style="width:100%; mix-blend-mode: multiply;">
					</td>
					<td style="width: 50%;">
						<h3 style="margin-bottom:10px;">{{ $item['item']['name'] }}</h3>
						<ul style="margin-top:5px;list-style: none; padding: 0px;">
							<li><strong>Talla:</strong> {{ $item['variant'] }}</li>
							<li><strong>Cantidad:</strong> {{ $item['qty'] }}</li>
							@if($item['item']['has_discount'] == true)
							<li><strong>Precio Unt:</strong> $ {{ number_format($item['item']['discount_price']) }}</li>
							@else
							<li><strong>Precio Unt:</strong> $ {{ number_format($item['item']['price']) }}</li>
							@endif
						</ul>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<table style="width: 100%;"  cellspacing="20">
			<tbody>
				<tr>
					<td style="width: 50%; vertical-align: top;">
						<h3 style="margin-bottom:10px;">M&eacute;todo de pago</h3>
						@switch($order->payment_method)
							@case('Paypal')
							<p style="margin-top:5px;">Paypal</p>
							@break

							@default
							<p style="margin-top:5px;">Tarjeta: XXXX XXXX XXXX {{ $order->card_digits }}</p>
							@break
						@endswitch
						
					</td>
					<td style="width: 50%; vertical-align: top;">
						<ul style="margin-top:20px;list-style: none; padding: 0px;">
							<li style="margin-bottom:5px;"><strong>Subtotal:</strong> ${{ number_format($order->cart_total) }}</li>
							<li style="margin-bottom:5px;"><strong>Envío:</strong> ${{ number_format($order->shipping_rate) }}</li>
							<li style="margin-bottom:5px;"><strong>Cupones/Descuentos:</strong> ${{ number_format($order->discounts) }}</li>
							<li style="border:1px solid rgba(0,0,0,0.4); margin-bottom: 10px; margin-top: 10px;"></li>
							<li style="font-size: 120%;"><strong>Total:</strong> ${{ number_format($order->payment_total) }}</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="width: 100%; background: #fff; text-align: center; padding: 0 20%; color: #a4b0be; font-size: 80%;"  cellspacing="20">
			<tbody>
				<tr>
					<td>
						<ul style="list-style: none;display: inline-flex;padding: 0px;">
                            <li style="padding:0px 5px;"><a href="">Inicio</a></li>
                            <li style="padding:0px 5px;"><a href="">Catálogo</a></li>
                            
                            @foreach($legals as $legal)
                            <li style="padding:0px 5px;">
                                <a href="{{ route('legal.text' , $legal->type) }}">
                                    @switch($legal->type)
                                        @case('Returns')
                                            Política de Devoluciones
                                            @break

                                        @case('Privacy')
                                            Política de Privacidad
                                            @break

                                        @case('Terms')
                                            Términos y Condiciones
                                            @break

                                        @case('Shipment')
                                            Política de Envíos
                                            @break

                                        @default
                                            Hubo un problema, intenta después.
                                    @endswitch 
                                </a>
                            </li>
                            @endforeach
                        </ul>

						<p>Si tienes alguna pregunta, no dudes en contactarnos (Si respondes a este correo electr&oacute;nico, no podremos verlo)</p>

						<p>&nbsp;</p>
						<p>2021 {{ $store_name }}. Todos los derechos reservados. <a href="{{ route('index') }}">{{ route('index') }}</a></p>
					</td>
				</tr>
			</tbody>
		</table>
	</center>
</body>
</html>