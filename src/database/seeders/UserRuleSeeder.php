<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\UserRule;

class UserRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      UserRule::create([
            'type' => 'Cupon de registro',
            'value' => '20'
            'is_active' => false
        ]);
    }
}