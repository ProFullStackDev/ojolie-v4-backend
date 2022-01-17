<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\EcardsentRecipient;

class CardSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ecardsentrecipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EcardsentRecipient $ecardsentrecipient)
    {
        $this->ecardsentrecipient = $ecardsentrecipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.cardsend');
    }
}
