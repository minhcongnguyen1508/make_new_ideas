<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    // $title = $faker->sentence($nbWords = 6, $variableNbWords = true);
    $title = ucwords($faker->catchPhrase .' '.$faker->bs);

    return [
        'category_id' => Category::all()->random()->id,
        'user_id' => Role::where('name', 'writer')->first()->users->random()->id,
        'title' => $title,
        'slug' => Str::slug($title, '-'),
        'content' => $faker->paragraph($nbSentences = 50, $variableNbSentences = true),
        'admin_id' => Role::where('name', 'admin')->first()->users->random()->id,
        'status' => 3,
        'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
    ];
});
