<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{


    public function run()
    {
        factory(\App\City::class,100)->create();

    }
}
