<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportResponse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Report $report)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $explodedName = explode(', ', $this->report->publisher_name);
        return new Envelope(
            subject: __('emails.reports.reportResponse', ['month' => $this->report->name, 'name' => $explodedName[1] . ' ' . $explodedName[0]]),
            tags: ['report', 'publisher'],
            metadata: ['service_group_identifier' => $this->report->identifier],
            replyTo: [
                new Address($this->report->publisher_email,$this->report->publisher_name)
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $explodedName = explode(', ', $this->report->publisher_name);

        return new Content(
            markdown: 'emails.reports.response',
            with: [
                'name' => $explodedName[1] . ' ' . $explodedName[0],
                'report' => $this->report,
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
