<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *x
     * @return void
     */
    public function run()
    {
        $j = 1;
        for($i = 4; $i < 10; $i++){
            if($j == 4){
                $j = 1;
            }
            DB::table('students')->insert([
                'nim' => '210100000' . $i-3,
                'user_id' => $i,
                'major_id' => $j++,
                'place_birth' => 'somewhere over the rainbow',
                'date_birth' => date('Y-m-d', mt_rand(915148800, 1586476800)),
                'nationality' => 'Indonesian',
                'address' =>'BINUS Street',
                'picture_path' => '/non-public/students/pictures/Dummy_PP.png',
                'id_card_picture_path' => '/non-public/students/ids/dummy_flazz.jpg',
                'flazz_card_picture_path' => '/non-public/students/national_ids/dummy_e-ktp.jpg',
                'binusian_year' => 2021,
            ]);
        }
    }
}
