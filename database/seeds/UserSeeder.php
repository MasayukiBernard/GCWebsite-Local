<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genderChoice = ['M', 'F'];
        $names = ['Staff', 'Student'];
        for($i = 0; $i < 9; $i++){
            DB::table('users')->insert([
                'is_staff' => $i <= 2 ? true : false,
                'password' => Hash::make('?password'),
                'name' => $i < 3 ? $names[0] . ' ' .  ($i+1) : $names[1] . ' ' .  ($i-2),
                'gender' => $genderChoice[$i == 3 ? 0 : 1],
                'email' => $names[$i < 3 ? 0 : 1]. ($i < 3 ? $i+1 : $i-2) .'@mail.com',
                'mobile' => '8'.mt_rand(0,9).mt_rand(0,9).'9999999999',
                'telp_num' => mt_rand(0,9).mt_rand(0,9).'123123123123',
            ]);
        }
    }
}
