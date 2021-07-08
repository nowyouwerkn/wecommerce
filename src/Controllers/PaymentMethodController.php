<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use Carbon\Carbon;

use Nowyouwerkn\WeCommerce\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payments = PaymentMethod::all();

        $conekta_method = PaymentMethod::where('type', 'card')->where('supplier', 'Conekta')->first();
        $oxxo_pay = PaymentMethod::where('type', 'cash')->where('supplier', 'Conekta')->first();
        $stripe_method = PaymentMethod::where('type', 'card')->where('supplier', 'Stripe')->first();
        $openpay_method = PaymentMethod::where('type', 'card')->where('supplier', 'OpenPay')->first();
        $paypal_method = PaymentMethod::where('type', 'card')->where('supplier', 'Paypal')->first();

        return view('wecommerce::back.payments.index')
        ->with('payments', $payments)
        ->with('conekta_method', $conekta_method)
        ->with('oxxo_pay', $oxxo_pay)
        ->with('stripe_method', $stripe_method)
        ->with('openpay_method', $openpay_method)
        ->with('paypal_method', $paypal_method);
    }

    public function create()
    {
        return view('wecommerce::back.payments.create');
    }

    public function store(Request $request)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        // Desactivar cualquier otro método activo

        $deactivate = PaymentMethod::where('type', 'card')->where('is_active', 'true');

        foreach ($deactivate as $dt) {
            $dt->is_active = false;
            $dt->save();
        }

        $payment = PaymentMethod::where('type', $request->type)->where('supplier', $request->supplier)->first();

        if (!empty($payment)) {
            $payment->update([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => true,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'is_active' => true,
            ]);
        }else{
            $payment = PaymentMethod::create([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => true,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'is_active' => true,
            ]);
        }
        

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('payments.index');
    }

    public function show(PaymentMethod $paymentMethod)
    {
        return view('wecommerce::back.payments.show', compact('paymentMethod'));
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('wecommerce::back.payments.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //Validation
        $this -> validate($request, array(
            'type' => 'required|max:255',
        ));

        $payment = PaymentMethod::find($id);

        $payment->update([
            'type' => $request->type,
            'public_key' => $request->public_key,
            'private_key' => $request->private_key,
            'sandbox_mode' => $request->sandbox_mode,
            'email_access' => $request->email_access,
            'password_access' => $request->password_access,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('payments.index');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
