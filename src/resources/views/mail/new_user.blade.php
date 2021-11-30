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
						<h1 style="margin-bottom:0px; text-transform: uppercase;">GRACIAS {{ $user->name }}, POR REGISTRARTE CON NOSTROS</h1>
						<p style="margin-top: 10px; line-height: 1.8;">¡Comienza tu colección con nosotros!.</p>

						<a href="{{ route('profile') }}" style="background: #fff; border:2px solid #2f3542; border-radius: 13px; padding:15px 20px; text-decoration: none; margin: 20px 0; display:block; text-align: center; width:50%; color: #2f3542;">Ver tu usuario en la plataforma.</a>
					</td>
				</tr>
			</tbody>
		</table>

		<table style="width: 100%; background: #fff; text-align: center; padding: 0 20%; color: #a4b0be; font-size: 80%;"  cellspacing="20">
			<tbody>
				<tr>
					<td>
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