<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CurrencySeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(LegalTextSeeder::class);
        $this->call(MailConfigSeeder::class);
    }
}
