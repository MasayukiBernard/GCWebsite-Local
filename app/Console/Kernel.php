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
            Storage::disk('private')->deleteDirectory('student/temp/pictures');
            Storage::disk('private')->makeDirectory('student/temp/pictures');
            Storage::disk('private')->deleteDirectory('student/temp/ids');
            Storage::disk('private')->makeDirectory('student/temp/ids');
            Storage::disk('private')->deleteDirectory('student/temp/national_ids');
            Storage::disk('private')->makeDirectory('student/temp/national_ids');
        })->daily();
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
