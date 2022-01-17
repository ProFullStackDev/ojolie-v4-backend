<?php

namespace App\Http\Controllers;

use App\DynamicVideo;

use App\Http\Requests\DynamicVideoRequest;

class DynamicVideoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dynamic_videos = DynamicVideo::all();

        return

            view('dynamic-video.index', compact('dynamic_videos'));
    }

    public function create()
    {
        return view('dynamic-video.create');

    }

    public function add(DynamicVideoRequest $request)
    {
        DynamicVideo::create($request->all());

        return redirect('/dynamic-video/create')->with('success', 'your video id was successfully added.');
    }

    public function edit($id)
    {
        //
        $dynamic_video = DynamicVideo::findOrFail($id);
        return view('dynamic-video.edit', compact('dynamic_video'));
    }

    public function update(DynamicVideoRequest $request, $id)
    {
        //

        DynamicVideo::whereId($id)->first()->update($request->all());

        return back()->with('success', 'Updated Video ID Successfully');
    }

    public function destroy($id)
    {
        DynamicVideo::whereId($id)->delete();

        return redirect('/dynamic-video');

    }
}
