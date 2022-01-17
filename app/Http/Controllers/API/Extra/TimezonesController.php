<?php

namespace App\Http\Controllers\API\Extra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimezonesController extends Controller
{
    public function index(Request $request)
    {
        $timezones = timezone_identifiers_list();

        $search = $request->search;

        if($search)
        {
            $filtered = array_filter($timezones,function($timezone)use($search){
                return preg_match("/{$search}/i", strtolower($timezone));
            });

            $filtered = array_values($filtered);
        }
        else
        {
            $filtered = $timezones;
        }

        return response()->json(['data'=>$filtered]);
    }
}
