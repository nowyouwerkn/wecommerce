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
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\PermissionsSeeder::class);
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\RolesSeeder::class);
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\UserSeeder::class);

        $this->call(Nowyouwerkn\WeCommerce\database\seeders\CurrencySeeder::class);
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\CountriesSeeder::class);
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\PaymentMethodSeeder::class);
        $this->call(Nowyouwerkn\WeCommerce\database\seeders\LegalTextSeeder::class);
    }
}
