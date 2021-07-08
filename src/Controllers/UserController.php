<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return view('back.users.index');
    }

    public function create()
    {
        return view('back.users.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('back.users.show', compact('id'));
    }

    public function edit($id)
    {
        return view('back.users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function config()
    {
        return view('back.users.config');
    }
}
