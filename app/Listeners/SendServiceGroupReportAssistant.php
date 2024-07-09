<?php

namespace App\Listeners;

use App\Events\ServiceGroupReportsEvent;
use App\Mail\ServiceGroupReports;
use Illuminate\Support\Facades\Mail;

class SendServiceGroupReportAssistant
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
    public function handle(ServiceGroupReportsEvent $event): void
    {
        $message = (new ServiceGroupReports($event->serviceGroup))->onQueue('emails');

        if($event->serviceGroup->receivers === 'ASSISTANT' || $event->serviceGroup->receivers === 'BOTH'){
            if ($event->serviceGroup->assistant_email) {
                Mail::to($event->serviceGroup->assistant_email)->locale($event->serviceGroup->locale)->queue($message);
            }
        }
    }
}
