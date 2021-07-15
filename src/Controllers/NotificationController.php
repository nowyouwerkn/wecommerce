<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

/* E-commerce Models */
use Config;
use Mail;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Notification;
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

    public function show(Notification $notification)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        return view('wecommerce::back.notifications.show', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy(Notification $notification)
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
        Mail::send('mail.order_completed', $data, function($message) use($name, $email) {

            $message->to($email, $name)->subject
            ('Gracias por comprar Manfort');
            
            $message->from('noreply@manfort.com.mx','Manfort México');
        });
    }
}
