<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // MajorSeeder::class,
            // PartnerSeeder::class,
            // Academic_YearSeeder::class,
            // Yearly_PartnerSeeder::class,
            UserSeeder::class,
            StaffSeeder::class,
            // StudentSeeder::class,
            // Yearly_StudentSeeder::class,
            // CSA_FormSeeder::class,
            // AchievementSeeder::class,
            // English_TestSeeder::class,
            // Academic_InfoSeeder::class,
            // PassportSeeder::class,
            // EmergencySeeder::class,
            // ConditionSeeder::class,
            // ChoiceSeeder::class,
        ]);
    }
}
