@extends('layouts.master')
@section('page-header')
Dynamic Video Edit
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Home Page Dynamic Video Edit</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('dynamic-video.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    {!! Form::model($dynamic_video, ['method'=>'PATCH', 'action' => ['DynamicVideoController@update', $dynamic_video->id], 'id' => 'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Video ID</label>
                    {!! Form::text('video', null, ['class'=>'form-control', 'value'=>'{{$dynamic_video->video}}']) !!}
                    <span class="text-danger small">{{$errors->first('video')}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {{Form::submit('Update',['class'=>'btn btn-success'])}}
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@endsection

