<?php

namespace App\Listeners;

use App\Events\PublisherReportedEvent;
use App\Mail\ReportResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReportResponse
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
    public function handle(PublisherReportedEvent $event): void
    {
        $report = $event->report;
        $report->load('serviceGroup');

        if($report->serviceGroup->responsible_email || $report->serviceGroup->assistant_email){
            $message = (new ReportResponse($report))->onQueue('emails');

            $to = [];
            if($report->serviceGroup->responsible_email){
                $to[] = ['email' => $report->serviceGroup->responsible_email];
            }
            if($report->serviceGroup->assistant_email){
                $to[] = ['email' => $report->serviceGroup->assistant_email];
            }

            Mail::to($to)->locale($report->locale)->queue($message);
        }
    }
}
