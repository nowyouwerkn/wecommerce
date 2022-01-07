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

		{
  "id": 1,
  "date_created": "2017-08-31T11:26:38.000Z",
  "date_approved": "2017-08-31T11:26:38.000Z",
  "date_last_updated": "2017-08-31T11:26:38.000Z",
  "money_release_date": "2017-09-14T11:26:38.000Z",
  "payment_method_id": "account_money",
  "payment_type_id": "credit_card",
  "status": "approved",
  "status_detail": "accredited",
  "currency_id": "BRL",
  "description": "Pago Pizza",
  "collector_id": 2,
  "payer": {
    "id": 123,
    "email": "afriend@gmail.com",
    "identification": {
      "type": "DNI",
      "number": 12345678
    },
    "type": "customer"
  },
  "metadata": {},
  "additional_info": {},
  "order": {},
  "transaction_amount": 250,
  "transaction_amount_refunded": 0,
  "coupon_amount": 0,
  "transaction_details": {
    "net_received_amount": 250,
    "total_paid_amount": 250,
    "overpaid_amount": 0,
    "installment_amount": 250
  },
  "installments": 1,
  "card": {}
}

{
  "id": 20359978,
  "date_created": "2019-07-10T14:47:58.000Z",
  "date_approved": "2019-07-10T14:47:58.000Z",
  "date_last_updated": "2019-07-10T14:47:58.000Z",
  "money_release_date": "2019-07-24T14:47:58.000Z",
  "issuer_id": 25,
  "payment_method_id": "visa",
  "payment_type_id": "credit_card",
  "status": "approved",
  "status_detail": "accredited",
  "currency_id": "BRL",
  "description": "Point Mini a maquininha que dá o dinheiro de suas vendas na hora",
  "taxes_amount": 0,
  "shipping_amount": 0,
  "collector_id": 448876418,
  "payer": {
    "id": 123,
    "email": "test_user_80507629@testuser.com",
    "identification": {
      "number": 19119119100,
      "type": "CPF"
    },
    "type": "customer"
  },
  "metadata": {},
  "additional_info": {
    "items": [
      {
        "id": "PR0001",
        "title": "Point Mini",
        "description": "Producto Point para cobros con tarjetas mediante bluetooth",
        "picture_url": "https://http2.mlstatic.com/resources/frontend/statics/growth-sellers-landings/device-mlb-point-i_medium@2x.png",
        "category_id": "electronics",
        "quantity": 1,
        "unit_price": 58.8
      }
    ],
    "payer": {
      "registration_date": "2019-01-01T15:01:01.000Z"
    },
    "shipments": {
      "receiver_address": {
        "street_name": "Av das Nacoes Unidas",
        "street_number": 3003,
        "zip_code": 6233200,
        "city_name": "Buzios",
        "state_name": "Rio de Janeiro"
      }
    }
  },
  "order": {},
  "external_reference": "MP0001",
  "transaction_amount": 58.8,
  "transaction_amount_refunded": 0,
  "coupon_amount": 0,
  "transaction_details": {
    "net_received_amount": 56.16,
    "total_paid_amount": 58.8,
    "overpaid_amount": 0,
    "installment_amount": 58.8
  },
  "fee_details": [
    {
      "type": "coupon_fee",
      "amount": 2.64,
      "fee_payer": "payer"
    }
  ],
  "statement_descriptor": "MercadoPago",
  "installments": 1,
  "card": {
    "first_six_digits": 423564,
    "last_four_digits": 5682,
    "expiration_month": 6,
    "expiration_year": 2023,
    "date_created": "2019-07-10T14:47:58.000Z",
    "date_last_updated": "2019-07-10T14:47:58.000Z",
    "cardholder": {
      "name": "APRO",
      "identification": {
        "number": 19119119100,
        "type": "CPF"
      }
    }
  },
  "notification_url": "https://www.suaurl.com/notificacoes/",
  "processing_mode": "aggregator",
  "point_of_interaction": {
    "type": "PIX",
    "application_data": {
      "name": "NAME_SDK",
      "version": "VERSION_NUMBER"
    },
    "transaction_data": {
      "qr_code_base64": "iVBORw0KGgoAAAANSUhEUgAABRQAAAUUCAYAAACu5p7oAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAIABJREFUeJzs2luO3LiWQNFmI+Y/Zd6vRt36KGNXi7ZOBtcagHD4kNLeiLX33v8DAAAAABD879sDAAAAAAA/h6AIAAAAAGSCIgAAAACQCYoAAAAAQCYoAgAAAACZoAgAAAAAZIIiAAAAAJAJigAAAABAJigCAAAAAJmgCAAAAABkgiIAAAAAkAmKAAAAAEAmKAIAAAAAmaAIAAAAAGSCIgAAAACQCYoAAAAAQCYoAgAAAACZoAgAAAAAZIIiAAAAAJAJigAAAABAJigCA...",
      "qr_code": "00020126600014br.gov.bcb.pix0117test@testuser.com0217dados adicionais520400005303986540510.005802BR5913Maria Silva6008Brasilia62070503***6304E2CA"
    }
  }
}

https://www.mercadopago.com.mx/developers/es/guides/notifications/webhooks

https://www.mercadopago.com.mx/developers/es/reference/payments/_payments_id/put

		//return response()->json('Exitoso');
	}
}
