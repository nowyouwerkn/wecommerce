<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        return view('back.notifications.index');
    }

    public function create()
    {
        return view('back.notifications.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Notification $notification)
    {
        return view('back.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        return view('back.notifications.show', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function destroy(Notification $notification)
    {
        //
    }
}
