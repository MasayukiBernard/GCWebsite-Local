<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 1;
        for($i = 1; $i <= 2;){
            DB::table('choices')->insert([
                'csa_form_id' => $i,
                'yearly_partner_id' => $j,
                'motivation' => 'because, I feel like it.',
                'nominated_to_this' => $j == 6 ? true : false,
            ]);
            $j++;
            if($j%4 == 0 || $j%7 == 0){
                $i++;
            }
        }
    }
}
