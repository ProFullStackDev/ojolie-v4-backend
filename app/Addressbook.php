<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addressbook extends Model
{
    public function scopeUserScope($query)
    {
        return $query->where('user_id',auth()->user()->id);
    }

    public function addressbookgroups()
    {
        return $this->belongsToMany('App\AddressbookGroup','addressbook_group_list','addressbook_id','addressbook_group_id');
    }
}
