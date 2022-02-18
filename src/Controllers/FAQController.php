<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Auth;
use Str;
use Session;
use Purifier;

use Nowyouwerkn\WeCommerce\Models\FAQ;

use Illuminate\Http\Request;

class FAQController extends Controller
{

    public function index()
    {
        $faqs = FAQ::all();

        return view('wecommerce::back.faqs.index')->with('faqs', $faqs);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'question' => 'required',
             'answer' => 'required'
        ));

        // Guardar datos en la base de datos
        $faq = new FAQ;

        $faq->question = Purifier::clean($request->question);
        $faq->answer = Purifier::clean($request->answer);

        $faq->save();

        // Mensaje de session
        Session::flash('success', 'Tu información de preguntas frecuentes se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $faq = FAQ::find($id);

        return view('wecommerce::back.faqs.index')->with('faq', $faq);
    }


    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'description' => 'required',
            'title' => 'required'
        ));

        // Guardar datos en la base de datos
        $faq = FAQ::find($id);

        $faq->question = Purifier::clean($request->question);
        $faq->answer = Purifier::clean($request->answer);

        $faq->save();

        // Mensaje de session
        Session::flash('success', 'Tu información de preguntas frecuentes se guardó correctamente en la base de datos.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $faq = FAQ::find($id);
        $faq->delete();

        Session::flash('success', 'La pregunta frecuente fue eliminada exitosamente.');

        return redirect()->back();
    }
}
