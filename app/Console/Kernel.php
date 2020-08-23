<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Delete temporary files in defined directories
            // Students' temp files
            Storage::disk('private')->deleteDirectory('students/temp/pictures');
            Storage::disk('private')->makeDirectory('students/temp/pictures');
            Storage::disk('private')->deleteDirectory('students/temp/ids');
            Storage::disk('private')->makeDirectory('students/temp/ids');
            Storage::disk('private')->deleteDirectory('students/temp/national_ids');
            Storage::disk('private')->makeDirectory('students/temp/national_ids');
        })->daily();

        $schedule->call(function(){
            Storage::disk('private')->deleteDirectory('staffs/temp');
            Storage::disk('private')->makeDirectory('staffs/temp');
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
