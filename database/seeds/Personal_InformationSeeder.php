<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Personal_InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 2; $i++)
        DB::table('personal_information')->insert([
            'csa_form_id' => $i,
            'name' => 'Student1',
            'nim' => '210100000' . $i-3,
            'picture_path' => 'students\pictures\Dummy_PP.png',
            'gender' => 'Male',
            'place_birth' => 'somewhere over the rainbow',
            'date_birth' => date('Y-m-d', mt_rand(915148800, 1586476800)),
            'nationality' => 'Indonesian',
            'email' => 'student1@gmail.com',
            'mobile' => '8120000000123',
            'telp_num' => '21012345678987',
            'address' => 'BINUS Street',
            'flazz_card_picture_path' => 'students\ids\dummy_flazz.jpg',
            'id_card_picture_path' => 'students\national_ids\dummy_e-ktp.jpg', 
        ]);
    }
}
