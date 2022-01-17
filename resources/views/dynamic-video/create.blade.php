@extends('layouts.master')
@section('page-header')
Dynamic Video Create
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Home Page Dynamic Video Create</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('dynamic-video.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['url' =>'/dynamic-video/add', 'id'=>'create-form']) !!}

        @csrf

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Video ID</label>
                    {{Form::text('video',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('video')}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {{Form::submit('Save',['class'=>'btn btn-success'])}}
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@endsection

