<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EcardsentRecipient;
use Illuminate\Support\Carbon;
use App\Jobs\SendCard;
use Illuminate\Support\Facades\Mail;
use App\Mail\CardSendMail;

class SendCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find cards from database scheduled to send at certain time.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $from = Carbon::now()->format('Y-m-d H:i:s');
        $to = Carbon::now()->addMinutes(20)->format('Y-m-d H:i:s');

        $ecardsentrecipients = EcardsentRecipient::whereNull('sent_date')
        ->where('sent_queued',0)
        ->whereHas('ecardsentitem',function($query)use($from,$to){
            $query->where('scheduled_date','>=',$from);
            $query->where('scheduled_date','<=',$to);
            $query->where('draft',0);
        })->get();

        foreach($ecardsentrecipients as $recipient)
        {
            Mail::to($recipient->email)
                ->later(Carbon::parse($recipient->ecardsentitem->scheduled_date, $recipient->ecardsentitem->timezone), new CardSendMail($recipient));

            $recipient->sent_queued = 1;
            $recipient->save();
        }
    }
}
