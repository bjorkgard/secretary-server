<?php

namespace App\Listeners;

use App\Events\ServiceGroupReportsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkServiceGroupMailProcessing implements ShouldQueue
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
    public function handle(ServiceGroupReportsEvent $event): void
    {
        $event->serviceGroup->update(['email_status' => 'PROCESSING']);
    }
}
