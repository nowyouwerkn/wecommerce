@php
	$user = Nowyouwerkn\WeCommerce\Models\User::where('id', $user_id)->first();
	$order = Nowyouwerkn\WeCommerce\Models\Order::where('id', $order_id)->first();
	$tracking = Nowyouwerkn\WeCommerce\Models\OrderTracking::where('order_id', $order_id)->first();

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
						<h1 style="margin-bottom:0px; text-transform: uppercase;">VAMOS EN CAMINO</h1>
						<p style="margin-top: 10px; line-height: 1.8;">Tu pedido ha sido enviado. Si quieres saber el estado de tu pedido puedes entrar a tu cuenta en la tienda o contactar con nuestros agentes digitales. Da seguimiento directo aquí: <a style="font-size: 2rem;" href="{{ route('utilities.tracking.index') }}">&#x2192;</a></p>
					</td>
				</tr>
			</tbody>
		</table>

		<table style="width: 100%; background: #fff; text-align: center; padding: 0 20%; color: #a4b0be; font-size: 80%;"  cellspacing="20">
			<tbody>
				<tr>
					<td>
						<p style="text-transform: uppercase; margin-bottom: 5px;">Guía de seguimiento</p>
						<h2 style="margin-top: 5px; font-size:250%;">{{ $tracking->tracking_number }}</h2>
						<p><strong>Enviado por:</strong> {{ $tracking->service_name }}</p>
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
					<td style="width: 50%; vertical-align: top;">
						<p style="margin-bottom:10px;"><strong>Método de envío</strong></p>
						<p style="margin-top:5px;">ESTÁNDAR</p>
					</td>
				</tr>
			</tbody>
		</table>

		<table style="width: 100%; background: #fff; text-align: center; padding: 0 20%; color: #a4b0be; font-size: 80%;"  cellspacing="20">
			<tbody>
				<tr>
					<td>
						<ul style="list-style: none;display: inline-flex;padding: 0px;">
							<li style="padding:0px 5px;"><a href="{{ route('index') }}">Inicio</a></li>
							<li style="padding:0px 5px;"><a href="{{ route('catalog.all') }}">Catálogo</a></li>

							@foreach($legals as $legal)
							<li style="padding:0px 5px;">
								<a href="{{ route('legal.text' , $legal->type) }}">
                                    {{ $legal->title }}
                                </a>
							</li>
							@endforeach
						</ul>

						<p>Si tienes alguna pregunta, no dudes en contactarnos (Si respondes a este correo electr&oacute;nico, no podremos verlo)</p>
						<p>&nbsp;</p>
						<p>{{ Carbon\Carbon::now()->format('Y') }} {{ $store_name }}. Todos los derechos reservados. <a href="{{ route('index') }}">{{ route('index') }}</a></p>
					</td>
				</tr>
			</tbody>
		</table>
	</center>
</body>
</html>