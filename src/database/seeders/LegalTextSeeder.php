<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalText;

class LegalTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegalText::create([
            'type' => 'Returns',
        ]);

        LegalText::create([
            'type' => 'Privacy',
        ]);

        LegalText::create([
            'type' => 'Terms',
        ]);

        LegalText::create([
            'type' => 'Shipment',
        ]);

    }
}
