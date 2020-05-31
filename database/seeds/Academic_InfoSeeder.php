<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Academic_InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semester = [3, 5];
        for($i = 1; $i <= 2; $i++){
            DB::table('academic_infos')->insert([
                'csa_form_id' => $i,
                'major_id' => 1,
                'campus' => 'Alam Sutera',
                'study_level' => 'U',
                'class' => 'Global Class',
                'semester' => $semester[$i-1],
                'gpa' => 2.25,
                'gpa_proof_path' => '/non-public/students/gpa_transcripts/dummy_gpa.png'
            ]);
        }
    }
}
