<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Academic_YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now_odd = true;
        for($year = 2020; $year < 2024;){
            DB::table('academic_years')->insert([
                'starting_year' => $year,
                'ending_year' => $year+1,
                'odd_semester' => $now_odd
            ]);
            if($now_odd){
                $now_odd = false;
            }
            else{
                $now_odd = true;
                $year++;
            }
        }
    }
}
