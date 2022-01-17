<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcardsentRecipient extends Model
{
    protected $guarded = [];

    public function ecardsentitem()
    {
        return $this->belongsTo('App\EcardsentItem','ecardsent_item_id');
    }

    public function ecardsentreply()
    {
        return $this->hasOne('App\EcardsentReply','ecardsent_recipient_id');
    }
}
