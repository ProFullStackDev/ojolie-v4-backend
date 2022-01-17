<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class FreeMemberActivateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activate_link;
    public $header_image;
    public $footer_image;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->activate_link = route('member.activate',encrypt($user->id));
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
        return $this->view('emails.freememberactivate');
    }
}
