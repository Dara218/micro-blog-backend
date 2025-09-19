<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate the table to prevent duplication
        Notification::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $count = config('constants.default.seeder_count') * 5; // Many notifications

        Notification::factory($count)->create();
    }
}
