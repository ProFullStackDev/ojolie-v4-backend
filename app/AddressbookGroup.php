<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressbookGroup extends Model
{
    public function addressbooks()
    {
        return $this->belongsToMany('App\Addressbook','addressbook_group_list','addressbook_group_id','addressbook_id');
    }

    public function scopeUserScope($query)
    {
        return $query->where('user_id',auth()->user()->id);
    }
}
