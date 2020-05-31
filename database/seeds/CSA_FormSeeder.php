<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CSA_FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('csa_forms')->insert([
            'yearly_student_id' => 1,
            'is_submitted' => true
        ]);
        for($i = 2; $i <= 7; $i++){
            DB::table('csa_forms')->insert([
                'yearly_student_id' => $i,
                'is_submitted' => $i > 2 ? false : true
            ]);
        }
    }
}
