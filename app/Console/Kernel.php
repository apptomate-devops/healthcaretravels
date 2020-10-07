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
    protected $commands = [];

    public $timezone = 'America/New_York';

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminder:verification')->timezone($this->timezone)->dailyAt('10:00');
        $schedule->command('cron:log-check')->everyThirtyMinutes();
        $schedule->command('dwolla:refresh_access_token')->everyThirtyMinutes();
        $schedule->command(\Jorijn\LaravelSecurityChecker\Console\SecurityMailCommand::class)->weekly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
