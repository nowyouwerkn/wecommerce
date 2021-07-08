<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return view('wecommerce::back.users.index');
    }

    public function create()
    {
        return view('wecommerce::back.users.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('wecommerce::back.users.show', compact('id'));
    }

    public function edit($id)
    {
        return view('wecommerce::back.users.edit', compact('id'));
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
        return view('wecommerce::back.users.config');
    }
}
