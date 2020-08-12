<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Yearly_StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('yearly_students')->insert([
            'nim'=> '2101000001',
            'academic_year_id' => 7,
            'is_nominated' => false
        ]);
        for($i = 4; $i < 10; $i++){
            DB::table('yearly_students')->insert([
                'nim'=> '210100000' . ($i-3),
                'academic_year_id' => 8,
                'is_nominated' => $i > 4 ? false : true
            ]);
        }
    }
}
