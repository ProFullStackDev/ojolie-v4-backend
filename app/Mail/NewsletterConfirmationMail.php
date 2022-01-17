<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailing;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->subject('Ojolie Newsletter Confirmation')
            ->view('emails.newsletter-confirmation');
    }
}
