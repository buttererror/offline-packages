<?php

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
        $this->call(CountriesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
