<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public BcOtpCode $otp ,
        public ?string $subjectLine
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $organization = $this->otp->organization;

        return new Envelope(
            from: new Address(
                    address : $organization->email ?? env('MAIL_FROM_ADDRESS'),
                    name : $organization->slug ??  env('MAIL_FROM_NAME')
                 ),
            subject: $this->subjectLine ?? 'Otp Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.otp.code',
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
