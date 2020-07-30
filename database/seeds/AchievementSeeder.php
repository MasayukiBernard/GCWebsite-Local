<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeToChange = false;
        $j = 1;
        for($i = 1; $i <= 4; $i++){
            if($timeToChange){
                $j = 2;
            }
            DB::table('achievements')->insert([
                'csa_form_id' => $j,
                'achievement' => 'Dummy achievement #'. $i,
                'year' => 2017 + $j,
                'institution' => 'Dummy Institution',
                'other_details' => 'other detailed infos',
                'proof_path' => 'students/achievements/dummy_certificate.jpg'
            ]);
            if($i == 2){
                $timeToChange = true;
            }
        }
    }
}
