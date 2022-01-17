<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcardsentItem extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ecard()
    {
        return $this->belongsTo('App\Ecard');
    }

    public function ecardsentrecipients()
    {
        return $this->hasMany('App\EcardsentRecipient', 'ecardsent_item_id');
    }

    public function scopeUserScope($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function userDeliveryStatus()
    {
        $total = $this->ecardsentrecipients()->count();

        $sent = $this->ecardsentrecipients()->whereNotNull('sent_date')->count();

        if ($this->draft) {
            $sent .= ' Draft';
        } else {
            if ($sent == $total) {
                $sent .= ' Sent';
            } else {
                $sent .= ' Pending';
            }
        }

        return $sent;
    }

    public function deliveryStatus()
    {
        $total = $this->ecardsentrecipients()->count();
        $sent = $this->ecardsentrecipients()->whereNotNull('sent_date')->count();
        $sentnull = $this->ecardsentrecipients()->where('sent_date', '=', null)->count();

        if ($this->draft == 1) {
            $status = 'Draft';
        } elseif ($sentnull == $total) {
            $status = 'Pending';
        } elseif ($sent == $total) {
            $status = 'Sent';
        }

        return $status;
    }

    public function sentDate()
    {
        $sent = $this->ecardsentrecipients()->whereNotNull('sent_date')->first();

        $sentDate = $sent->sent_date;

        return $sentDate;
    }
}
