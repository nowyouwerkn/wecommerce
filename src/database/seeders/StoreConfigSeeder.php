<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\StoreConfig; 

class StoreConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreConfig::create([
            'install_completed' => true,
            'store_logo' => 'logo-store.png',
            'store_name' => 'WeCommerce Store',
            'unit_system' => 'Sistema Métrico',
            'weight_system' => 'Kilogramos (Kg)'
        ]);
    }
}
