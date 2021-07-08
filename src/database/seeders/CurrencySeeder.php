<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'code' => 'USD',
            'name' => 'Dollar'
        ]);

        Currency::create([
            'code' => 'MXN',
            'name' => 'Peso Mexicano'
        ]);
    }
}
