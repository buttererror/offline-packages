<?php

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       DB::unprepared(file_get_contents('app/seeds/packages.sql'));
       DB::unprepared(file_get_contents('app/seeds/package_accommodations.sql'));
        factory(\App\Package::class,100)->create();
        factory(\App\PackageAccommodation::class,100)->create();

    }
}
