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
        factory(\App\Client::class,300)->create();
        factory(\App\City::class,100)->create();

        \App\User::insert([
            'name'=>'super',
            'email'=>'super@syal.com',
            'password'=>bcrypt('123456')
        ]);
    }
}
