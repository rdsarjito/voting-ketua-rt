<?php

namespace App\Mail;

use App\Models\Category;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VotingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Category $category
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Voting: ' . $this->category->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.voting-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
