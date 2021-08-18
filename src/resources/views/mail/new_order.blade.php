<style type="text/css">
	*{
		font-family: 'Helvetica', sans-serif;
	}	
</style>

<h4>Nueva compra en tu tienda en línea</h4>
<hr>
<p>Número de órden: #0{{ $order_id }}</p>
<a href="{{ route('orders.show', $order_id) }}">Ver la órden en tu plataforma.</a>