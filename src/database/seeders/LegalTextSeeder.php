<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\LegalText;

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
            'title' => 'Cambios y Devoluciones'
        ]);

        LegalText::create([
            'type' => 'Privacy',
            'title' => 'Aviso de Privacidad'
        ]);

        LegalText::create([
            'type' => 'Terms',
            'title' => 'Términos y Condiciones'
        ]);

        LegalText::create([
            'type' => 'Shipment',
            'title' => 'Política de Envíos'
        ]);

    }
}
