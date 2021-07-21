<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

/* E-commerce Models */
use Config;
use Mail;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

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

    public function all()
    {
        $notifications = Notification::paginate(50);

        return view('wecommerce::back.notifications.all', compact('notifications'));
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
        $notifications = Notification::findOrFail($id);

        $notification->read_at = Carbon::now();

        $notification->save();
        

        // Mensaje de session
        Session::flash('success', 'Notificación marcadas como leídas.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }

    public function send($type, $by, $data)
    {
        /* LOG */
        if ($by == NULL) {
            $log = new Notification([
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }else{
            $log = new Notification([
                'action_by' => $by->id,
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }
        
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

    public function markAsRead()
    {
        $notifications = Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->get();

        foreach($notifications as $notification){
            $notification->read_at = Carbon::now();

            $notification->save();
        }

        // Mensaje de session
        Session::flash('success', 'Notificaciones marcadas como leídas.');

        return redirect()->back();
    }
}
