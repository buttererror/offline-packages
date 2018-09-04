<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {

        return [
            'name' => $faker->name,
            'email' => rand(1,2) == 1 ? $faker->unique()->safeEmail: null,
            'mobile' => $faker->phoneNumber,
            'country_id' => rand(1,100),
            'gender' => $faker->randomElement(['male','female']),
            'address'=>$faker->address,
            'passport_no'=>$faker->name,
            'age'=>rand(20,80),
        ];
});
