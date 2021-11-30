<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\PaymentMethod; 

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'Conekta',
            'is_active' => false
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'Stripe',
             'is_active' => false
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'OxxoPay',
             'is_active' => false
        ]);

        PaymentMethod::create([
            'type' => 'cash',
            'supplier' => 'Conekta',
             'is_active' => false
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'Paypal',
             'is_active' => false
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'OpenPay',
             'is_active' => false
        ]);

          PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'MercadoPago',
            'is_active' => false,
            'mercadopago_oxxo' => 'oxxo',
            'mercadopago_paypal' => 'paypal'
        ]);
    }
}
