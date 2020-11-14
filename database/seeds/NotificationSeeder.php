<?php

use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new DateTime();
        DB::table('notifications')->insert([
            'id' => 1,
            'type' => "App\Notifications\TestNotification",
            'notifiable_type' => '\App\Models\User',
            'notifiable_id' => 1,
            'data'=> json_encode(['title'=>'Test','content'=>"ahihi"]),
            'read_at'=> null,
            'created_at' => date("Y-m-d H:i:s", $date->getTimestamp()),
            'updated_at' => date("Y-m-d H:i:s", $date->getTimestamp()),
        ]);
    }
}
