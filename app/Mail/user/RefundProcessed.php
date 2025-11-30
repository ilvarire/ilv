<?php

namespace App\Mail\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefundProcessed extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $reference, $total_price, $payment_method;
    public function __construct($name, $reference, $total_price, $payment_method)
    {
        $this->name = $name;
        $this->reference = $reference;
        $this->$total_price = $total_price;
        $this->$payment_method = $payment_method;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Refund Processed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user.refundprocessed',
            with: [
                'url' => route('payment.details', $this->reference)
            ]
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
