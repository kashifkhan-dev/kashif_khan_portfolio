<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Message $inquiryMessage;
    public string $replyContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Message $inquiryMessage, string $replyContent)
    {
        $this->inquiryMessage = $inquiryMessage;
        $this->replyContent = $replyContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->inquiryMessage->subject ? 'Re: ' . $this->inquiryMessage->subject : 'Re: Portfolio Inquiry Response';

        $address = (string) (config('mail.from.address') ?? env('MAIL_FROM_ADDRESS') ?? 'kashifkhannee@gmail.com');
        $name = (string) (config('mail.from.name') ?? env('MAIL_FROM_NAME') ?? 'Kashif Khan');

        return new Envelope(
            subject: $subject,
            replyTo: [
                new Address($address, $name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-reply',
            with: [
                'senderName' => $this->inquiryMessage->sender_name,
                'replyContent' => $this->replyContent,
                'originalSubject' => $this->inquiryMessage->subject,
                'originalBody' => $this->inquiryMessage->body,
                'originalDate' => $this->inquiryMessage->created_at->format('M d, Y H:i'),
            ],
        );
    }
}
