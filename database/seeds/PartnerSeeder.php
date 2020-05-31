<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 1;
        for($i = 1; $i < 7; $i++){
            if($j==4){
                $j = 1;
            }
            DB::table('partners')->insert([
                'major_id' => $j,
                'name' => 'Partner Uni ' . $i,
                'location' => 'unknown Country',
                'short_detail' => 'will be filled later',
                'min_gpa' => 3.0,
                'eng_requirement' => 'TOEFL: 90 / IELTS: 6.5'
            ]);
            $j++;
        }
    }
}
