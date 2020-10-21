<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['user', 'writer', 'admin'];

        foreach ($roles as $role) {
            if (!DB::table('roles')->where('name', $role)->first()) {
                DB::table('roles')->insert(['name' => $role]);
            }
        }
    }
}
