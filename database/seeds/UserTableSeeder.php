<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role_id = DB::table('roles')->where('name', 'admin')->first()->id;
        DB::table('users')->insert([
            'username' => 'minhcong',
            'email' => 'sssnowkkol@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id' => $admin_role_id,
        ]);

        $user_role_id = DB::table('roles')->where('name', 'user')->first()->id;
        factory(User::class, 20)->create(['role_id' => $user_role_id]);

        $writer_role_id = DB::table('roles')->where('name', 'writer')->first()->id;
        factory(User::class, 5)->create(['role_id' => $writer_role_id])->each(function ($writer) {
            $writer->writerRequest()->save(factory(Writer::class)->make());
        });
    }
}
