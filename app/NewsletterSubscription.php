<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    //
    public $table = "newsletter_subscription";
    protected $fillable = [

        'email',
        'blacklist'

        ];
}
