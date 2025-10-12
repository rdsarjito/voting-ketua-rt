<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VotingResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public $results
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hasil Voting Ketua RT/RW',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.voting-results',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
