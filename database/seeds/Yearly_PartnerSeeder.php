<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Yearly_PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 0;
        for($i = 7; $i <= 8;){
            DB::table('yearly_partners')->insert([
                'academic_year_id' => $i,
                'partner_id' => ++$j,
            ]);
            if($j == 6){
                $i++;
                $j = 0;
            }
        }
    }
}
