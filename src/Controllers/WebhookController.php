<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Carbon\Carbon;

use Purifier;
use Mail;

use Illuminate\Http\Request;

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
}
