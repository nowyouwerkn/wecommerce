<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Image;
use Session;
use Auth;
use Str;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

use Nowyouwerkn\WeCommerce\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $variants = Variant::all();

        return view('wecommerce::back.variants.index')->with('variants', $variants);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $variant = Variant::find($id);

        // Notificación
        $type = 'delete';
        $by = Auth::user();
        $data = 'eliminó la variante "' . $variant->value . '" del sistema.';

        $this->notification->send($type, $by ,$data);

        //
        $variant->delete();

        Session::flash('success', 'Se eliminó la variante correctamente.');

        return redirect()->back();
    }
}
