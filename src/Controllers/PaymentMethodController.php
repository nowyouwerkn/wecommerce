<?php

namespace Nowyouwerkn\WeCommerce\Controllers;
use App\Http\Controllers\Controller;

use Session;

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
        $mercadopago_method = PaymentMethod::where('type', 'card')->where('supplier', 'MercadoPago')->first();
        $kueski_method = PaymentMethod::where('type', 'card')->where('supplier', 'Kueski')->first();

        return view('wecommerce::back.payments.index')
        ->with('payments', $payments)
        ->with('conekta_method', $conekta_method)
        ->with('oxxo_pay', $oxxo_pay)
        ->with('stripe_method', $stripe_method)
        ->with('openpay_method', $openpay_method)
        ->with('paypal_method', $paypal_method)
        ->with('mercadopago_method', $mercadopago_method)
        ->with('kueski_method', $kueski_method);
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
        if ($request->type == 'card') {
            if ($request->supplier == 'MercadoPago') {
                
            }else{
                $deactivate = PaymentMethod::where('supplier', '!=', 'Paypal')->where('supplier', '!=', 'MercadoPago')->where('type', 'card')->where('is_active', true)->get();
            }
        }

        if ($request->type == 'cash') { 
            $deactivate = PaymentMethod::where('type', 'cash')->where('is_active', true)->get();
        }

        if (!empty($deactivate)) {
            foreach ($deactivate as $dt) {
                $dt->is_active = false;
                $dt->sandbox_mode = false;
                $dt->save();
            }
        }

        $payment = PaymentMethod::where('type', $request->type)->where('supplier', $request->supplier)->first();

        if (!empty($payment)) {
            $payment->update([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'merchant_id' => $request->merchant_id,
                'sandbox_merchant_id' => $request->sandbox_merchant_id,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => $request->sandbox_mode,
                'sandbox_public_key' => $request->sandbox_public_key,
                'sandbox_private_key' => $request->sandbox_private_key,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'sandbox_email_access' => $request->sandbox_email_access,
                'sandbox_password_access' => $request->sandbox_password_access,
                'mercadopago_oxxo' => $request->mercadopago_oxxo,
                'mercadopago_paypal' => $request->mercadopago_paypal,
                'is_active' => true,
            ]);
        }else{
            $payment = PaymentMethod::create([
                'type' => $request->type,
                'supplier' => $request->supplier,
                'merchant_id' => $request->merchant_id,
                'sandbox_merchant_id' => $request->sandbox_merchant_id,
                'public_key' => $request->public_key,
                'private_key' => $request->private_key,
                'sandbox_mode' => $request->$sandbox_mode,
                'sandbox_public_key' => $request->sandbox_public_key,
                'sandbox_private_key' => $request->sandbox_private_key,
                'email_access' => $request->email_access,
                'password_access' => $request->password_access,
                'sandbox_email_access' => $request->sandbox_email_access,
                'sandbox_password_access' => $request->sandbox_password_access,
                'mercadopago_oxxo' => $request->mercadopago_oxxo,
                'mercadopago_paypal' => $request->mercadopago_paypal,
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
            'sandbox_public_key' => $request->sandbox_public_key,
            'sandbox_private_key' => $request->sandbox_private_key,
            'email_access' => $request->email_access,
            'password_access' => $request->password_access,
            'mercadopago_oxxo' => $request->mercadopago_oxxo,
            'mercadopago_paypal' => $request->mercadopago_paypal,
        ]);

        //Session message
        Session::flash('success', 'El elemento fue registrado exitosamente.');

        return redirect()->route('payments.index');
    }

      public function changeStatus($id)
    {

        $payment = PaymentMethod::find($id);

            $payment->update([
            'is_active' => 0,
            'sandbox_mode' => false
        ]);

        Session::flash('success', 'El elemento fue actualizado exitosamente.');

        return redirect()->back();

    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
