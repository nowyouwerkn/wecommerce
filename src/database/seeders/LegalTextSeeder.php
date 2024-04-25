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
            'title' => 'Cambios y Devoluciones',
            'slug' => 'cambios-y-devoluciones',
            'description' => 'Lorem Ipsum'
        ]);

        LegalText::create([
            'title' => 'Aviso de Privacidad',
            'slug' => 'aviso-de-privacidad',
            'description' => 'Lorem Ipsum'
        ]);

        LegalText::create([
            'title' => 'Términos y Condiciones',
            'slug' => 'terminos-y-condiciones',
            'description' => 'Lorem Ipsum'
        ]);

        LegalText::create([
            'title' => 'Política de Envíos',
            'slug' => 'politica-de-envios',
            'description' => 'Lorem Ipsum'
        ]);
    }
}
