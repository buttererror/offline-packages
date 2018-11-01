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
            'password'=>bcrypt('123456'),
            'role_id'=>2

        ]);

        DB::table('users')->insert(['name'=>'karim',
            'email'=>'karim@syal.com',
            'password'=>bcrypt('123456'),
            'role_id'=>1

        ]);
       DB::table('users')->insert(['name'=>'mohamed',
            'email'=>'mohamed@syal.com',
            'password'=>bcrypt('123456'),
           'role_id'=>1
        ]);

        DB::table('roles')->insert(['name'=>'employee']);
        DB::table('roles')->insert(['name'=>'operator']);
        DB::table('permissions')->insert(['name'=>'view own requests','role_id'=>1]);
        DB::table('permissions')->insert(['name'=>'view all requests','role_id'=>2]);
        DB::table('permissions')->insert(['name'=>'edit request status','role_id'=>2]);

        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
    }
}
