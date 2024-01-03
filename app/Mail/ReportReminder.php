<?php

namespace App\Mail;

use App\Models\ServiceGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ReportReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ServiceGroup $serviceGroup)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.reports.serviceGroupReminder', ['serviceGroup' => $this->serviceGroup->name]),
            tags: ['report', 'service group'],
            metadata: ['service_group_identifier' => $this->serviceGroup->service_group_identifier],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reports.reminder',
            with: [
                'url' => URL::temporarySignedRoute('service-group-reports', now()->addDays(9), ['locale' => $this->serviceGroup->locale, 'serviceGroup' => $this->serviceGroup->service_group_identifier]),
                'name' => $this->serviceGroup->name,
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
