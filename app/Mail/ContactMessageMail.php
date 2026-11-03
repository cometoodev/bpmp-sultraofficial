<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $contactData
     */
    public function __construct(public array $contactData) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Pesan Baru dari Website: '.($this->contactData['subject'] ?? 'Pesan Pengunjung');

        return new Envelope(
            subject: $subject,
            replyTo: [
                new Address($this->contactData['email'], $this->contactData['name'] ?? null),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'contactData' => $this->contactData,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
