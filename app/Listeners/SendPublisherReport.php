<?php

namespace App\Listeners;

use App\Events\PublisherReportEvent;
use App\Mail\PublisherReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPublisherReport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PublisherReportEvent $event): void
    {
        $message = (new PublisherReport($event->report))->onQueue('emails');

        if ($event->report->publisher_email) {
            Mail::to($event->report->publisher_email)->locale($event->report->locale)->queue($message);
        }
    }
}
