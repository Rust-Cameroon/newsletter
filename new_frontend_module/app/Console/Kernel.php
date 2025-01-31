<?php

namespace App\Console;

use App\Console\Commands\DisableInactiveUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use JoeDixon\Translation\Console\Commands\SynchroniseMissingTranslationKeys;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('disable:inactive_users')->daily();
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

    protected $commands = [
        SynchroniseMissingTranslationKeys::class,
        DisableInactiveUsers::class,
    ];
}
