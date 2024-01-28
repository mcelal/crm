<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreatedTenantAdminUserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected array $user;

    protected Tenant $tenant;

    /**
     * Create a new message instance.
     */
    public function __construct(array $payload)
    {
        $this->tenant = $payload['tenant'];

        $this->user = $payload['user'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Create Tenant Admin User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $link = implode('', [
            'https://',
            $this->tenant->id,
            'mcelal.dev',
        ]);

        return new Content(
            markdown: 'emails.tenant-admin-welcome-mail',
            with: [
                'url'  => $link,
                'user' => $this->user,
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
