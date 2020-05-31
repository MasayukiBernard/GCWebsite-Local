<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $majorList = ['Computer Science', 'International Relationship', 'International Business Management'];
        for($i = 0; $i < 3 ; $i++){
            DB::table('majors')->insert([
                'name' => $majorList[$i]
            ]);
        }
    }
}
