<?php

namespace App\Listeners;

use App\Events\ServiceGroupReminderEvent;
use App\Mail\ReportReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendServiceGroupReminder
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
    public function handle(ServiceGroupReminderEvent $event): void
    {
        $message = (new ReportReminder($event->serviceGroup))->onQueue('emails');

        if($event->serviceGroup->responsible_email || $event->serviceGroup->assistant_email){
            $to = [];

            if($event->serviceGroup->receivers === 'RESPONSIBLE' || $event->serviceGroup->receivers === 'BOTH'){
                if($event->serviceGroup->responsible_email){
                    $to[] = ['email' => $event->serviceGroup->responsible_email];
                }
            }

            if($event->serviceGroup->receivers === 'ASSISTANT' || $event->serviceGroup->receivers === 'BOTH'){
                if($event->serviceGroup->assistant_email){
                    $to[] = ['email' => $event->serviceGroup->assistant_email];
                }
            }

            if(count($to) > 0){
                Mail::to($to)->locale($event->serviceGroup->locale)->queue($message);
            }
        }
    }
}
