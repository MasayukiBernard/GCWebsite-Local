<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class English_TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ['TOEFL', 'IELTS'];
        $score = [104.0, 8.5];
        $date = ['2019-12-12', '2020-01-01'];
        $path = ['TOEFL/dummy_toefl.jpg', 'IELTS/dummy_ielts.jpg'];
        for($i = 1; $i <= 2; $i++){
            DB::table('english_tests')->insert([
                'csa_form_id' => $i,
                'test_type' => $type[$i-1],
                'score' => $score[$i-1],
                'test_date' => $date[$i-1],
                'proof_path' => 'students\english_tests\\' . $path[$i-1]
            ]);
        }
    }
}
