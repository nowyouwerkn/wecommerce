<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Str;
use Session;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\LegalText;

use Illuminate\Http\Request;

class LegalTextController extends Controller
{

    public function index()
    {
        $legals = LegalText::orderBy('priority','asc')->get();

        return view('wecommerce::back.legals.index')->with('legals', $legals);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'description' => 'required',
        ));

        // Guardar datos en la base de datos
        $legal = new LegalText;

        $legal->type = $request->type;
        $legal->title = Purifier::clean($request->title);
        $legal->description = Purifier::clean($request->description);
        $legal->priority = $request->priority;

        $legal->save();

        // Mensaje de session
        Session::flash('success', 'Tu información legal se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $legal = LegalText::find($id);

        return view('wecommerce::back.legals.edit')->with('legal', $legal);
    }


    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'description' => 'required',
            'title' => 'required'
        ));

        // Guardar datos en la base de datos
        $legal = LegalText::find($id);

        $legal->title = Purifier::clean($request->title);
        $legal->description = Purifier::clean($request->description);
        $legal->priority = $request->priority;
        $legal->save();

        // Mensaje de session
        Session::flash('success', 'Tu información legal se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $legal = LegalText::find($id);

        $legal->delete();

        Session::flash('success', 'The legal was succesfully deleted.');

        return redirect()->back();
    }
}
