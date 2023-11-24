<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('telescope:prune')->daily()->environments(['local']);
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('app:send-report-mail-for-service-group')->environments(['local'])->everyTwoMinutes();
        $schedule->command('app:send-report-mail-for-publisher')->environments(['local'])->everyMinute();

        $schedule->command('app:send-report-mail-for-service-group')->environments(['stage'])->everyTenMinutes()->thenPing('http://beats.envoyer.io/heartbeat/TETDSUJhD628m9h');
        $schedule->command('app:send-report-mail-for-publisher')->environments(['stage'])->everyFiveMinutes();

        $schedule->command('app:delete-old-reports')->monthlyOn(27);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
