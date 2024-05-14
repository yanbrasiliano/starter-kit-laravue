<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDeletionNotification extends Mailable
{
  use Queueable, SerializesModels;

  public $user;

  public $reason;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $reason)
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
