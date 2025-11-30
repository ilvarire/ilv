<?php

namespace App\Mail\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $timestamp, $ip, $agent, $name;
    public function __construct($timestamp, $ip, $agent, $name)
    {
        $this->timestamp = $timestamp;
        $this->ip = $ip;
        $this->name = str($name)->title();
        $this->agent = $agent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Changed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user.password-changed',
            with: [
                'timestamp' => $this->timestamp,
                'name' => $this->name,
                'ip' => $this->ip,
                'agent' => $this->agent,
                'url' => route('profile')
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
