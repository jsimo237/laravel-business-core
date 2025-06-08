<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\OtpCode;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public OtpCode $otp ,
        public ?string $title,
        public ?array $fromAddress = [],
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from : new Address(
                    address : $this->fromAddress['email'] ?? env('MAIL_FROM_ADDRESS',"contact@kirago.org"),
                    name : $this->fromAddress['name'] ??  env('MAIL_FROM_NAME',"Kirago")
                 ),
            subject : $this->title ?? 'Otp Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'business-core::emails.otp.code',
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
