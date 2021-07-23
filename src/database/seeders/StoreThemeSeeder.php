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
            'description' => 'Plantilla Inicial para cualquier excelente plataforma de e-commerce',
            'is_active' => true,
            'version' => '1.0.0'
        ]);
    }
}
