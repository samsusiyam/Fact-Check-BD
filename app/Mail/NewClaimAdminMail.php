<?php

namespace App\Mail;

use App\Models\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewClaimAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Claim $claim)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[FactCheck BD] নতুন ক্লেইম ভেরিফিকেশন রিকোয়েস্ট (#' . $this->claim->id . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-claim-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
