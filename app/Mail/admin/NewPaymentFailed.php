<?php

namespace App\Mail\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public $reference, $name, $payment_method, $total_price, $email;
    public function __construct($reference, $name, $payment_method, $total_price, $email)
    {
        $this->reference = $reference;
        $this->name = $name;
        $this->payment_method = $payment_method;
        $this->total_price = $total_price;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Payment Failed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.admin.newpaymentfailed',
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
