<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Support\Facades\DB;

class WriterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $writer_role_id = DB::table('roles')->where('name', 'writer')->first()->id;
        factory(User::class, 5)->create(['role_id' => $writer_role_id])->each(function ($writer) {
            $writer->writerRequest()->save(factory(Writer::class)->make());
        });
    }
}
