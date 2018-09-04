<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
        'name'=>$faker->city,
    'code'=>$faker->postcode,
    'top_destination'=>$faker->boolean,
    'country_id'=>rand(1,100),
    ];
});
