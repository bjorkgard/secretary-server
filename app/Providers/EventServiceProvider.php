<?php

namespace App\Providers;

use App\Events\PublisherReportEvent;
use App\Events\ServiceGroupReportsEvent;
use App\Listeners\MarkReportMailProcessing;
use App\Listeners\MarkReportMailSent;
use App\Listeners\MarkServiceGroupMailProcessing;
use App\Listeners\MarkServiceGroupMailSent;
use App\Listeners\SendPublisherReport;
use App\Listeners\SendServiceGroupReport;
use App\Listeners\SendServiceGroupReportAssistant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ServiceGroupReportsEvent::class => [
            MarkServiceGroupMailProcessing::class,
            SendServiceGroupReport::class,
            SendServiceGroupReportAssistant::class,
            MarkServiceGroupMailSent::class,
        ],
        PublisherReportEvent::class => [
            MarkReportMailProcessing::class,
            SendPublisherReport::class,
            MarkReportMailSent::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
