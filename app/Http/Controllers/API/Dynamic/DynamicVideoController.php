<?php

namespace App\Http\Controllers\API\Dynamic;

use App\Http\Controllers\Controller;
use App\DynamicVideo;
use App\Http\Resources\DynamicVideoResource;

class DynamicVideoController extends Controller
{
    public function index()
    {

        $dynamic_videos = DynamicVideo::orderBy('id', 'desc')->limit(1)->get();

        return DynamicVideoResource::collection($dynamic_videos);
    }

    public function show($id)
    {
        return new DynamicVideoResource(DynamicVideo::find($id));
    }
}
