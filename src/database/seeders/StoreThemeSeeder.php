<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\StoreTheme; 

class StoreThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreTheme::create([
            'name' => 'werkn-backbone',
            'description' => 'Apariencia inicial para cualquier excelente plataforma de e-commerce usando wecommerce',
            'image' => 'werkn-backbone.jpg',
            'is_active' => true,
            'version' => '2.1'
        ]);

        StoreTheme::create([
            'name' => 'werkn-backbone-bootstrap',
            'description' => 'Apariencia inicial para cualquier excelente plataforma de e-commerce usando wecommerce, basado exlusivamente en Bootstrp',
            'image' => 'werkn-backbone-bootstrap.jpg',
            'is_active' => false,
            'version' => '1.0'
        ]);
    }
}
