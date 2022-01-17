<?php

namespace App\Console\Commands;

use App\Mail\NotifyExpiryMail;
use Illuminate\Console\Command;
use App\Member;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class NotifyExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'notify:expiry';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Sends Expiry Notice.';

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
        $expiry_date_45 = Carbon::now()->addDays(45)->format('Y-m-d');
        $expiry_date_30 = Carbon::now()->addDays(30)->format('Y-m-d');
        $expiry_date_15 = Carbon::now()->addDays(15)->format('Y-m-d');
        $expiry_date_0 = Carbon::now()->format('Y-m-d');

        $members_45 = Member::whereDate('expires_at','<=',$expiry_date_45)->where('notice_expires',0)->get();
        foreach($members_45 as $member)
        {
            Mail::to($member->user->email)
            ->queue(new NotifyExpiryMail($member));
        }

        $members_30 = Member::whereDate('expires_at','<=',$expiry_date_30)->where('notice_expires',1)->get();
        foreach($members_30 as $member)
        {
            Mail::to($member->user->email)
            ->queue(new NotifyExpiryMail($member));
        }

        $members_15 = Member::whereDate('expires_at','<=',$expiry_date_15)->where('notice_expires',2)->get();
        foreach($members_15 as $member)
        {
            Mail::to($member->user->email)
            ->queue(new NotifyExpiryMail($member));
        }

        $members_0 = Member::whereDate('expires_at','=>',$expiry_date_0)->where('notice_expires',2)->get();
        foreach($members_0 as $member)
        {
            $member->notice_expires = 0;
            $member->type = 0;
            $member->save();
            $member->user->active = 3;
            $member->user->save();
        }

    }
}
