<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Validate reply-to email — if invalid, omit replyTo to avoid mailer exceptions
        $replyTo = [];

        if (!empty($this->contactData['email']) && filter_var($this->contactData['email'], FILTER_VALIDATE_EMAIL)) {
            $name = $this->contactData['name'] ?? null;
            $replyTo = [$this->contactData['email'] => $name];
        } else {
            // Log a warning for visibility — don't block email sending

            if (!empty($this->contactData['email'])) {
                \Illuminate\Support\Facades\Log::warning('Invalid reply-to email in contact submission: ' . $this->contactData['email']);
            }
        }

        return new Envelope(
            subject: 'New Contact Form Submission - ' . $this->contactData['subject'],
            replyTo: $replyTo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submission',
            with: [
                'contactData' => $this->contactData,
            ],
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
