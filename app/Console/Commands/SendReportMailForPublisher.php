<?php

namespace App\Console\Commands;

use App\Events\PublisherReportEvent;
use App\Models\Report;
use Illuminate\Console\Command;

class SendReportMailForPublisher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secretary:send-report-mail-for-publisher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending report mail for publishers with status WAITING.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reports = Report::where('email_status', 'WAITING')->get();

        foreach ($reports as $report) {
            event(new PublisherReportEvent($report));
        }
    }
}
