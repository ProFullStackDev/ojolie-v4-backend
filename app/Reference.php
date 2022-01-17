<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    public function referable()
    {
        return $this->morphTo();
    }

    public static function usersActiveOptions()
    {
        $references = Self::where('referable_type','App\User')
                            ->where('column','active')
                            ->pluck('name','referable_id')
                            ->toArray();

        return [''=>'-- Please Select --'] + $references;
    }

    public static function membersTypeOptions()
    {
        $references = Self::where('referable_type','App\Member')
                            ->where('column','type')
                            ->pluck('name','referable_id')
                            ->toArray();

        return [''=>'-- Please Select --'] + $references;
    }
}
