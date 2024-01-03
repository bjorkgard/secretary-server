<?php

namespace App\Console\Commands;

use App\Events\ServiceGroupReportsEvent;
use App\Models\ServiceGroup;
use Illuminate\Console\Command;

class SendReportMailForServiceGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secretary:send-report-mail-for-service-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending report mail for service groups with status WAITING.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceGroups = ServiceGroup::where('email_status', 'WAITING')->get();

        foreach ($serviceGroups as $serviceGroup) {
            event(new ServiceGroupReportsEvent($serviceGroup));
        }
    }
}
