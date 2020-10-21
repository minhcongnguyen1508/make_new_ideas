<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker, $role_id) {
    return [
        'username' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'role_id' => $role_id,
    ];
});
