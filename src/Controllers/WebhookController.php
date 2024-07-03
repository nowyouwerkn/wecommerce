<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use DB;
use Config;
use Auth;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\Product;
use Nowyouwerkn\WeCommerce\Models\ProductVariant;
use Nowyouwerkn\WeCommerce\Models\Variant;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod;

class WebhookController extends Controller
{

	public function testJson()
	{
		$body = @file_get_contents('./test_webhook.json');
		$data = json_decode($body, true);

		//dd($data['data']['object']);
		$conekta_id = $data['object']['payment_method']['object'];
		dd($conekta_id);
		$order = Order::where('payment_id', $conekta_id)->first();

		$order->is_completed = 0;
		$order->status = 1;
		$order->save();

		$email = $order->user->email;
        $name = $order->user->name;

		dd($name);
		return response()->json(['json' => $json]);
	}

  public function order()
	{	
		$body = @file_get_contents('php://input');
		$data = json_decode($body, true);
		http_response_code(200); 

		if($data['type'] == 'charge.expired'){
			$reference = $data['data']['object']['payment_method']['reference'];
			$order = Order::where('payment_id', $reference)->first();

			$order->is_completed = 0;
			$order->status = 1;
			$order->save();

			$email = $order->user->email;
            $name = $order->user->name;

            $data = array('name'=> $name, 'reference' => $reference);

            Mail::send('mail.order_expired', $data ,function($message) use($name, $email) {
                $message->to($email, $name)->subject('Referencia Expirada');
                $message->from('noreply@manfort.com.mx','Manfort México');
            });

			return response()->json(['mensaje' => 'Orden Expirada.', 'order' => $reference]);
		}

		if ($data['type'] == 'charge.paid') {
			if ($data['data']['object']['payment_method']['object'] == 'cash_payment') {
				$reference = $data['data']['object']['payment_method']['reference'];
			}else{
				$reference = $data['data']['object']['order_id'];
			}
			
			$order = Order::where('payment_id', $reference)->first();

			$order->is_completed = 1;
			$order->status = 0;
			$order->save();

			return response()->json(['mensaje' => 'Orden Pagada Exitosamente.', 'order' => $reference]);
		}

		//return response()->json('Exitoso');
	}

	public function orderMercadoPago()
	{	
		$body = @file_get_contents('php://input');
		$data = json_decode($body, true);
		http_response_code(200); 

		if($data['type'] == 'charge.expired'){
			// Obtener usuario de la orden de MercadoPago
			$user = User::where('email', $data['payer']['email'])->first();
			// Encontrar la orden de mercadopago realizada por este usuario
			$orders = Order::where('user_id', $user->id)->where('payment_method', 'MercadoPago')->where('status', 'Sin Completar')->first();
			$reference = $data['id'];

			$order->is_completed = 0;
			$order->status = 1;
			$order->save();

			return response()->json(['mensaje' => 'Orden Pagada Exitosamente.', 'order' => $reference]);
		}
  	}

	public function orderKueski()
	{
		$body = @file_get_contents('php://input');
		$data = json_decode($body, true);
		http_response_code(200); 

		$payment_method = PaymentMethod::where('supplier', 'Kueski')->where('is_active', true)->first();

		if ($payment_method->sandbox_mode == '1') {
			$private_key_kueski = $payment_method->sandbox_public_key;
		} else {
			$private_key_kueski = $payment_method->public_key;
		}
		
		$api_key = $private_key_kueski;

		if($data['status'] == 'approved'){
			// Encontrar la orden de Kueski realizada por este usuario
			$order = Order::where('payment_id', $data['payment_id'])->first();

			if($order != NULL){
				$order->is_completed = 1;
				$order->status = 'Pagado';
				$order->save();
				
				$cart = unserialize($order->cart);
			
				// Actualizar existencias del producto
				foreach ($cart->items as $product) {

					if ($product['item']['has_variants'] == true) {
						$variant = Variant::where('value', $product['variant'])->first();
						$product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();
						
						if($product_variant != NULL){
							/* Proceso de Reducción de Stock */
							$values = array(
								'action_by' => $order->user_id,
								'initial_value' => $product_variant->stock ?? 0, 
								'final_value' => $product_variant->stock ?? 0 - $product['qty'], 
								'product_id' => $product_variant->id ?? 0,
								'created_at' => Carbon::now(),
							);
			
							DB::table('inventory_record')->insert($values);
			
							/* Guardado completo de existencias */
							$product_variant->stock = $product_variant->stock  ?? 0 - $product['qty'];
							$product_variant->save();
						}
					} else {
						$product_stock = Product::find($product['item']['id']);
			
						$product_stock->stock = $product_stock->stock ?? 0 - $product['qty'];
						$product_stock->save();
					}
				}
			}else{
				return response()->json(['mensaje' => 'No existe orden de compra con ese ID de Pago','status' => 'approved'], 200)->header('Authorization', 'Bearer ' . $api_key);
			}

			return response()->json(['status' => 'approved'], 200)->header('Authorization', 'Bearer ' . $api_key);
		}

		if($data['status'] == 'denied'){
			// Encontrar la orden de Kueski realizada por este usuario
			$order = Order::where('payment_id', $data['payment_id'])->first();

			if($order != NULL){
				$order->status = 'Prestamo Denegado';
				$order->save();

				$cart = unserialize($order->cart);

				// Actualizar existencias del producto
				foreach ($cart->items as $product) {
					if ($product['item']['has_variants'] == true) {
						$variant = Variant::where('value', $product['variant'])->first();
						$product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

						if($product_variant != NULL){
							$product_variant->stock = $product_variant->stock + $product['qty'];
							$product_variant->save();
						}

					} else {
						$product_stock = Product::find($product['item']['id']);

						$product_stock->stock = $product_stock->stock + $product['qty'];
						$product_stock->save();
					}
				}
			}else{
				return response()->json(['mensaje' => 'No existe orden de compra con ese ID de Pago','status' => 'denied'], 200)->header('Authorization', 'Bearer ' . $api_key);;
			}
				
			return response()->json(['status' => 'denied'], 200)->header('Authorization', 'Bearer ' . $api_key);;
		}

		if($data['status'] == 'canceled'){
			// Encontrar la orden de Kueski realizada por este usuario
			$order = Order::where('payment_id', $data['payment_id'])->first();

			if($order != NULL){
				$order->status = 'Cancelado';
				$order->save();

				$cart = unserialize($order->cart);

				// Actualizar existencias del producto
				foreach ($cart->items as $product) {
					if ($product['item']['has_variants'] == true) {
						$variant = Variant::where('value', $product['variant'])->first();
						$product_variant = ProductVariant::where('product_id', $product['item']['id'])->where('variant_id', $variant->id)->first();

						if($product_variant != NULL){
							$product_variant->stock = $product_variant->stock + $product['qty'];
							$product_variant->save();
						}
					} else {
						$product_stock = Product::find($product['item']['id']);

						$product_stock->stock = $product_stock->stock + $product['qty'];
						$product_stock->save();
					}
				}
			}else{
				return response()->json(['mensaje' => 'No existe orden de compra con ese ID de Pago', 'status' => 'canceled'], 200)->header('Authorization', 'Bearer ' . $api_key);;
			}

			return response()->json(['status' => 'canceled'], 200)->header('Authorization', 'Bearer ' . $api_key);;
		}

		return response()->json(['Evento recibido con éxito.'], 200)->header('Authorization', 'Bearer ' . $api_key);;
	}
}
