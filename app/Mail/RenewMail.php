<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RenewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $header_image;
    public $footer_image;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->header_image = URL::asset('img/OjolieGoldFoilLogohandlettered_cards.png');
        $this->footer_image = URL::asset('img/link_mail.png');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.renew');
    }
}
