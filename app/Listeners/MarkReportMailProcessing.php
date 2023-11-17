<?php

namespace App\Listeners;

use App\Events\PublisherReportEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkReportMailProcessing implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'db';

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
        $event->report->update(['email_status' => 'PROCESSING']);
    }
}
