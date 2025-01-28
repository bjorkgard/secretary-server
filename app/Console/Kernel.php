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
        $schedule->command('model:prune')->daily();

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run --only-db')->daily()->at('01:30');

        $schedule->command('secretary:send-report-mail-for-service-group')->everyTenMinutes()->thenPing('http://beats.envoyer.io/heartbeat/TETDSUJhD628m9h');
        $schedule->command('secretary:send-report-mail-for-publisher')->everyFiveMinutes();

        $schedule->command('secretary:send-reminder')->monthlyOn(12);

        $schedule->command('secretary:delete-old-reports')->monthlyOn(27);
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
