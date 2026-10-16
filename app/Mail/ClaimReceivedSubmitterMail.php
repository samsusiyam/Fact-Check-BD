<?php

namespace App\Mail;

use App\Models\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClaimReceivedSubmitterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Claim $claim)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[FactCheck BD] আপনার পাঠানো তথ্য/ক্লেইমটি সফলভাবে জমা হয়েছে (#' . $this->claim->id . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.claim-received-submitter',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
