<?php

namespace Database\Seeders;

use App\Models\UserBlock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBlockSeeder extends Seeder
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
        UserBlock::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $count = config('constants.default.seeder_count') / 2; // Fewer blocks

        UserBlock::factory($count)->create();
    }
}
