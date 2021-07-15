<?php

/* Regular Laravel */
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Request;

use Nowyouwerkn\WeCommerce\Models\Notification;

class NotificationService
{   
    public function send($type, $data)
    {
    	/* LOG */
        $log = new Notification([
        	'action_by' => Auth::user()->id,
            'type' => $type,
            'data' => $data,
            'is_hidden' => false
        ]);
        $log->save();
    }
}