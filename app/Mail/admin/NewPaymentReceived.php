<?php

namespace App\Mail\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPaymentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $reference, $email, $payment_method, $total_price, $created_at;
    public function __construct($reference, $email, $payment_method, $total_price, $created_at)
    {
        $this->reference = $reference;
        $this->email = $email;
        $this->payment_method = $payment_method;
        $this->total_price = $total_price;
        $this->created_at = $created_at;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Payment Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.admin.newpaymentreceived',
            with: [
                'url' => route('admin.payments')
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
