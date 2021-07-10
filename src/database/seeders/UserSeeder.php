<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Webmaster",
            'email' => "webmaster@test.com",
            'password' => bcrypt('test12345'),
        ]);
        $user->assignRole('webmaster');

        $user = User::create([
            'name' => "Administrador",
            'email' => "admin@test.com",
            'password' => bcrypt('test12345'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => "Analista",
            'email' => "analista@test.com",
            'password' => bcrypt('test12345'),
        ]);
        $user->assignRole('analyst');

        $user = User::create([
            'name' => "Cliente",
            'email' => "cliente@test.com",
            'password' => bcrypt('test12345'),
        ]);
        $user->assignRole('customer');
    }
}
