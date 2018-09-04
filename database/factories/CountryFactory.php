<?php

use Faker\Generator as Faker;

$factory->define(App\Country::class, function (Faker $faker) {
    return [
    'num_code'=>$faker->countryCode,
    'alpha_2_code'=>$faker->countryISOAlpha3,
    'alpha_3_code'=>$faker->countryISOAlpha3,
    'en_short_name'=>$faker->country,
    'nationality'=>$faker->country,
    ];
});
