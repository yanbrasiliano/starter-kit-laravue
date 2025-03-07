<?php

declare(strict_types = 1);

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\{Config, URL};

class SendVerifyEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmação de cadastro',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): mixed
    {
        return $this->markdown('emails.sendVerifyEmail', [
            'user' => $this->user,
            'link' => $this->getUrl(),
        ]);
    }

    /**
     * Get the verification URL for the email.
     *
     * @return string
     */
    public function getUrl(): string
    {
        $url = URL::temporarySignedRoute(
            'users.verify',
            Carbon::now()->addHours(Config::get('auth.verification.expire', 48)),
            [
                'id' => $this->user->getKey(),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );

        return str_replace('api/v1/users/verify', 'verificar-email', $url);
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
