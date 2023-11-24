<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class PublisherReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Report $report)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.reports.publisherSubject', ['month' => __('month.' . $this->report->name)]),
            tags: ['report', 'publisher'],
            metadata: ['service_group_identifier' => $this->report->identifier],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $explodedName = explode(', ', $this->report->publisher_name);
        return new Content(
            markdown: 'emails.reports.publisher',
            with: [
                'url' => URL::temporarySignedRoute(
                    'publisher-report',
                    now()->addDays(20),
                    ['locale' => $this->report->locale, 'report' => $this->report->identifier]
                ),
                'name' => $explodedName[1] . ' ' . $explodedName[0],
                'month' => __('month.' . $this->report->name),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
