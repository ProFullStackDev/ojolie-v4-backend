<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\EcardsentRecipient;

class PickupReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reply_email;

    public $sender_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reply_email, $sender_message)
    {
        $this->reply_email = $reply_email;

        $this->sender_message = $sender_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pickup-reply');
    }
}
