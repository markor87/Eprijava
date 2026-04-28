<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public JobPosition $jobPosition,
        public ?Application $application = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Потврда пријаве на конкурс',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-submitted',
        );
    }
}
