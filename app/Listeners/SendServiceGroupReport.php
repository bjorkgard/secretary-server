<?php

namespace App\Listeners;

use App\Events\ServiceGroupReportsEvent;
use App\Mail\ServiceGroupReports;
use Illuminate\Support\Facades\Mail;

class SendServiceGroupReport
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

        if($event->serviceGroup->receivers === 'RESPONSIBLE' || $event->serviceGroup->receivers === 'BOTH'){
            if ($event->serviceGroup->responsible_email) {
                Mail::to($event->serviceGroup->responsible_email)->locale($event->serviceGroup->locale)->queue($message);
            }
        }
    }
}
