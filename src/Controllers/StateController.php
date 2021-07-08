<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Nowyouwerkn\WeCommerce\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function index()
    {
        return view('wecommerce::back.states.index');
    }

    public function create()
    {
        return view('wecommerce::back.states.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(State $state)
    {
        return view('wecommerce::back.states.show', compact('state'));
    }

    public function edit(State $state)
    {
        return view('wecommerce::back.states.edit', compact('state'));
    }

    public function update(Request $request, State $state)
    {
        //
    }

    public function destroy(State $state)
    {
        //
    }
}
