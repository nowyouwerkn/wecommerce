<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Nowyouwerkn\WeCommerce\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index()
    {
        return view('wecommerce::back.log.index');
    }

    public function create()
    {
        return view('wecommerce::back.log.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Log $log)
    {
        return view('wecommerce::back.log.show', compact('log'));
    }

    public function edit(Log $log)
    {
        return view('wecommerce::back.log.edit', compact('log'));
    }

    public function update(Request $request, Log $log)
    {
        //
    }

    public function destroy(Log $log)
    {
        //
    }
}
