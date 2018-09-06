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
        DB::table('users')->insert(['name'=>'super',
            'email'=>'super@syal.com',
            'password'=>bcrypt('123456')
        ]);
        $this->call(CountriesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
    }
}
