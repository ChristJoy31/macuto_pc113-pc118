<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendUserSetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $setPasswordUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $setPasswordUrl)
    {
        $this->user = $user;
        $this->setPasswordUrl = $setPasswordUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Set Your Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.set-password',  // Blade view (see below)
            with: [
                'user' => $this->user,
                'setPasswordUrl' => $this->setPasswordUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
