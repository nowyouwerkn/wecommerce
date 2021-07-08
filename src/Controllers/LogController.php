<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index()
    {
        return view('back.log.index');
    }

    public function create()
    {
        return view('back.log.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Log $log)
    {
        return view('back.log.show', compact('log'));
    }

    public function edit(Log $log)
    {
        return view('back.log.edit', compact('log'));
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
