<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boolValue = [true, false];
        for($i = 1; $i <= 2; $i++){
            DB::table('conditions')->insert([
                'csa_form_id' => $i,
                'med_condition' => $boolValue[$i-1],
                'allergy' => $boolValue[$i-1],
                'special_diet' => $boolValue[$i-1],
                'convicted_crime' => false,
                'future_diffs' => $boolValue[$i-1],
                'reasons' => 'Some reasons'
            ]);
        }
    }
}
