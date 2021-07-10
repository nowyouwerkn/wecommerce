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
            'supplier' => 'Conekta'
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'Stripe'
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'OxxoPay'
        ]);

        PaymentMethod::create([
            'type' => 'cash',
            'supplier' => 'Conekta'
        ]);

        PaymentMethod::create([
            'type' => 'card',
            'supplier' => 'Paypal'
        ]);
    }
}
