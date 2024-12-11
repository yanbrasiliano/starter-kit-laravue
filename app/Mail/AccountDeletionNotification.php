<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDeletionNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public User $user;

    /**
     * @var string
     */
    public string $reason;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $reason
     */
    public function __construct(User $user, string $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account deletion in the SP 1.0 System')
            ->view('emails.accountDeletion');
    }
}
