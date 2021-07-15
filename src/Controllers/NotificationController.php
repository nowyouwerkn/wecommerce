<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

/* E-commerce Models */
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Notification;
use Nowyouwerkn\WeCommerce\Models\StoreConfig;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        return view('wecommerce::back.notifications.index');
    }

    public function create()
    {
        return view('wecommerce::back.notifications.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function send($type, $by, $data)
    {
        /* LOG */
        $log = new Notification([
            'action_by' => $by->id,
            'type' => $type,
            'data' => $data,
            'is_hidden' => false
        ]);
        $log->save();
    }

    public function mailOrder($data, $name, $email)
    {
        $config = StoreConfig::find($id);

        Mail::send('mail.order_completed', $data, function($message) use($name, $email) {

            $message->to($email, $name)->subject('Gracias por comprar en '. $config->store_name);
            
            $message->from($config->sender_email, $config->store_name);
        });
    }
}
