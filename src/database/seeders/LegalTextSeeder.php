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
            'title' => 'Cambios y Devoluciones',
            'slug' => 'cambios-y-devoluciones'
        ]);

        LegalText::create([
            'type' => 'Privacy',
            'title' => 'Aviso de Privacidad',
            'slug' => 'aviso-de-privacidad'
        ]);

        LegalText::create([
            'type' => 'Terms',
            'title' => 'Términos y Condiciones',
            'slug' => 'terminos-y-condiciones'
        ]);

        LegalText::create([
            'type' => 'Shipment',
            'title' => 'Política de Envíos',
            'slug' => 'politica-de-envios'
        ]);

    }
}
