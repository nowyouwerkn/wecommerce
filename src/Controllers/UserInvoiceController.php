<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Auth;
use Storage;
use Session;

use Nowyouwerkn\WeCommerce\Models\User;
use Nowyouwerkn\WeCommerce\Models\Order;
use Nowyouwerkn\WeCommerce\Models\UserInvoice;

/* Notificaciones */
use Nowyouwerkn\WeCommerce\Controllers\NotificationController;

/* Exportar Info */
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class UserInvoiceController extends Controller
{

    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationController;
    }

    public function index()
    {
        $dt = Carbon::now()->isCurrentMonth();

        $clients = User::all();
        $invoice_month = UserInvoice::where('created_at', $dt)->get();
        $invoices = UserInvoice::orderBy('created_at', 'desc')->paginate(30);
        $new_invoices = UserInvoice::where('created_at', '>=', Carbon::now()->subWeek())->count();

        return view('wecommerce::back.invoices.index')
        ->with('clients', $clients)
        ->with('invoices', $invoices)
        ->with('new_invoices', $new_invoices);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'condition' => 'unique:user_rules|max:255',
        ));

        $rule = UserInvoice::create([
            'type' => $request->type,
            'value' => str_replace(',', '',$request->value),
            'is_active' => true
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('coupons.index');
    }


    public function show($id)
    {
        
    }


    public function edit($id)
    {
        
    }

 
    public function update(Request $request, $id)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        $rule = UserInvoice::find($id);

        $rule->update([
            'type' => $request->type,
            'value' => $request->value,
            'is_active' => true,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('coupons.index');
    }

    public function destroy($id)
    {
        
    }

    public function changeStatus($id)
    {
        // Encontrar el valor de la regla que se quiere cambiar
        $rule = UserInvoice::find($id);

        // si la regla esta activa
        if ($rule->is_active == true) {
            // Desactivar cualquier otro método activo
            $deactivate = UserInvoice::where('is_active', false)->get();
            $rule->is_active = false;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
              
                }
            }
        }else{
            // Desactivar cualquier otro método activo
            $deactivate = UserInvoice::where('is_active', true)->get();
            $rule->is_active = true;

            if ($deactivate != null) {
                foreach ($deactivate as $dt) {
                    $dt->is_active = false;
                    $dt->save();
                }
            }
        }
        $rule->save();

        //Session message
        Session::flash('success', 'El elemento fue actualizado exitosamente.');

        return redirect()->back();
    }

    public function filter($invoice , $filter)
    {

        if ($filter == 'payment_total' && $invoice == 'desc') {
            $invoices = UserInvoice::orderByRaw('payment_total * 1 desc')->paginate(30);
        }elseif($filter == 'payment_total'&& $invoice == 'asc'){
            $invoices = UserInvoice::orderByRaw('payment_total * 1 asc')->paginate(30);
        }
        else{
            $invoices = UserInvoice::orderBy($filter, $invoice)->paginate(30);
        }
        
        $clients = User::all();

         return view('wecommerce::back.invoices.index')
        ->with('clients', $clients)
        ->with('invoices', $invoices);

    }
}
