<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Company;
use App\Models\Emploee;
use Faker\Generator as Faker;

$factory->define(Emploee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'company_id' => function() {
            return factory(Company::class)->create()->id;
        },
        'email' => $faker->email,
        'phone' => $faker->phoneNumber
    ];
});
