<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $count = config('constants.default.seeder_count');

        User::factory($count)->create();
    }
}
