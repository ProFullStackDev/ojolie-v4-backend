<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class MailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(isset($event->data['ecardsentrecipient']))
        {
            $ecardsentrecipient = $event->data['ecardsentrecipient'];
            $ecardsentrecipient->sent_date = date('Y-m-d H:i:s');
            $ecardsentrecipient->save();
        }

        if(isset($event->data['member']))
        {
            $member = $event->data['member'];
            $member->notice_expires += 1;
            $member->save();
        }
    }
}
