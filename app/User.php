<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function member()
    {
        return $this->hasOne('App\Member');
    }

    public function getFullName()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function activereference()
    {
        return $this->morphOne('App\Reference', 'referable',null,'referable_id','active');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function favouritecards()
    {
        return $this->belongsToMany('App\Ecard','favourite_ecards','user_id','ecard_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
