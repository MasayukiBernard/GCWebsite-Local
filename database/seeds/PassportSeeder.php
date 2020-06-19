<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 2; $i++){
            DB::table('passports')->insert([
                'csa_form_id' => $i,
                'pass_num' => 'X000000',
                'pass_expiry' => '2016-01-16',
                'pass_proof_path' => 'students\passports\dummy_passport.jpeg',
            ]);
        }
    }
}
