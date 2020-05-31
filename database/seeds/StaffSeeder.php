<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 4; $i++){
            DB::table('staffs')->insert([
                'user_id' => $i,
                'position' => 'Website masta'
            ]);
        }
    }
}
