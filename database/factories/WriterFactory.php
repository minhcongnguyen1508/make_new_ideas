<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Writer;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Writer::class, function (Faker $faker) {
    $admin_role_id = DB::table('roles')->where('name', 'writer')->first()->id;

    return [
        'admin_id' => $admin_role_id,
        'phone' => $faker->e164PhoneNumber,
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'salary' => $faker->numberBetween(
            $min = config('writer.salary_range')[0],
            $max = config('writer.salary_range')[1]
        ),
    ];
});
