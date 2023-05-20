<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
    * The Artisan commands provided by your application.
    *
    * @var array
    */
    protected $commands = [
        Commands\AutoJournalResearchesPublishing::class,
        Commands\FilterResearches::class,
        Commands\LaunchEmailCampaign::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('researches:publish')
        // ->everyMinute();
        // $schedule->command('researches:filter')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('launch:campaign')->everyFiveMinutes()->withoutOverlapping();
        // $schedule->command('queue:work')
        // ->name('queue_work')
        // ->withoutOverlapping()
        // ->everyFiveMinutes();

        // $schedule->command('queue:work --stop-when-empty')
        // ->everyMinute()
        // ->withoutOverlapping();
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
