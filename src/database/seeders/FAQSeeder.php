<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\FAQ;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      FAQ::create([
            'question' => '¿Tienen Devoluciones?',
            'title' => 'Si contamos con devoluciones.'
        ]);

    }
}
