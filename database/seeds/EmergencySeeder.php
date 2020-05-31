<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmergencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 2; $i++)
        DB::table('emergencies')->insert([
            'csa_form_id' => $i,
            'gender' => 'F',
            'name' => 'Student_1\'s mom',
            'address' => 'somewhere street',
            'mobile' => '8120000000123',
            'telp_num' => '21012345678987',
            'email' => 'mom@mail.com'
        ]);
    }
}
