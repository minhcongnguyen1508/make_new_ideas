<?php

use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\User;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = DB::table('posts')->limit(4)->get();
        foreach ($posts as $key => $value) {
            Like::create([
                'user_id' => User::first()->id,
                'post_id' => $value->id
            ]);
        }
    }
}
