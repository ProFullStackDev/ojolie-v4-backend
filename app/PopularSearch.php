<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopularSearch extends Model
{
    //

    public $table = "popular_searches";

    protected $fillable = [
        'keyword',
        'count',
        'seq',
        'is_new',
        'status'
    ];

    public static function saveKeyWord($keyword=''){

        if(trim($keyword)!==''){

            $exist  = PopularSearch::where('keyword',$keyword)->first();
            if($exist){
                $exist->count=$exist->count+1;
                $exist->save();
            }else{
                PopularSearch::create(
                    [
                        'keyword'=>$keyword,
                        'count'=>1,
                        'seq'=>1,
                        'is_new'=>1,
                        'status'=>1  
                    ]              
                );
            }

        }


    }


    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    public function scopePopular($query)
    {
        $query->orderBy('count', 'desc');
    }
}
