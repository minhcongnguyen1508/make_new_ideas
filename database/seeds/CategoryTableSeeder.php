<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'sport',
            'entertainment',
            'tech',
            'game',
            'film',
            'business',
            'politics',
            'person',
            'country',
            'company',
            'buiding',
            'book',
            'person'
        ];

        foreach ($categories as $category) {
            if (!DB::table('categories')->where('name', $category)->first()) {
                DB::table('categories')->insert([
                    'name' => $category,
                    'slug' => Str::slug($category, '-'),
                ]);
            }
        }
    }
}
